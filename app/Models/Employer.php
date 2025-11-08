<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $employer_id
 * @property string $name
 * @property string|null $company
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Job> $jobListings
 * @property-read int|null $job_listings_count
 * @method static \Database\Factories\EmployerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employer whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employer whereEmployerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Employer extends Model
{
    /** @use HasFactory<\Database\Factories\EmployerFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employers';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'employer_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'company',
    ];

    /**
     * Get the job listings for the employer.
     */
    public function jobListings(): HasMany
    {
        return $this->hasMany(Job::class, 'employer_id', 'employer_id');
    }
}
