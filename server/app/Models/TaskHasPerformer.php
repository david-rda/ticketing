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
        "performer_fullname"
    ];

    public $timestamps = true;

    public function performers() {
        return $this->hasMany(User::class, "id", "performer_id");
    }

    public function performerFullname() : Attribute {
        return Attribute::make(
            get : fn() => $this->performers->name
        );
    }
}
