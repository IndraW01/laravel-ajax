<?php

namespace Database\Factories\Mahasiswa;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $prodi = [
            'Sistem Informasi',
            'Informatikan',
            'Teknik Lingkungan',
            'Teknik Sipil',
            'Teknik Elektro',
            'Teknik Industri',
            'Pendidikan PKN',
        ];

        return [
            'nama' => $this->faker->unique()->name(),
            'nim' => $this->faker->unique()->numerify('19##########'),
            'prodi' => $this->faker->randomElement($prodi)
        ];
    }
}
