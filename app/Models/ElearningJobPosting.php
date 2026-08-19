<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElearningJobPosting extends Model
{
    protected $table = 'elearning_job_postings';

    protected $fillable = [
        'company_name', 'company_website', 'company_photo',
        'position', 'employment_type', 'location', 'description', 'status',
    ];

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }
}