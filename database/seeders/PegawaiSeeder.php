<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create('id_ID');
        $gender = $faker->randomElement(['male', 'female']);
        $jenisKelamin = ($gender === 'male' ? 'Laki-laki' : 'Perempuan');
        $firstNamePeg = $faker->firstName($gender);
        $lastNamePeg = $faker->lastName($gender);
        DB::table('pegawai')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'status_akun' => 'Aktif',
            'id_role' => 1,
            'nama' => $firstNamePeg.' '.$lastNamePeg,
            'alamat' => $faker->address(),
            'tanggal_lahir' => $faker->date($format = 'Y-m-d', $max = '-20years'),
            'jenis_kelamin' => $jenisKelamin,
            'email' => $firstNamePeg.'.'.$lastNamePeg.'@gmail.com',
            'no_telp' => $faker->phoneNumber(),
            'password' => bcrypt('password123'),
            'url_foto' => $faker->imageUrl(),
        ]);
        Pegawai::factory(9)->create();
    }
}
