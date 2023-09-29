<?php

namespace App\Models;
use App\Http\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteTemplate extends Model {
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function template(){
        return $this->belongsTo(ProjectTemplate::class, 'template_id', 'id');
    }
}
