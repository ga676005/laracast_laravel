<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\Job;
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

        Job::factory()->create([
            'employer_id' => $employer1->id,
            'title' => 'Senior Software Engineer',
            'salary' => ['USD' => '120000', 'TWD' => '3600000'],
        ]);

        Job::factory()->create([
            'employer_id' => $employer2->id,
            'title' => 'Frontend Developer',
            'salary' => ['USD' => '90000', 'TWD' => '2700000'],
        ]);

        Job::factory()->create([
            'employer_id' => $employer3->id,
            'title' => 'Backend Developer',
            'salary' => ['USD' => '100000', 'TWD' => '3000000'],
        ]);

        // 會自動建 employer
        Job::factory()->count(3)->create();

        // 用上面手動建的 employer - create 10 jobs referencing the 3 employers
        $employerIds = [$employer1->id, $employer2->id, $employer3->id];

        Job::factory()->count(10)->create([
            'employer_id' => fn () => fake()->randomElement($employerIds),
        ]);
    }
}
