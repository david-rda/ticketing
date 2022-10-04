<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                "name" => "დავით ჭეჭელაშვილი",
                "email" => "davit.chechelashvili@rda.gov.ge",
                "position" => "წამყვანი სპეციალისტი",
                "role" => 1,
                "password" => bcrypt(1234)
            ],
            [
                "name" => "გიორგი ქაცარავა",
                "email" => "giorgi.katsarava@rda.gov.ge",
                "position" => "სამსახურის უფროსი",
                "role" => 1,
                "password" => bcrypt(1234)
            ]
        ]);
    }
}
