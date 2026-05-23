<?php

namespace Database\Seeders;

use App\Models\SystemUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = SystemUser::where("email","mrsjude@gmail.com")->first();
        if(!$admin){
            SystemUser::create([
                "firstname" => "MRS JUDE",
                "middlename" => "ALLY",
                "lastname" => "SAID",
                "email" => "mrsjude@gmail.com",
                "gender" => "Female",
                "role" => "admin",
                "school_id" => Null,
                "district_id" => Null,
                "password" => Hash::make("12345678"),
            ]);
        }
    }
}
