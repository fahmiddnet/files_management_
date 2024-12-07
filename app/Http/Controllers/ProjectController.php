<?php

namespace App\Http\Controllers;

use App\Models\organizations;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $projects = Project::with('org')->orderBy('created_at','DESC')->paginate(10);
        // dd($projects);
        return view('backend.projects.index',compact('projects'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $organizations = organizations::get()->all();
        // dd($organization);
        return view('backend.projects.create',compact('organizations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        $rules = [
            'name' => 'required|string', // Ensure project_name is a string with length restrictions
            'org_id' => 'required',  
        ];
        $validator = Validator::make($request->all(),$rules);

        $notification = array(
            'message' => 'Project created Successfully', 
            'alert-type' => 'success'
        );
        // if($validator->passes()){
        //     dd($request);
        // }

        if($validator->passes()){
            Project::create([
                    'name' => $request->name,
                    'org_id' => $request->org_id,
                    'project_details' => $request->project_details,
                ]);
            return redirect()->route('projects.index')->with($notification);

        } else {
            return redirect()->route('projects.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
        $organizations = organizations::get()->all();
        return view('backend.projects.edit',compact('project','organizations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
        // dd($request);
        $rules = [
            'name' => 'required|string', // Ensure project_name is a string with length restrictions
            'org_id' => 'required',  
        ];
        $validator = Validator::make($request->all(),$rules);

        $notification = array(
            'message' => 'Project Update Successfully', 
            'alert-type' => 'success'
        );
        // if($validator->passes()){
        //     dd($request);
        // }

        if($validator->passes()){
            $project->name = $request->name;
            $project->org_id = $request->org_id;
            $project->project_details = $request->project_details;
            $project->save();
            return redirect()->route('projects.index')->with($notification);

        } else {
            return redirect()->route('projects.edit',$project->id)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
        $project->delete();
        $notification = array(
            'message' => 'Project Deleted Successfully', 
            'alert-type' => 'error'
        );

        return redirect('projects')->with($notification);
    }
}
