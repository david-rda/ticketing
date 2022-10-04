<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "tasks";

    protected $primaryKey = "id";

    protected $fillable = [
        "author_user_id",
        "priority_id",
        "title",
        "description",
        "end_date"
    ];

    protected $dates = [
        "deleted_at"
    ];

    protected $appends = [
        "author_full_name"
    ];

    public $timestamps = true;

    public function author() {
        return $this->hasOne(User::class, "id", "author_user_id");
    }

    public function authorFulName() : Attribute {
        return Attribute::make(
            get : fn() => $this->author->name
        );
    }
}

?>