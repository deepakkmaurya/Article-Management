<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
	{
		return[
			new Middleware('permission:view role', only: ['index']),
			new Middleware('permission:edit role', only: ['edit']),
			new Middleware('permission:create role', only: ['create']),
			new Middleware('permission:delete role', only: ['destroy']),		
		
		];
		
	}   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = Role::orderBy('name','ASC')->paginate(2);
        return view('role.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $permissions = Permission::orderBy('name','ASC')->get();
        return view('role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:roles|min:3|regex:/^[a-zA-Z _-]+$/',
        ],[
            'name.regex' => 'The input field must contain only letters, spaces, underscores, or dashes.',
        ]);

        if($validator->passes()){
           $role = Role::create(['name' =>$request->name]);
           if(!empty($request->permission)){
            foreach ($request->permission as $value) {
                $role->givePermissionTo($value);
            }
           }
            return redirect()->route('role.index')->with('success','role created successfully');
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $roles = Role::find($id);
        return view('role.show',compact('roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $role = Role::findOrFail($id);
        $haspermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name','ASC')->get();

        return view('role.edit',['haspermissions'=>$haspermissions,
        'permissions'=>$permissions,
        'role'=>$role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $role = Role::findOrFail($id);
       
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:roles,name,'.$id.'id|min:3|regex:/^[a-zA-Z _-]+$/',
        ],[
            'name.regex' => 'The input field must contain only letters, spaces, underscores, or dashes.',
        ]);

        if($validator->passes()){

           $role->name = $request->name;
           $role->save;

           if(!empty($request->permission)){
            $role->syncPermissions($request->permission);
           }else{
            $role->syncPermissions([]);
           }

            return redirect()->route('role.index')->with('success','Role Update successfully');
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        // $id = Role::find($id);

        $role = role::find($id);
        if( $role == null){
            session()->flash('error','role not found');
            return response()->json([
                'status' => false,
            ]);
        }

        $role->delete();
        session()->flash('success','role deleted successfully');
        return response()->json([
            'status' => true,
        ]);
    }
}
