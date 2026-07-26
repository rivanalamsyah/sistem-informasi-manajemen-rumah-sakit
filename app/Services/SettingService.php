<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Backup;
use App\Models\Setting;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingService
{
    /**
     * Mengambil semua setting dan menyajikannya berdasar grup.
     */
    public function getSettingsByGroup(): array
    {
        $settings = Setting::all()->groupBy('group');

        $result = [];
        foreach ($settings as $group => $items) {
            foreach ($items as $st) {
                $result[$group][$st->key] = $st->value;
            }
        }

        return $result;
    }

    /**
     * Memperbarui sekumpulan setting berdasar grup.
     */
    public function updateGroupSettings(string $group, array $data): void
    {
        foreach ($data as $key => $value) {
            if ($key === '_token' || $key === '_method') {
                continue;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'group' => $group,
                    'value' => is_array($value) ? json_encode($value) : (string) $value,
                ]
            );
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'module' => 'Pengaturan',
            'action' => 'Update Settings',
            'description' => "Pengaturan grup '{$group}' telah diperbarui.",
        ]);
    }

    /**
     * Membuat backup database compressed SQL.
     */
    public function createDatabaseBackup(): Backup
    {
        $backupDir = storage_path('app/backups');
        if (! file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $timestamp = date('Ymd_His');
        $filename = "backup_simrs_db_{$timestamp}.sql.gz";
        $filepath = "{$backupDir}/{$filename}";

        $dbHost = config('database.connections.mysql.host', '127.0.0.1');
        $dbPort = config('database.connections.mysql.port', '3306');
        $dbName = config('database.connections.mysql.database', 'simrs_db');
        $dbUser = config('database.connections.mysql.username', 'root');
        $dbPass = config('database.connections.mysql.password', '');

        // Command mysqldump
        $command = "MYSQL_PWD=\"{$dbPass}\" mysqldump --host=\"{$dbHost}\" --port=\"{$dbPort}\" --user=\"{$dbUser}\" --single-transaction --routines --triggers {$dbName} | gzip -9 > \"{$filepath}\"";

        @exec($command, $output, $returnVar);

        // Fallback jika mysqldump CLI tidak tersedia di OS lokal: buat file SQL dump sederhana
        if (! file_exists($filepath) || filesize($filepath) === 0) {
            $tables = DB::select('SHOW TABLES');
            $sql = "-- SIMRS Database Dump - {$timestamp}\n\n";

            foreach ($tables as $table) {
                $tableName = current((array) $table);
                $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";

                $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
                $sql .= $createTable[0]->{'Create Table'}.";\n\n";

                $rows = DB::table($tableName)->get();
                foreach ($rows as $row) {
                    $values = array_map(function ($val) {
                        return is_null($val) ? 'NULL' : "'".addslashes($val)."'";
                    }, (array) $row);

                    $sql .= "INSERT INTO `{$tableName}` VALUES (".implode(', ', $values).");\n";
                }
                $sql .= "\n\n";
            }

            file_put_contents("{$backupDir}/backup_simrs_db_{$timestamp}.sql", $sql);
            $filepath = "{$backupDir}/backup_simrs_db_{$timestamp}.sql";
            $filename = "backup_simrs_db_{$timestamp}.sql";
        }

        $filesize = filesize($filepath);

        $backup = Backup::create([
            'file_name' => $filename,
            'file_path' => "backups/{$filename}",
            'file_size' => $filesize,
            'backup_type' => 'database',
            'status' => 'Sukses',
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'module' => 'Pengaturan',
            'action' => 'Backup Database',
            'description' => "Backup database manual telah dibuat: {$filename}",
        ]);

        return $backup;
    }
}
