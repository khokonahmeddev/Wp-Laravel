<?php

namespace App\Models\Submission;

use App\Models\Comment\Comment;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = 'wp_e_submissions';

    public function values(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SubmissionValue::class, 'submission_id', 'id');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class, 'submission_id', 'id');
    }
}
