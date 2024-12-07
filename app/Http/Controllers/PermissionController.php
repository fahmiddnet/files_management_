<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $permissions = Permission::orderBy('created_at','DESC')->paginate(10);
        return view('permissions.index',compact('permissions'));
    }

    /**
     * Show  the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        $validator = Validator::make($request->all(),[
            'name'=> 'required|unique:permissions|min:3'
        ]);
        $notification = array(
            'message' => 'Permission created Successfully', 
            'alert-type' => 'success'
        );

        if($validator->passes()){
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions.index')->with($notification);

        } else {
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
        return view('permissions.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        //
        // dd($permission);
        $validator = Validator::make($request->all(),[
            'name'=> 'required|unique:permissions|min:3'
        ]);
        $notification = array(
            'message' => 'Permission Updated Successfully', 
            'alert-type' => 'info'
        );

        if($validator->passes()){
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permissions.index')->with($notification);

        } else {
            return redirect()->route('permissions.edit',$permission->id)->withInput()->withErrors($validator);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
        // dd($permission);
        $permission->delete();
        $notification = array(
            'message' => 'Post Deleted Successfully', 
            'alert-type' => 'error'
        );

        return redirect('permissions')->with($notification);
    }
}
