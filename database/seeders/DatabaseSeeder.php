<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        \App\Models\User::create(['name'=>'Admin','email'=>'admin@toko.test','password'=>'password','role'=>'admin']);
        \App\Models\User::create(['name'=>'Kasir 1','email'=>'kasir@toko.test','password'=>'password','role'=>'kasir']);

        $sembako = \App\Models\Category::create(['name'=>'Sembako']);
        $minuman = \App\Models\Category::create(['name'=>'Minuman']);
        $snack   = \App\Models\Category::create(['name'=>'Makanan Ringan']);

        $data = [
            [$sembako,'BRG001','Beras 5kg',68000,20,'sak'],
            [$sembako,'BRG002','Minyak Goreng 1L',18000,30,'btl'],
            [$sembako,'BRG003','Gula Pasir 1kg',17000,25,'kg'],
            [$minuman,'BRG004','Teh Botol 450ml',5000,48,'btl'],
            [$minuman,'BRG005','Air Mineral 600ml',3500,60,'btl'],
            [$snack,  'BRG006','Chitato 68g',11000,15,'pcs'],
        ];
        foreach ($data as [$cat,$code,$name,$price,$stock,$unit]) {
            \App\Models\Product::create([
                'category_id'=>$cat->id,'code'=>$code,'name'=>$name,
                'price'=>$price,'stock'=>$stock,'unit'=>$unit,
            ]);
        }
        \App\Models\Customer::create(['name'=>'Bu Siti','phone'=>'081234567890']);
    }
}