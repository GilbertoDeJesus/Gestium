<?php

use Illuminate\Database\Seeder;
use app\Customer;

class customersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('customers')->delete();
        $DataCustomers =['nombre'];
        foreach ($DataCustomers as $key => $value) {
            $Customers= new customers();
            $Customers->nombre= $value;
            $Customers->save();
        }
    }
}
