<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::query()->firstOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Admin Test User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        User::query()->where('email', 'admin@example.com')->update(['role' => 'admin']);

        $this->call(CategorySeeder::class);
        $this->call(FinancialDemoSeeder::class);
    }
}
