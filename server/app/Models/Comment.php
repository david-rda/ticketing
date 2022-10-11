<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Comment extends Model
{
    use HasFactory;

    protected $table = "comments";

    protected $primaryKey = "id";

    protected $fillable = [
        "task_id", "comment"
    ];

    public $timestamps = true;

    public function tasks() {
        return $this->belongsTo(Task::class, "task_id", "id");
    }
}
