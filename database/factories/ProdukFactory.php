<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProdukModel;
use Faker\Generator as Faker;

$factory->define(ProdukModel::class, function (Faker $faker) {
    return [
        'kode_produk' => $faker->unique()->randomNumber,
        'nama' => $faker->unique()->lastName,
        'jumlah' => $faker->numberBetween($min = 1, $max = 1000),
        'harga' => $faker->numberBetween($min = 1000, $max = 1000000),
        // 'kode_role' => $faker->randomElement($kode_role),
        'gambar' => $faker->text,
        'keterangan' => $faker->text,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
