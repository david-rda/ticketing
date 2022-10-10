<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Task;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";

    protected $primaryKey = "id";

    protected $fillable = [
        "name", "email", "position", "role", "password"
    ];

    protected $appends = [
        "task"
    ];

    public $timestamps = false;

    protected $hidden = [
        "user_tasks"
    ];

    public function user_tasks() {
        return $this->hasMany(TaskHasPerformer::class, "performer_id", "id");
    }

    public function getTaskAttribute() {
        return $this->user_tasks;
    }
}

?>