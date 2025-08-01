<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    /**
     * This property defines which attributes can be mass assigned.
     * EXAMPLE: 'task_name', 'description', 'status'.
     * @var array<int, string>
     */
    protected $fillable = [
        'task_name',
        'description',
        'status',
    ];
}
