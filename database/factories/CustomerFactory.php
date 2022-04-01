<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        static $cusId = 1;
        static $countDays = 0;
        $faker = $this->faker;
        $gender = $faker->randomElement(['male', 'female']);
        $jenisKelamin = ($gender === 'male' ? 'Laki-laki' : 'Perempuan');
        if($cusId % 5 == 0) {
            $countDays++;
        }
        $custRegDate = date('ymd', strtotime('February 1 2022 +'.$countDays.' days'));
        $firstNameCust = $faker->firstName($gender);
        $lastNameCust = $faker->lastName($gender);
        $tglLahirCust = $faker->date($format = 'Y-m-d', $max = '-20years');
        $urlSimCust = $faker->randomElement([$faker->imageUrl(), '-']);
        return [
            //
            'id_customer' => 'CUS'.$custRegDate.'-'.$cusId++,
            'nama' => $firstNameCust.' '.$lastNameCust,
            'alamat' => $faker->address(),
            'tanggal_lahir' => $tglLahirCust,
            'jenis_kelamin' => $jenisKelamin,
            'email' => $firstNameCust.'.'.$lastNameCust.'@gmail.com',
            'no_telp' => $faker->phoneNumber(),
            'password' => bcrypt($tglLahirCust),
            'url_sim' => $urlSimCust,
            'url_kartu_identitas' => $faker->imageUrl()
        ];
    }
}
