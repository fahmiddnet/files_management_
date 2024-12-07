<?php

namespace App\Http\Controllers;

use App\Models\organizations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganizationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // return view('backend.organizations.index')->name('organizations');
        $organizations = organizations::orderBy('created_at','DESC')->paginate(10);
        return view('backend.organizations.index',compact('organizations'));
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('backend.organizations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // return "This is store";
        // dd($request);
        $rules = [
            'org_name' => 'required|string|min:3|max:100', // Ensure org_name is a string with length restrictions
            'org_phone' => 'required|regex:/^[0-9]{10,15}$/',  // Validate phone as a numeric string with length between 10 and 15
            //'org_address' => 'string',    // Minimum content length for better quality
            //'org_info' => 'string', // Provide a max length for org_details
        ];
        $validator = Validator::make($request->all(),$rules);

        $notification = array(
            'message' => 'Organization created Successfully', 
            'alert-type' => 'success'
        );
        // if($validator->passes()){
        //     dd($request);
        // }

        if($validator->passes()){
            // dd($request->org_name);
            organizations::create([
                    'org_name' => $request->org_name,
                    'org_phone' => $request->org_phone,
                    'org_address' => $request->org_address,
                    'org_info' => $request->org_info,
                ]);
            return redirect()->route('organizations.index')->with($notification);

        } else {
            return redirect()->route('organizations.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(organizations $organizations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(organizations $organization)
    {
        //
        // dd($organization);
        return view('backend.organizations.edit',compact('organization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, organizations $organization)
    {
        //
        // dd($request);
        $rules = [
            'org_name' => 'required|string|min:3|max:100', // Ensure org_name is a string with length restrictions
            'org_phone' => 'required|regex:/^[0-9]{10,15}$/',  // Validate phone as a numeric string with length between 10 and 15
        ];
        $validator = Validator::make($request->all(),$rules);

        $notification = array(
            'message' => 'Organization update Successfully', 
            'alert-type' => 'success'
        );

        if($validator->passes()){
            // dd($request->org_name);
            $organization->org_name = $request->org_name;
            $organization->org_phone = $request->org_phone;
            $organization->org_address = $request->org_address;
            $organization->org_info = $request->org_info;
            $organization->save();
            return redirect()->route('organizations.index')->with($notification);

        } else {
            // return "This is bad";
            return redirect()->route('organizations.update')->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(organizations $organization)
    {
        //
        // dd($permission);
        $organization->delete();
        $notification = array(
            'message' => 'Organization Deleted Successfully', 
            'alert-type' => 'error'
        );

        return redirect('organizations')->with($notification);
    }
}
