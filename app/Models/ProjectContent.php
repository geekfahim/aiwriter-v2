<?php

namespace App\Models;
use App\Http\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectContent extends Model {
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;
}
