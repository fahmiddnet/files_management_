<?php

namespace App\Http\Controllers;

use App\Models\OrgFile;
use App\Models\Project;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use DateTime;

class OrgFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $projects = Project::with('orgFiles')->latest()->paginate(5);
        // dd($projects);
        return view('backend.projectfiles.index',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $projects = Project::get()->all();
        // dd($projects);
        return view('backend.projectfiles.create',compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 

        $projectId = $request->project_id;
        $fileNames = $request->file('file_name');
        $customFileNames = $request->custom_file_name;

        foreach ($fileNames as $index => $file) {
            $data = new OrgFile();

            // Use custom file name if provided; otherwise, default to original name
            $customName = $customFileNames[$index] ?? $file->getClientOriginalName();
            $data->name = $customName;
            $data->custom_name = $customName;

            // Store file
            $fileNameGen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/project-file/'), $fileNameGen);
            $data->file_name = 'upload/project-file/' . $fileNameGen;

            $data->created_at = Carbon::now();
            $data->save();

            // Attach project ID
            if ($projectId) {
                $data->orgProjects()->attach($projectId);
            }
        }



        $notification = array(
            'message' => 'Project File Created Successfully',
            'alert-type' => 'success'
        );

        return redirect('projectfiles')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrgFile $orgFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $org_files = OrgFile::with('orgProjects')->findOrFail($id);
        $projectName = $org_files->orgProjects->first()->name ?? 'No Project Found';
        $projectid = $org_files->orgProjects->first()->id ?? 'No Project id Found';
        // dd( $org_files);
        $projects = Project::get()->all();
        return view('backend.projectfiles.edit',compact('org_files','projects','projectName','projectid'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrgFile $orgFile)
    {
        //
        // dd($request);
        $projectId = $request->project_id;
        $file = $request->file('file_name');
        $customFileNames = $request->custom_file_name;


            // Use custom file name if provided; otherwise, default to original name
            $customName = $customFileNames;
            $orgFile->name = $customName;
            $orgFile->custom_name = $customName;

            $data = new OrgFile();
            // Update file
            if ($file) {
                $fileNameGen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/project-file/'), $fileNameGen);
                $data->file_name = 'upload/project-file/' . $fileNameGen;
            }

            $orgFile->updated_at = Carbon::now();
            $orgFile->save();

            // Sync project ID
            // if ($projectId) {
            //     $orgFile->orgProjects()->sync($projectId);
            // }
        if (!$orgFile->orgProjects()->where('project_id', $projectId)->exists()) {
            $orgFile->orgProjects()->sync([$projectId]);
        }



        $notification = array(
            'message' => 'Project File Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect('projectfiles')->with($notification);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $orgFile = OrgFile::findOrFail($id);
        // dd($file);

        // Delete the physical file if it exists
        if (File::exists(public_path($orgFile->file_name))) {
            File::delete(public_path($orgFile->file_name));
        }

        // Detach the project if there's a relationship
        if ($orgFile->orgProjects()) {
            $orgFile->orgProjects()->detach();
        }

        // Delete the database entry
        $orgFile->delete();

        $notification = array(
            'message' => 'Project File Delete Successfully',
            'alert-type' => 'error'
        );

        return redirect('projectfiles')->with($notification);
    }
}
