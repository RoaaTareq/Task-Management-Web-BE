<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
   
    
        protected $fillable = ['title', 'description', 'due_date', 'priority', 'user_id'];
    
    

    public function categories()
{
    return $this->belongsToMany(Category::class);
}
// In Task.php
public function user()
{
    return $this->belongsTo(User::class);
}

public function assignedUsers()
{
    return $this->belongsToMany(User::class, 'task_user'); // Assuming you have a pivot table named task_user
}


}
