<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'long_description'
    ];

    public function toggleComplete()
    {
        // $this->update([
        //     'completed' => !$this->completed
        // ]);
        $this->completed = !$this->completed;
        $this->save();
    }
}
