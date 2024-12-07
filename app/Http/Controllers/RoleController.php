<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = Role::orderBy('created_at','DESC')->paginate(10);
        return view('roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $permissions = Permission::orderBy('name','ASC')->get();
        return view('roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        $validator = Validator::make($request->all(),[
            'name'=> 'required|unique:roles|min:3'
        ]);
        $notification = array(
            'message' => 'Role created Successfully', 
            'alert-type' => 'success'
        );

        if($validator->passes()){
            // dd($request->permission);
            $role = Role::create(['name' => $request->name]);

            if(!empty($request->permission)) {
                foreach($request->permission as $name){
                    $role->givePermissionTo($name);
                }
            }

            return redirect()->route('roles.index')->with($notification);

        } else {
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
        // dd($roles);
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name','ASC')->get();
        return view('roles.edit', compact('permissions','hasPermissions','role'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
        $validator = Validator::make($request->all(),[
            'name'=> 'required|unique:roles,name,'.$role->id.'|min:3'
        ]);
        $notification = array(
            'message' => 'Role Updated Successfully', 
            'alert-type' => 'info'
        );

        if($validator->passes()){

            $role->name = $request->name;
            $role->save();

            if(!empty($request->permission)) {
                $role->syncPermissions($request->permission);
            } else {
                $role->syncPermissions([]);
            }

            return redirect()->route('roles.index')->with($notification);

        } else {
            return redirect()->route('roles.edit',$role->id)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
        $role->delete();
        $notification = array(
            'message' => 'Post Deleted Successfully', 
            'alert-type' => 'error'
        );

        return redirect('roles')->with($notification);
    }
}
