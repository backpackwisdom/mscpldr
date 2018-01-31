<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GenreTableSeeder::class);
    }
}

class GenreTableSeeder extends Seeder {

    public function run() {
        DB::table('genres')->insert([
            ['c_mufajnev' => 'Ambient'],
            ['c_mufajnev' => 'Breakbeat'],
            ['c_mufajnev' => 'Downtempo'],
            ['c_mufajnev' => 'Drum and bass'],
            ['c_mufajnev' => 'Electro'],
            ['c_mufajnev' => 'Hardcore'],
            ['c_mufajnev' => 'Hardstyle'],
            ['c_mufajnev' => 'House'],
            ['c_mufajnev' => 'Industrial'],
            ['c_mufajnev' => 'IDM'],
            ['c_mufajnev' => 'Techno'],
            ['c_mufajnev' => 'Trance'],
            ['c_mufajnev' => 'Alternative rock'],
            ['c_mufajnev' => 'Indie rock'],
            ['c_mufajnev' => 'Post-punk'],
            ['c_mufajnev' => 'Punk'],
            ['c_mufajnev' => 'Progressive rock'],
            ['c_mufajnev' => 'Metal'],
            ['c_mufajnev' => 'Grunge rock']
        ]);
    }
}