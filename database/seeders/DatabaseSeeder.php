<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder {
    public function run(): void {
        $this->call([
            SiswaSeeder::class,
            Batch1Seeder::class,
            Batch2Seeder::class,
            Batch3Seeder::class,
            UserSeeder::class,
        ]);
    }
}
