<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
// use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // for($i=0; $i<30; $i++) {
        //     $name = fake()->name();
        //     $email = fake()->unique()->safeEmail();
        //     $password = fake()->unique()->password();
        //     /* Due modi per inserire dati nella tabella
        //         Tramite segnaposti dove andiamo a specificare in che tabella inserire i dati ed il relativo array dati
        //             oppure
        //         Tramite il metodo table('nometabella')->insert() dove si passa l'array con i dati e le variabili
        //     */
        //     /* 1° METODO
        //     $sql = 'insert into users (name, email, password, created_at, email_verified_at) values(?, ?, ?, ?, ?)';
        //     DB::insert($sql, [$name, $email, Hash::make($password), Carbon::now(), Carbon::now() ]);
        //     */
        //     //2° METODO
        //     DB::table('users')->insert([
        //         'name' => $name,
        //         'email' => $email,
        //         'password' => Hash::make($password),
        //         'created_at' => Carbon::now(),
        //         'email_verified_at' => Carbon::now(),
        //     ]);
        // }

        // ALTRIMENTI SI UTILIZZA LA FACTORY
        \App\Models\User::factory(30)->create();
    }
}
