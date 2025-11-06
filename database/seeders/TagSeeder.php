<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::create([
            'name' => 'Software Engineer',
        ]);
        Tag::create([
            'name' => 'Frontend Developer',
        ]);
        Tag::create([
            'name' => 'Backend Developer',
        ]);
        Tag::create([
            'name' => 'Full Stack Developer',
        ]);
        Tag::create([
            'name' => 'Developer',
        ]);
    }
}
