<?php

namespace App\Models;

class Job
{
    /**
     * @var array<int, array{id: int, title: string, salary: string}>
     */
    protected static array $jobs = [
        ['id' => 1, 'title' => 'Senior Software Engineer', 'salary' => '$120,000'],
        ['id' => 2, 'title' => 'Frontend Developer', 'salary' => '$90,000'],
        ['id' => 3, 'title' => 'Backend Developer', 'salary' => '$100,000'],
    ];

    /**
     * Get all jobs.
     *
     * @return array<int, array{id: int, title: string, salary: string}>
     */
    public static function all(): array
    {
        return self::$jobs;
    }

    /**
     * Find a job by ID.
     *
     * @return array{id: int, title: string, salary: string}|null
     */
    public static function find(int $id): ?array
    {
        return collect(self::$jobs)->firstWhere('id', $id);
    }
}
