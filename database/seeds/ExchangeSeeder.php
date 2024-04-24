<?php

use Illuminate\Database\Seeder;

class ExchangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('exchanges')->insert(
            array(
                [
                    'amount'     	    => 3.68,
                    'origin'            => 'USD',
                    'destination'       => 'PEN'
                ],
                [
                    'amount'     	    => 0.27,
                    'origin'            => 'PEN',
                    'destination'       => 'USD'
                ],
                [
                    'amount'     	    => 3.93,
                    'origin'            => 'EUR',
                    'destination'       => 'PEN'
                ],
                [
                    'amount'     	    => 0.25,
                    'origin'            => 'PEN',
                    'destination'       => 'EUR'
                ],                
            )
        );
    }
}
