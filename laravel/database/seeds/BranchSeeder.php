<?php

use Illuminate\Database\Seeder;
use App\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branches = [
            0 => [
                'name' => 'Main Branch',
                'code' => '0100',
            ],
        ];
        foreach ($branches as $branch){
            Branch::updateOrCreate([
                'code' => $branch['code']
        	],
        	[
                'name' => $branch['name'],
                'code' => $branch['code']
            ]);
        }
    }
}
