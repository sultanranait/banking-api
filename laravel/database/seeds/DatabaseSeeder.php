<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        /* Branches seeder */
        $this->call(BranchSeeder::class);

        /* Customers seeder */
        $this->call(CustomerSeeder::class);

        /* Transfer history seeder */
        $this->call(TransferSeeder::class);
    }
}
