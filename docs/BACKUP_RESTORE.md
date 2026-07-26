# Prosedur Operasional Standar (SOP) Backup & Restore

Dokumen ini berisi prosedur operasional standar (SOP) pembuatan cadangan (backup) dan pemulihan (restore) data SIMRS.

---

## 💾 1. Manual Backup via Terminal / CLI

Jalankan perintah pengarsipan dump MySQL terenkripsi terkompresi:
```bash
# Gantikan username & password sesuai .env
mysqldump -u root -p simrs_db | gzip > /var/www/simrs/storage/app/backups/simrs_db_$(date +%Y%m%d_%H%M%S).sql.gz
```

---

## 🔁 2. Prosedur Restore Database CLI

1. Pastikan file backup `.sql.gz` telah diverifikasi.
2. Jalankan dekstrasi dan eksekusi restore ke MySQL:
```bash
gunzip < /var/www/simrs/storage/app/backups/simrs_db_20260726_120000.sql.gz | mysql -u root -p simrs_db
```
3. Bersihkan cache Laravel setelah restore:
```bash
php artisan optimize:clear
```
