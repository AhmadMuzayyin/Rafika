<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'username' => 'admin',
            'password' => bcrypt('12345'),
            'kode_skpd' => '2',
            'nama_skpd' => 'Admin',
            'nomor_tlp_kantor' => '12828328',
            'alamat_kantor' => 'Pamekasan',
            'nama_operator' => 'Admin',
            'nomor_tlp_operator' => '12828328',
            'alamat_operator' => 'Sumenep',
            'nama_kpa' => 'Admin',
            'images' => 'default.jpg',
            'isAdmin' => true
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
