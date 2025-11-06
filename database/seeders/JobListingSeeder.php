<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\Job;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class JobListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employer1 = Employer::factory()->create([
            'name' => 'John Doe',
            'company' => 'Tech Corp',
        ]);

        $employer2 = Employer::factory()->create([
            'name' => 'Jane Smith',
            'company' => 'Web Solutions Inc',
        ]);

        $employer3 = Employer::factory()->create();

        $employers = [$employer1, $employer2, $employer3];

        $job1 = Job::factory()->create([
            'employer_id' => $employer1->employer_id,
            'title' => 'Senior Software Engineer',
            'salary' => ['USD' => '120000', 'TWD' => '3600000'],
        ]);
        $job1->tags()->attach(
            Tag::whereIn('name', ['Software Engineer', 'Backend Developer', 'Full Stack Developer', 'Developer'])->pluck('tag_id')
        );

        $job2 = Job::factory()->create([
            'employer_id' => $employer2->employer_id,
            'title' => 'Frontend Developer',
            'salary' => ['USD' => '90000', 'TWD' => '2700000'],
        ]);
        $job2->tags()->attach(
            Tag::whereIn('name', ['Frontend Developer', 'Developer'])->pluck('tag_id')
        );

        $job3 = Job::factory()->create([
            'employer_id' => $employer3->employer_id,
            'title' => 'Backend Developer',
            'salary' => ['USD' => '100000', 'TWD' => '3000000'],
        ]);
        $job3->tags()->attach(
            Tag::whereIn('name', ['Backend Developer', 'Developer'])->pluck('tag_id')
        );

        // 會自動建 employer
        Job::factory()->count(3)->create();

        // 用上面手動建的 employer - create 10 jobs referencing the 3 employers
        $employerIds = [$employer1->employer_id, $employer2->employer_id, $employer3->employer_id];

        Job::factory()->count(10)->create([
            'employer_id' => fn () => fake()->randomElement($employerIds),
        ]);
    }
}
