<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\organizations;
use App\Models\OrgFile;

class Project extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function org()
    {
        return $this->belongsTo(Organizations::class);
    }

    public function orgFiles(){
        return $this->belongsToMany(OrgFile::class,'org_file_project','project_id','org_file_id');
    }
}