<?php

namespace Database\Seeders;

use App\Models\LoanType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LoanTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [ 
            [ 'name' => 'daily', 'interest' => 5, 'description' => 'daily payment' ],
            [ 'name' => '15Days', 'interest' => 10, 'description' => '15days payment' ],
            [ 'name' => 'monthly', 'interest' => 15, 'description' => 'monthly payment' ],
         ];
        
        foreach($types as $type)
        {
           LoanType::factory()->create([
                'type' => $type['name'],
                'interest' => $type['interest'],
                'description' => $type['description'],
                'user_id' => 1,
           ]);
        }
        
    }
}
