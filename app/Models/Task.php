<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;
    protected $table = 'tasks';
    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function toArray()
    {
        return [
            'name' => $this->getAttribute('name'),
            'description' => $this->getAttribute('description'),
            'status' => $this->getAttribute('status'),
            'comments' => $this->getRelationValue('comments')
        ];
    }
}
