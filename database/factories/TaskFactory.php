<?php

namespace Database\Factories;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'title'=> $this->faker->sentence(3),
            'description' => $this->faker->paragraph(7),
            'comment' =>$this->faker->paragraph(2),
            'priority' =>$this->faker->numberBetween(1,5),
            'estimatedEffort' =>$this->faker->numberBetween(1,100),
            'totalEffort' =>$this->faker->numberBetween(1,100),
            'completed' => false,
            'visibility'=>$this->faker->boolean(),
            
        ];
    }
}
