<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\User;

class TaskHasPerformer extends Model
{
    use HasFactory;

    protected $table = "task_has_performers";

    protected $primaryKey = "id";

    protected $fillable = [
        "task_id", "performer_id"
    ];

    protected $appends = [
        "tasks"
    ];

    protected $hidden = [
        "task"
    ];

    public $timestamps = true;

    public function task() {
        return $this->hasMany(Task::class, "id", "task_id");
    }

    public function tasks() : Attribute {
        return Attribute::make(
            get : fn() => $this->task
        );
    }
}
?>