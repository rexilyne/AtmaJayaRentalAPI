<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static $drivId = 1;
        static $countDays = 0;
        $faker = $this->faker;
        $gender = $faker->randomElement(['male', 'female']);
        $jenisKelamin = ($gender === 'male' ? 'Laki-laki' : 'Perempuan');
        $firstNameDriv = $faker->firstName($gender);
        $lastNameDriv = $faker->lastName($gender);
        $bahasaDriv = $faker->randomElement(['Indonesia', 'Inggris', 'Indonesia & Inggris']);
        $statusDriv = $faker->randomElement(['Available', 'Not Available']);
        $tarifDriv = $faker->randomElement([10000.0, 15000.0, 20000.0, 25000.0, 30000.0]);
        $rerataRating = $faker->randomElement([4.0, 4.2, 4.5, 4.7, 4.9]);
        $tglLahirDriv = $faker->date($format = 'Y-m-d', $max = '-20years');

        $drivRegDate = date('ymd', strtotime('February 1 2022 +'.$countDays.' days'));
        return [
            //
            'id_driver' => 'DRV'.$drivRegDate.'-'.$drivId++,
            'nama' => $firstNameDriv.' '.$lastNameDriv,
            'alamat' => $faker->address(),
            'tanggal_lahir' => $tglLahirDriv,
            'jenis_kelamin' => $jenisKelamin,
            'email' => $firstNameDriv.'.'.$lastNameDriv.'@gmail.com',
            'no_telp' => $faker->phoneNumber(),
            'bahasa' => $bahasaDriv,
            'status_driver' => $statusDriv,
            'password' => bcrypt($tglLahirDriv),
            'tarif_driver' => $tarifDriv,
            'rerata_rating' => $rerataRating,
            'url_sim' => $faker->imageUrl(),
            'url_surat_bebas_napza' => $faker->imageUrl(),
            'url_surat_kesehatan_jiwa' => $faker->imageUrl(),
            'url_skck' => $faker->imageUrl(),
        ];
    }
}
