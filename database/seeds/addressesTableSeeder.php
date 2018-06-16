<?php

use App\Models\UserAddress;
use Illuminate\Database\Seeder;

class addressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = factory(UserAddress::class,9)->make();
        UserAddress::insert($data->toArray());
    }
}
