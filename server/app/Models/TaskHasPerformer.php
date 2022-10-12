<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\User;
use App\Models\Task;

class TaskHasPerformer extends Model
{
    use HasFactory;

    protected $table = "task_has_performers";

    protected $primaryKey = "id";

    protected $fillable = [
        "task_id", "performer_id"
    ];

    public $timestamps = false;

    public function getPerformerIdAttribute($value) {
        return (int)$value;
    }
}
?>