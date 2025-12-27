<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kategori>
 */
class KategoriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Kategori::class;
    public function definition(): array
    {
        return [
            'nama_kategori' => $this->faker->randomElement([
                'Laptop',
                'Monitor',
                'RAM',
                'SSD',
                'Keyboard',
                'Mouse',
                'Printer',
                'Kursi Gaming',
                'Meja Komputer',
            ])
        ];
    }
}
