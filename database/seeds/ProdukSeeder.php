<?php

use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\ProdukModel::class, 50)->create()->each(function($post){
            $post->save();
        });
    }
}
