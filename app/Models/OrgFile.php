<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class OrgFile extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function orgProjects(){
        return $this->belongsToMany(Project::class,'org_file_project','org_file_id','project_id');
    }
}
