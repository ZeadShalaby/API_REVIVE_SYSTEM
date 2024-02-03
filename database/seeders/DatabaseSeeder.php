<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use App\Models\Follow;
use App\Models\Revive;
use App\Models\Comment;
use App\Models\Machine;
use App\Models\Tourism;
use App\Models\Favourite;
use App\Models\Filemachine;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //// todo add one admin ////
        $defAdmin = User::factory()->create([
            'name' => 'Admin',
            'username' => 'Admin',
            'email' => 'Admin@Admin.rev',
            'password' => Hash::make('admin'), 
            'role' =>'1',
            'gmail'=>"zeadshalaby@gmail.com",
            'social_id'=>Hash::make(env("admin_social")),
            ]);
        
        //// todo add one customer ////
        $defOwner = User::factory()->create([  
            'name' => 'Owner',
            'email' => 'owner@owner.rev',
            'password' => Hash::make('owner'), 
            'role' =>'2',
        ]);

        //// todo add one customer ////
        $defCustomer = User::factory()->create([  
            'name' => 'Customer',
            'email' => 'customer@customer.rev',
            'password' => Hash::make('customer'), 
            'role' =>'3',
        ]);

        //// todo add user admin ////
        $admins = User::factory()
        ->admin()
        ->count(4)
        ->create();
        $admins->push($defAdmin);

        //// todo add user customer ////
        $owner = User::factory()
        ->owner()
        ->count(9)
        ->create();
        $owner->push($defOwner);

        //// todo add user customer ////
        $customer = User::factory()
        ->customer()
        ->count(19)
        ->create();
        $customer->push($defCustomer);
        
        //// todo add one Owner ////
        $defcoastal = Machine::factory()->create([
            'name' => "coastal",
            'owner_id' => "2",
            'location'=>"coastal",
            'type'=>Role::COASTAL,
            ]);

        //// todo add one Owner ////
        $deftourism = Machine::factory()->create([  
            'name' => "Tourism",
            'owner_id' => "2",
            'location'=>"Tourism",
            'type'=>Role::TOURISM,
        ]);  
        //// todo add one Owner ////
        $defrevive = Machine::factory()->create([  
            'name' => "Revive",
            'owner_id' => "2",
            'location'=>"Revive",
            'type'=>Role::REVIVE,
        ]); 


    //// todo add user customer ////
    $posts = Post::factory()->count(9)->create();

    //// todo add user customer ////
    $revive = Revive::factory()->count(9)->create();

    //// todo add tourism machine ////
    $tourism = Tourism::factory()->count(9)->create();

    //// todo add user customer ////
    $follow = Follow::factory()->count(9)->create();

    //// todo add user customer ////
    $comment = Comment::factory()->count(9)->create();

    //// todo add user customer ////
    $favourite = Favourite::factory()->count(9)->create();

    //// todo add user customer ////
    $filemachine = Filemachine::factory()->count(9)->create();


    //// todo add  machine coastal ////
    $machinecoastal = MAchine::factory()
    ->coastal()
    ->count(5)
    ->create();
    $machinecoastal->push($defcoastal);

    //// todo add machine tourism ////
    $machinetourism = MAchine::factory()
    ->tourism()
    ->count(5)
    ->create();
    $machinetourism->push($deftourism);

    //// todo add machine revive ////
    $machinerevive = MAchine::factory()
    ->revive()
    ->count(5)
    ->create();
    $machinerevive->push($defrevive);
}}
