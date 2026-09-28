<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

/**
 * PublicController
 *
 * Menangani seluruh halaman publik (website resmi) RSU Rajawali Citra.
 * Tidak memerlukan autentikasi.
 */
class PublicController extends Controller
{
    /**
     * Homepage RSU Rajawali Citra.
     */
    public function home(): View
    {
        $data = [
            'services' => $this->getServices(),
            'doctors'  => $this->getDoctors(),
            'stats'    => $this->getStats(),
            'faqs'     => $this->getHomeFaqs(),
            'articles' => $this->getArticles(),
            'news'     => $this->getNews(),
        ];
        return view('public.home', $data);
    }

    /**
     * Halaman Tentang Kami.
     */
    public function about(): View
    {
        return view('public.about');
    }

    /**
     * Halaman Layanan (daftar semua layanan).
     */
    public function services(): View
    {
        $data = [
            'services' => $this->getServices(),
        ];
        return view('public.services', $data);
    }

    /**
     * Halaman Detail Layanan.
     */
    public function serviceDetail(string $slug): View
    {
        $services = collect($this->getServices());
        $service  = $services->firstWhere('slug', $slug);

        abort_if(! $service, 404);

        return view('public.service-detail', compact('service'));
    }

    /**
     * Halaman Dokter & Tenaga Medis.
     */
    public function doctors(): View
    {
        $data = [
            'doctors' => $this->getDoctors(),
        ];
        return view('public.doctors', $data);
    }

    /**
     * Halaman Detail Profil Dokter.
     */
    public function doctorDetail(string $slug): View
    {
        $doctors = collect($this->getDoctors());
        $doctor  = $doctors->firstWhere('slug', $slug);

        abort_if(! $doctor, 404);

        return view('public.doctor-detail', compact('doctor'));
    }

    /**
     * Halaman Informasi (hub berita, artikel, FAQ, dll).
     */
    public function information(): View
    {
        $data = [
            'news'     => $this->getNews(),
            'articles' => $this->getArticles(),
            'faqs'     => $this->getFullFaqs(),
        ];
        return view('public.information', $data);
    }

    /**
     * Halaman Daftar Berita.
     */
    public function news(): View
    {
        $data = [
            'news' => $this->getNews(),
        ];
        return view('public.news', $data);
    }

    /**
     * Halaman Detail Berita.
     */
    public function newsDetail(string $slug): View
    {
        $allNews = collect($this->getNews());
        $news    = $allNews->firstWhere('slug', $slug);

        abort_if(! $news, 404);

        $related = $allNews->where('slug', '!=', $slug)->take(3)->values()->all();

        return view('public.news-detail', compact('news', 'related'));
    }

    /**
     * Halaman Daftar Artikel Kesehatan.
     */
    public function articles(): View
    {
        $data = [
            'articles' => $this->getArticles(),
        ];
        return view('public.articles', $data);
    }

    /**
     * Halaman Detail Artikel Kesehatan.
     */
    public function articleDetail(string $slug): View
    {
        $allArticles = collect($this->getArticles());
        $article     = $allArticles->firstWhere('slug', $slug);

        abort_if(! $article, 404);

        $related = $allArticles->where('slug', '!=', $slug)->take(3)->values()->all();

        return view('public.article-detail', compact('article', 'related'));
    }

    /**
     * Halaman FAQ.
     */
    public function faq(): View
    {
        $data = [
            'faqs' => $this->getFullFaqs(),
        ];
        return view('public.faq', $data);
    }

    /**
     * Halaman Kontak.
     */
    public function contact(): View
    {
        return view('public.contact');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // DATA STATIS (Placeholder terstruktur — siap digantikan dengan DB/API)
    // ─────────────────────────────────────────────────────────────────────────

    protected function getStats(): array
    {
        return [
            ['value' => '120+', 'label' => 'Tempat Tidur', 'icon' => 'bed-double'],
            ['value' => '50+',  'label' => 'Dokter Spesialis', 'icon' => 'stethoscope'],
            ['value' => '15+',  'label' => 'Poliklinik', 'icon' => 'building-2'],
            ['value' => '24/7', 'label' => 'Layanan Darurat IGD', 'icon' => 'ambulance'],
        ];
    }

    protected function getServices(): array
    {
        return [
            [
                'slug'        => 'instalasi-gawat-darurat',
                'name'        => 'Instalasi Gawat Darurat (IGD)',
                'short'       => 'Layanan darurat 24 jam siap menangani kondisi kritis dengan tim medis terlatih.',
                'description' => 'IGD RSU Rajawali Citra beroperasi 24 jam penuh dengan tim dokter jaga dan perawat terlatih. Dilengkapi peralatan resusitasi, monitoring vital signs, dan akses langsung ke laboratorium serta radiologi untuk penanganan cepat dan tepat.',
                'icon'        => 'ambulance',
                'color'       => 'red',
                'features'    => ['Tim dokter jaga 24 jam', 'Resusitasi & stabilisasi', 'Triage sistem prioritas', 'Koordinasi rawat inap'],
                'hours'       => '24 Jam / 7 Hari',
                'location'    => 'Gedung Utama — Lantai 1',
            ],
            [
                'slug'        => 'rawat-jalan-poliklinik',
                'name'        => 'Rawat Jalan & Poliklinik',
                'short'       => 'Lebih dari 15 poliklinik spesialis dengan dokter berpengalaman dan sistem antrean digital.',
                'description' => 'RSU Rajawali Citra menyediakan layanan rawat jalan dengan lebih dari 15 poliklinik spesialis. Pasien dapat mendaftar secara online maupun langsung, dan mendapatkan pelayanan dengan sistem antrean digital yang efisien.',
                'icon'        => 'stethoscope',
                'color'       => 'blue',
                'features'    => ['15+ Poliklinik spesialis', 'Pendaftaran online & offline', 'Antrean digital', 'Rekam medis elektronik'],
                'hours'       => 'Sen–Sab 07.00–20.00',
                'location'    => 'Gedung Poliklinik — Lantai 1 & 2',
            ],
            [
                'slug'        => 'rawat-inap',
                'name'        => 'Rawat Inap',
                'short'       => 'Fasilitas rawat inap dengan berbagai kelas kamar, dilengkapi monitoring 24 jam oleh perawat terlatih.',
                'description' => 'Ruang rawat inap RSU Rajawali Citra tersedia dalam berbagai pilihan kelas mulai dari VVIP, VIP, Kelas I, II, dan III. Setiap kamar dilengkapi dengan fasilitas modern dan dipantau oleh perawat terlatih selama 24 jam.',
                'icon'        => 'bed-double',
                'color'       => 'green',
                'features'    => ['120+ tempat tidur', 'Kelas VVIP, VIP, I, II, III', 'Monitoring 24 jam', 'Kamar isolasi tersedia'],
                'hours'       => '24 Jam / 7 Hari',
                'location'    => 'Gedung Rawat Inap — Lantai 2, 3, 4',
            ],
            [
                'slug'        => 'laboratorium-klinik',
                'name'        => 'Laboratorium Klinik',
                'short'       => 'Pemeriksaan laboratorium lengkap dengan peralatan modern dan hasil akurat dalam waktu singkat.',
                'description' => 'Laboratorium RSU Rajawali Citra menggunakan peralatan diagnostik modern dengan sistem otomasi untuk menghasilkan pemeriksaan yang akurat dan cepat. Tersedia pemeriksaan hematologi, kimia darah, urinalisis, mikrobiologi, dan patologi klinik.',
                'icon'        => 'flask-conical',
                'color'       => 'purple',
                'features'    => ['Hematologi & kimia darah', 'Urinalisis & mikrobiologi', 'Hasil cepat 1–3 jam', 'Pengambilan sampel di tempat'],
                'hours'       => '24 Jam (emergency)',
                'location'    => 'Gedung Penunjang — Lantai 1',
            ],
            [
                'slug'        => 'radiologi-imaging',
                'name'        => 'Radiologi & Imaging',
                'short'       => 'Pemeriksaan radiologi diagnostik modern termasuk X-Ray, USG, dan CT-Scan untuk diagnosis akurat.',
                'description' => 'Instalasi Radiologi RSU Rajawali Citra dilengkapi dengan teknologi imaging terkini untuk mendukung diagnosis yang akurat. Tersedia X-Ray digital, ultrasonografi (USG), dan CT-Scan dengan pembacaan hasil oleh dokter spesialis radiologi.',
                'icon'        => 'scan',
                'color'       => 'cyan',
                'features'    => ['X-Ray digital', 'USG 2D & 4D', 'CT-Scan multislice', 'Radiologi intervensi'],
                'hours'       => 'Sen–Sab 07.00–21.00',
                'location'    => 'Gedung Penunjang — Lantai 1',
            ],
            [
                'slug'        => 'farmasi-apotek',
                'name'        => 'Farmasi & Apotek',
                'short'       => 'Apotek rumah sakit dengan stok obat lengkap dan layanan konsultasi apoteker profesional.',
                'description' => 'Instalasi Farmasi RSU Rajawali Citra menyediakan layanan dispensing obat resep dan non-resep dengan stok obat generik dan branded yang lengkap. Tim apoteker siap memberikan konsultasi terkait penggunaan obat yang tepat dan aman.',
                'icon'        => 'pill',
                'color'       => 'orange',
                'features'    => ['Stok obat lengkap', 'Resep elektronik', 'Konsultasi apoteker', 'Pengiriman ke kamar'],
                'hours'       => '07.00–22.00 (rawat jalan)',
                'location'    => 'Gedung Utama — Lantai 1',
            ],
            [
                'slug'        => 'medical-check-up',
                'name'        => 'Medical Check-Up',
                'short'       => 'Paket pemeriksaan kesehatan komprehensif untuk individu, korporat, dan calon tenaga kerja.',
                'description' => 'Program Medical Check-Up RSU Rajawali Citra dirancang untuk deteksi dini penyakit dan pemantauan kesehatan secara berkala. Tersedia paket MCU untuk individu, korporat, CPNS/TNI/POLRI, dan pre-employment.',
                'icon'        => 'clipboard-check',
                'color'       => 'teal',
                'features'    => ['Paket individu & korporat', 'Pemeriksaan komprehensif', 'Laporan hasil lengkap', 'Konsultasi dokter'],
                'hours'       => 'Sen–Sab 07.00–12.00',
                'location'    => 'Gedung MCU — Lantai 1',
            ],
            [
                'slug'        => 'kebidanan-kandungan',
                'name'        => 'Kebidanan & Kandungan',
                'short'       => 'Layanan kesehatan wanita meliputi persalinan normal, SC, ANC, dan perawatan bayi baru lahir.',
                'description' => 'Poli Kebidanan dan Kandungan RSU Rajawali Citra memberikan pelayanan kesehatan reproduksi wanita secara komprehensif, mulai dari antenatal care (ANC), persalinan normal & SC, hingga perawatan bayi baru lahir di ruang perinatologi.',
                'icon'        => 'heart-pulse',
                'color'       => 'pink',
                'features'    => ['Antenatal care (ANC)', 'Persalinan normal & SC', 'Perinatologi & NICU', 'KB & kesehatan reproduksi'],
                'hours'       => 'Sen–Sab 08.00–14.00 (Poli)',
                'location'    => 'Gedung Poliklinik — Lantai 2',
            ],
        ];
    }

    protected function getDoctors(): array
    {
        return [
            [
                'slug'          => 'dr-andi-prasetyo-sp-pd',
                'name'          => 'dr. Andi Prasetyo, Sp.PD',
                'specialization'=> 'Spesialis Penyakit Dalam',
                'education'     => ['S1 Kedokteran — Universitas Gadjah Mada', 'Sp. Penyakit Dalam — Universitas Indonesia'],
                'experience'    => '15 Tahun',
                'polyclinic'    => 'Poli Penyakit Dalam',
                'schedule'      => [
                    ['day' => 'Senin', 'time' => '09.00 – 13.00'],
                    ['day' => 'Rabu',  'time' => '09.00 – 13.00'],
                    ['day' => 'Jumat', 'time' => '09.00 – 12.00'],
                ],
                'services'      => ['Konsultasi penyakit dalam', 'Penanganan diabetes mellitus', 'Hipertensi & kardiovaskular', 'Gastroenterologi'],
                'color'         => 'blue',
                'initials'      => 'AP',
            ],
            [
                'slug'          => 'dr-siti-rahayu-sp-og',
                'name'          => 'dr. Siti Rahayu, Sp.OG',
                'specialization'=> 'Spesialis Obstetri & Ginekologi',
                'education'     => ['S1 Kedokteran — Universitas Diponegoro', 'Sp. Obgyn — Universitas Gadjah Mada'],
                'experience'    => '12 Tahun',
                'polyclinic'    => 'Poli Kebidanan & Kandungan',
                'schedule'      => [
                    ['day' => 'Selasa', 'time' => '08.00 – 14.00'],
                    ['day' => 'Kamis',  'time' => '08.00 – 14.00'],
                    ['day' => 'Sabtu',  'time' => '08.00 – 12.00'],
                ],
                'services'      => ['Antenatal care (ANC)', 'Persalinan normal & SC', 'USG kandungan 2D/4D', 'Kesehatan reproduksi wanita'],
                'color'         => 'pink',
                'initials'      => 'SR',
            ],
            [
                'slug'          => 'dr-budi-santoso-sp-b',
                'name'          => 'dr. Budi Santoso, Sp.B',
                'specialization'=> 'Spesialis Bedah Umum',
                'education'     => ['S1 Kedokteran — Universitas Airlangga', 'Sp. Bedah Umum — Universitas Indonesia'],
                'experience'    => '18 Tahun',
                'polyclinic'    => 'Poli Bedah',
                'schedule'      => [
                    ['day' => 'Senin',  'time' => '13.00 – 17.00'],
                    ['day' => 'Rabu',   'time' => '13.00 – 17.00'],
                    ['day' => 'Jumat',  'time' => '13.00 – 16.00'],
                ],
                'services'      => ['Bedah umum elektif', 'Appendektomi laparoskopi', 'Hernia repair', 'Bedah digestif'],
                'color'         => 'green',
                'initials'      => 'BS',
            ],
            [
                'slug'          => 'dr-maya-dewi-sp-a',
                'name'          => 'dr. Maya Dewi, Sp.A',
                'specialization'=> 'Spesialis Anak',
                'education'     => ['S1 Kedokteran — Universitas Gadjah Mada', 'Sp. Anak — Universitas Gadjah Mada'],
                'experience'    => '10 Tahun',
                'polyclinic'    => 'Poli Anak',
                'schedule'      => [
                    ['day' => 'Senin',  'time' => '07.00 – 11.00'],
                    ['day' => 'Selasa', 'time' => '13.00 – 17.00'],
                    ['day' => 'Kamis',  'time' => '07.00 – 11.00'],
                    ['day' => 'Sabtu',  'time' => '07.00 – 11.00'],
                ],
                'services'      => ['Tumbuh kembang anak', 'Imunisasi & vaksinasi', 'Neonatologi', 'Gizi anak'],
                'color'         => 'orange',
                'initials'      => 'MD',
            ],
            [
                'slug'          => 'dr-ahmad-fauzi-sp-jp',
                'name'          => 'dr. Ahmad Fauzi, Sp.JP',
                'specialization'=> 'Spesialis Jantung & Pembuluh Darah',
                'education'     => ['S1 Kedokteran — Universitas Indonesia', 'Sp. Kardiovaskular — Universitas Indonesia'],
                'experience'    => '20 Tahun',
                'polyclinic'    => 'Poli Jantung',
                'schedule'      => [
                    ['day' => 'Selasa', 'time' => '08.00 – 12.00'],
                    ['day' => 'Kamis',  'time' => '08.00 – 12.00'],
                ],
                'services'      => ['EKG & ekokardiografi', 'Penanganan aritmia', 'Gagal jantung', 'Hipertensi kardiovaskular'],
                'color'         => 'red',
                'initials'      => 'AF',
            ],
            [
                'slug'          => 'dr-indah-lestari-sp-s',
                'name'          => 'dr. Indah Lestari, Sp.S',
                'specialization'=> 'Spesialis Saraf',
                'education'     => ['S1 Kedokteran — Universitas Brawijaya', 'Sp. Neurologi — Universitas Gadjah Mada'],
                'experience'    => '8 Tahun',
                'polyclinic'    => 'Poli Saraf',
                'schedule'      => [
                    ['day' => 'Rabu',   'time' => '14.00 – 18.00'],
                    ['day' => 'Jumat',  'time' => '14.00 – 17.00'],
                    ['day' => 'Sabtu',  'time' => '09.00 – 12.00'],
                ],
                'services'      => ['Stroke & rehabilitasi', 'Sakit kepala & migrain', 'Epilepsi', 'Gangguan keseimbangan'],
                'color'         => 'purple',
                'initials'      => 'IL',
            ],
        ];
    }

    protected function getNews(): array
    {
        return [
            [
                'slug'     => 'rsu-rajawali-citra-raih-akreditasi-paripurna',
                'title'    => 'RSU Rajawali Citra Raih Akreditasi Paripurna dari KARS',
                'excerpt'  => 'RSU Rajawali Citra berhasil meraih akreditasi paripurna dari Komisi Akreditasi Rumah Sakit (KARS) setelah melalui proses survei yang ketat.',
                'content'  => 'RSU Rajawali Citra berhasil meraih status akreditasi paripurna dari Komisi Akreditasi Rumah Sakit (KARS) pada tahun ini. Pencapaian ini merupakan bukti komitmen rumah sakit dalam memberikan pelayanan kesehatan berkualitas dan aman bagi masyarakat.',
                'date'     => '15 September 2026',
                'category' => 'Prestasi',
                'color'    => 'blue',
            ],
            [
                'slug'     => 'program-vaksinasi-gratis-warga-bantul',
                'title'    => 'Program Vaksinasi Gratis untuk Warga Bantul',
                'excerpt'  => 'RSU Rajawali Citra bekerja sama dengan Dinas Kesehatan Bantul menyelenggarakan program vaksinasi gratis bagi warga sekitar.',
                'content'  => 'Sebagai bentuk tanggung jawab sosial kepada masyarakat, RSU Rajawali Citra bekerja sama dengan Dinas Kesehatan Kabupaten Bantul menyelenggarakan program vaksinasi gratis.',
                'date'     => '10 September 2026',
                'category' => 'Program',
                'color'    => 'green',
            ],
            [
                'slug'     => 'pembukaan-poli-orthopedi-baru',
                'title'    => 'Pembukaan Poli Ortopedi & Traumatologi Baru',
                'excerpt'  => 'RSU Rajawali Citra membuka layanan Poli Ortopedi dengan dokter spesialis ortopedi berpengalaman untuk melayani pasien tulang dan sendi.',
                'content'  => 'Dalam rangka meningkatkan kualitas layanan, RSU Rajawali Citra resmi membuka Poli Ortopedi & Traumatologi yang akan melayani pasien dengan gangguan muskuloskeletal.',
                'date'     => '5 September 2026',
                'category' => 'Layanan Baru',
                'color'    => 'orange',
            ],
        ];
    }

    protected function getArticles(): array
    {
        return [
            [
                'slug'     => 'tips-menjaga-kesehatan-jantung',
                'title'    => '7 Tips Efektif Menjaga Kesehatan Jantung',
                'excerpt'  => 'Penyakit jantung masih menjadi penyebab kematian utama di Indonesia. Berikut 7 langkah sederhana yang bisa Anda lakukan setiap hari.',
                'content'  => 'Penyakit jantung adalah kondisi serius yang memerlukan perhatian. Dengan gaya hidup sehat, risiko penyakit jantung dapat dikurangi secara signifikan.',
                'date'     => '20 September 2026',
                'category' => 'Kesehatan Jantung',
                'author'   => 'dr. Ahmad Fauzi, Sp.JP',
                'color'    => 'red',
            ],
            [
                'slug'     => 'panduan-imunisasi-bayi-anak',
                'title'    => 'Panduan Lengkap Imunisasi Bayi dan Anak',
                'excerpt'  => 'Imunisasi adalah investasi terbaik untuk melindungi anak dari penyakit berbahaya. Kenali jadwal dan jenis vaksin yang direkomendasikan.',
                'content'  => 'Imunisasi merupakan salah satu intervensi kesehatan paling cost-effective untuk mencegah penyakit infeksi pada anak.',
                'date'     => '18 September 2026',
                'category' => 'Kesehatan Anak',
                'author'   => 'dr. Maya Dewi, Sp.A',
                'color'    => 'orange',
            ],
            [
                'slug'     => 'mengenal-diabetes-mellitus',
                'title'    => 'Mengenal Diabetes Mellitus dan Cara Pengelolaannya',
                'excerpt'  => 'Diabetes Mellitus adalah penyakit metabolik yang terus meningkat kasusnya di Indonesia. Pelajari gejala, diagnosis, dan pengelolaannya.',
                'content'  => 'Diabetes Mellitus merupakan gangguan metabolisme gula darah yang ditandai dengan kadar glukosa darah yang tinggi secara kronis.',
                'date'     => '12 September 2026',
                'category' => 'Penyakit Dalam',
                'author'   => 'dr. Andi Prasetyo, Sp.PD',
                'color'    => 'blue',
            ],
        ];
    }

    protected function getHomeFaqs(): array
    {
        return [
            [
                'q' => 'Bagaimana cara mendaftar sebagai pasien baru?',
                'a' => 'Pasien baru dapat mendaftar langsung di loket pendaftaran RSU Rajawali Citra dengan membawa KTP dan kartu BPJS (jika ada). Pendaftaran dibuka mulai pukul 07.00 WIB.',
            ],
            [
                'q' => 'Apakah RSU Rajawali Citra menerima pasien BPJS Kesehatan?',
                'a' => 'Ya, RSU Rajawali Citra menerima pasien dengan jaminan BPJS Kesehatan untuk layanan rawat jalan dan rawat inap sesuai ketentuan yang berlaku.',
            ],
            [
                'q' => 'Apa saja fasilitas kamar rawat inap yang tersedia?',
                'a' => 'Tersedia pilihan kamar VVIP, VIP, Kelas I, Kelas II, dan Kelas III. Setiap kamar dilengkapi dengan fasilitas TV, AC, dan kamar mandi dalam.',
            ],
            [
                'q' => 'Bagaimana cara menghubungi IGD RSU Rajawali Citra?',
                'a' => 'Untuk kondisi darurat, IGD RSU Rajawali Citra dapat dihubungi melalui nomor (0274) 123-4567 atau langsung datang ke Instalasi Gawat Darurat yang beroperasi 24 jam.',
            ],
        ];
    }

    protected function getFullFaqs(): array
    {
        $home = $this->getHomeFaqs();
        $additional = [
            [
                'q' => 'Jam berapa poliklinik dibuka?',
                'a' => 'Poliklinik rawat jalan RSU Rajawali Citra buka Senin–Sabtu mulai pukul 07.00–20.00 WIB. Jadwal dokter dapat bervariasi, silakan cek halaman Dokter & Jadwal Praktik.',
            ],
            [
                'q' => 'Apakah tersedia layanan konsultasi dokter secara online?',
                'a' => 'Saat ini RSU Rajawali Citra melayani konsultasi tatap muka di poliklinik. Untuk informasi terbaru mengenai layanan telemedisin, silakan hubungi kami.',
            ],
            [
                'q' => 'Apakah ada fasilitas parkir yang memadai?',
                'a' => 'Ya, RSU Rajawali Citra menyediakan area parkir yang luas untuk kendaraan roda dua dan roda empat, tersedia di area depan dan belakang gedung rumah sakit.',
            ],
            [
                'q' => 'Bagaimana cara mendapatkan surat keterangan sehat?',
                'a' => 'Surat keterangan sehat dapat diperoleh melalui poliklinik umum RSU Rajawali Citra. Pasien cukup mendaftar di loket pendaftaran dan akan dilakukan pemeriksaan fisik oleh dokter.',
            ],
        ];
        return array_merge($home, $additional);
    }
}
