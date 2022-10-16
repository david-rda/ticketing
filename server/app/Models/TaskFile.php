<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class TaskFile extends Model
{
    use HasFactory;

    protected $table = "files";

    protected $primaryKey = "id";

    protected $fillable = [
        "filename", "task_id"
    ];

    public $timestamps = true;

    public function tasks() {
        return $this->belongsTo(Task::class, "id", "task_id");
    }
}
