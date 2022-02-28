<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = [
        'title',
        'body'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function toArray()
    {
        return [
            'title' => $this->getAttribute('title'),
            'body' => $this->getAttribute('body')
        ];
    }
}
