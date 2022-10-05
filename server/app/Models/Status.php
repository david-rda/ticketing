<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use HasFactory;

    protected $table = "statuses";

    protected $primaryKey = "id";

    protected $fillable = [
        "name"
    ];

    protected $dates = [
        "deleted_at"
    ];

    public $timestamps = true;
}
