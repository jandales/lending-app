<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Capital>
 */
class CapitalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'capital' => 50000,
            'less_capital' =>  0,
            'current_capital' => 50000,
            'status' => 1,
        ];
        
    }
}
