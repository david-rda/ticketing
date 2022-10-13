<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Status;
use App\Models\Comment;
use App\Models\TaskHasPerformer;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "tasks";

    protected $primaryKey = "id";

    protected $fillable = [
        "author_user_id",
        "priority_id",
        "status_id",
        "title",
        "description",
        "end_date"
    ];

    protected $dates = [
        "deleted_at"
    ];

    protected $appends = [
        "performers"
    ];

    protected $hidden = [
        "performer"
    ];

    public $timestamps = true;

    public function status() {
        return $this->hasOne(Status::class, "id", "status_id");
    }

    public function comment() {
        return $this->hasMany(Comment::class, "task_id", "id");
    }

    public function performer() {
        return $this->hasMany(TaskHasPerformer::class, "task_id", "id");
    }

    public function endDate() : Attribute {
        return Attribute::make(
            get : fn($value) => $this->asDateTime($value)->setTimezone("Asia/Tbilisi")->format("Y/m/d")
        );
    }

    public function getPerformersAttribute() {
        $ids = array();

        foreach($this->performer as $performers) {
            array_push($ids, $performers);
        }

        return $ids;
    }
}

?>