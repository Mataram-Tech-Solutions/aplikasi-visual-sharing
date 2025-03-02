<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FotoFactory extends Factory
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
            'uploaded_by' => $this->faker->numberBetween(1, 10), // Maksimal 10 user
            'albumId' => $this->faker->numberBetween(1, 10), // Maksimal 10 album
            'judul' => $this->faker->sentence(3), // Judul acak
            'unique' => $createdAt->format('YmdHis'), // Unique berdasarkan timestamp + random string
            'namaFile' => $this->faker->imageUrl(640, 480, 'nature', true, 'gambar'), // Gambar dummy
            'deskripsi' => $this->faker->text(100), // Deskripsi acak
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
