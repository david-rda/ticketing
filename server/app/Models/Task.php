<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Status;

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

    public $timestamps = true;

    public function status() {
        return $this->hasOne(Status::class, "id", "status_id");
    }
}

?>