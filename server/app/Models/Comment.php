<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Task;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;

    protected $table = "comments";

    protected $primaryKey = "id";

    protected $fillable = [
        "task_id", "comment", "author_id"
    ];

    public $timestamps = true;

    protected $appends = [
        "author_full_name"
    ];

    protected $hidden = [
        "author"
    ];

    public function tasks() {
        return $this->belongsTo(Task::class, "task_id", "id");
    }

    public function author() {
        return $this->hasOne(User::class, "id", "author_id");
    }

    public function authorFullName() : Attribute {
        return Attribute::make(
            get : fn() => $this->author->name
        );
    }

    public function getCreatedAtAttribute($value) {
        return $this->asDateTime($value)->setTimezone("Asia/Tbilisi")->format("Y-m-d H:i:s");
    }
}
