<?php

namespace App\Models;
use App\Http\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTemplateCategory extends Model {
    use HasFactory;

    protected $guarded = [];
    public $timestamps = true;

    public function templates(){
        return $this->hasMany(ProjectTemplate::class, 'category')
            ->where('status', 'active')
            ->where('deleted', 0);
    }
    public function templates_new()
{
    return $this->hasMany(ProjectTemplate::class, 'category_id');
}

}