<?php

namespace App\Models;
use App\Http\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioContent extends Model {
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function project(){
        return $this->belongsTo(Project::class, 'document_id', 'id');
    }
}


