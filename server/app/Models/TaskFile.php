<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Task;

class TaskFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "files";

    protected $primaryKey = "id";

    protected $fillable = [
        "file", "task_id"
    ];

    protected $dates = [
        "deleted_at"
    ];

    public $timestamps = true;

    public function tasks() {
        return $this->belongsTo(Task::class, "id", "task_id");
    }
}
