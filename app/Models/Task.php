<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'due_date', 'priority', 'user_id','is_completed'];

    // Many-to-many relationship with Category
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_task');
    }

    // Many-to-many relationship with User
    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }
}
