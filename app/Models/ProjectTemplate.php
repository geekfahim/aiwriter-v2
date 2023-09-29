<?php

namespace App\Models;
use App\Http\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTemplate extends Model {
    use HasFactory;

    protected $guarded = [];
    public $timestamps = true;

    public function templateCategory(){
        return $this->belongsTo(ProjectTemplateCategory::class, 'category', 'id');
    }

    public function category_new()
    {
        return $this->belongsTo(ProjectTemplateCategory::class, 'category');
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory');
    }
    
    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }


}