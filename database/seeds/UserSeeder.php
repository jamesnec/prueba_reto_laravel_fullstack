<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            array(
                [
                    'name'     	    => 'Administrador',
                    'email'         => 'admin@test.com',
                    'password'      => '$2y$10$dbqvMzOiZ61/XgyA5TTWXOSMZnVF5TQVhREv/gRvq/mhZ8evAnLAO' //Hash::make('P@ss123'),
                ],
            )
        );
    }
}
