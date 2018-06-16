<?php

use App\Models\User;
use App\Models\UserAddress;
use Faker\Generator as Faker;

$factory->define(UserAddress::class, function (Faker $faker) {
    $addresses = [
        ["北京市", "市辖区", "东城区"],
        ["河北省", "石家庄市", "长安区"],
        ["江苏省", "南京市", "浦口区"],
        ["江苏省", "苏州市", "相城区"],
        ["广东省", "深圳市", "福田区"],
    ];
    $address = $faker->randomElement($addresses);
    $user_ids = User::all()->pluck('id')->toArray();
    $user_id = $faker->randomElement($user_ids);
    return [
        'province'=>$address[0],
        'city' => $address[1],
        'district' => $address[2],
        'address'=>sprintf('第%d街道第%d号',$faker->randomNumber(3),$faker->randomNumber(6)),
        'zip'=>$faker->postcode,
        'contact_name'=>$faker->name,
        'contact_phone'=>$faker->phoneNumber,
        'created_at'=>$faker->dateTime(),
        'updated_at'=>$faker->dateTime(),
        'user_id'=>$user_id
    ];
});
