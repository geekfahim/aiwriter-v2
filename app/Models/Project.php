<?php

namespace App\Models;
use App\Http\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model {
    use HasFactory;
    use HasUuid;

    protected $guarded = [];
    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category(){
        return $this->belongsTo(ProjectTemplate::class, 'template_id', 'id');
    }

    public static function getTopTwoCategories(){
        return self::selectRaw('project_templates.*, count(*) as total')
            ->join('project_templates', 'project_templates.id', '=', 'projects.template_id')
            ->where('project_templates.name', '!=', 'freestyle')
            ->groupBy('projects.template_id')
            ->orderByDesc('total')
            ->limit(2)
            ->get();
    }
}
