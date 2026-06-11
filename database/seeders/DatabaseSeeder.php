<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ============================================================
        // 0. Injeksi Akun Super Admin (Modul 8.4.1)
        //    Karena tidak ada halaman register terbuka, admin dibuat
        //    langsung dari seeder dengan password ter-enkripsi (bcrypt).
        // ============================================================
        User::firstOrCreate(
            ['email' => 'admin@amikom.ac.id'],
            [
                'name'     => 'Admin Amikom',
                'password' => bcrypt('password'),
                'role'     => 'admin',
            ]
        );

        // 1. Menyiapkan 3 Kategori
        $cat1 = \App\Models\Category::firstOrCreate([
            'name' => 'Teknologi',
            'slug' => 'teknologi',
        ]);

        $cat2 = \App\Models\Category::firstOrCreate([
            'name' => 'E-Sports',
            'slug' => 'e-sports',
        ]);

        $cat3 = \App\Models\Category::firstOrCreate([
            'name' => 'Desain',
            'slug' => 'desain',
        ]);

        // 2. Menanamkan 6 Data Event secara logis dan bervariatif
        \App\Models\Event::firstOrCreate(
            ['title' => 'Web Development Bootcamp 2026'],
            [
                'category_id' => $cat1->id,
                'description' => 'Pelajari cara membangun aplikasi web modern dari nol menggunakan Laravel dan Tailwind CSS.',
                'date'        => '2026-08-15 09:00:00',
                'location'    => 'Lab Komputer 1 Amikom',
                'price'       => 75000,
                'stock'       => 50,
                'poster_path' => 'posters/web-bootcamp.png',
            ]
        );

        \App\Models\Event::firstOrCreate(
            ['title' => 'AI & Data Science Summit'],
            [
                'category_id' => $cat1->id,
                'description' => 'Eksplorasi masa depan Artificial Intelligence bersama para ahli dari industri teknologi terkini.',
                'date'        => '2026-09-01 08:00:00',
                'location'    => 'Amikom Convention Hall',
                'price'       => 150000,
                'stock'       => 200,
                'poster_path' => 'posters/ai-summit.png',
            ]
        );

        \App\Models\Event::firstOrCreate(
            ['title' => 'Amikom E-Sport U-Champ: Mobile Legends'],
            [
                'category_id' => $cat2->id,
                'description' => 'Turnamen Mobile Legends terbesar antar mahasiswa dengan prize pool jutaan rupiah.',
                'date'        => '2026-07-20 13:00:00',
                'location'    => 'Student Center Amikom',
                'price'       => 50000,
                'stock'       => 64,
                'poster_path' => 'posters/mlbb-champ.png',
            ]
        );

        \App\Models\Event::firstOrCreate(
            ['title' => 'Valorant Campus League'],
            [
                'category_id' => $cat2->id,
                'description' => 'Ajang unjuk kemampuan taktis dalam turnamen Valorant bergengsi tingkat kampus.',
                'date'        => '2026-07-25 10:00:00',
                'location'    => 'Amikom Esports Arena',
                'price'       => 60000,
                'stock'       => 32,
                'poster_path' => 'posters/valo-league.png',
            ]
        );

        \App\Models\Event::firstOrCreate(
            ['title' => 'UI/UX Masterclass: Designing for Humans'],
            [
                'category_id' => $cat3->id,
                'description' => 'Tingkatkan skill desain produk digital Anda melalui pendekatan user-centered design secara mendalam.',
                'date'        => '2026-10-10 10:00:00',
                'location'    => 'Ruang Citra 2 Amikom',
                'price'       => 85000,
                'stock'       => 100,
                'poster_path' => 'posters/uiux-masterclass.png',
            ]
        );

        \App\Models\Event::firstOrCreate(
            ['title' => 'Digital Illustration Workshop'],
            [
                'category_id' => $cat3->id,
                'description' => 'Workshop intensif untuk mengasah teknik ilustrasi digital menggunakan berbagai software grafis.',
                'date'        => '2026-11-05 09:00:00',
                'location'    => 'Creative Studio Amikom',
                'price'       => 90000,
                'stock'       => 60,
                'poster_path' => 'posters/digital-illustration.png',
            ]
        );
    }
}