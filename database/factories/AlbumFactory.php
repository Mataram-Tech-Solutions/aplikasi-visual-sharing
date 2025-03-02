<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker = \Faker\Factory::create('id_ID'); // Data dalam bahasa Indonesia
        $createdAt = now(); // Timestamp untuk memastikan unique value

        return [
            'created_by' => $this->faker->numberBetween(1, 10), // Maksimal 10 user
            'name' => $this->faker->sentence(3), // Maksimal 10 album
            'deskripsi' => $this->faker->text(100), // Deskripsi acak
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
