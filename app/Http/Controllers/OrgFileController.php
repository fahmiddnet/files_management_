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
        $orgFile = OrgFile::with('orgProjects')->findOrFail($id);
        $projectName = $orgFile->orgProjects->first()->name ?? 'No Project Found';
        $projectid = $orgFile->orgProjects->first()->id ?? 'No Project id Found';
        // dd( $org_files);
        $projects = Project::get()->all();
        return view('backend.projectfiles.edit',compact('orgFile','projects','projectName','projectid'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrgFile $orgFile,$id)
    {
        //
        $org_files = OrgFile::with('orgProjects')->findOrFail($id);
        // dd($orgFile);
        $file = $request->file('file_name');
        $customFileName = $request->custom_file_name;


        // Use custom file name if provided; otherwise, default to original name
        $org_files->name = $customFileName;
        $org_files->custom_name = $customFileName;

        // Update file
        if ($file) {
            $fileNameGen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/project-file/'), $fileNameGen);
            $org_files->file_name = 'upload/project-file/' . $fileNameGen;
        }

        $org_files->updated_at = Carbon::now();
        $org_files->save();


        $notification = array(
            'message' => 'File Updated Successfully',
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
