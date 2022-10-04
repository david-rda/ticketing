<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskHasPerformer extends Model
{
    use HasFactory;

    protected $table = "task_has_performers";

    protected $primaryKey = "id";

    protected $fillable = [
        "task_id", "performer_id"
    ];

    public $timestamps = true;
}
