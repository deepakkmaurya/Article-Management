<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $permissions = Permission::orderBy('created_at','DESC')->paginate(2);
        return view('permissions.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
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
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:permissions|min:3|regex:/^[a-zA-Z _-]+$/',
        ],[
            'name.regex' => 'The input field must contain only letters, spaces, underscores, or dashes.',
        ]);

        if($validator->passes()){
            $permission = new Permission();
            $permission->name = $request->input('name');
            $permission->guard_name = 'web';
            $permission->save();
            return redirect()->route('permissions.index')->with('success','Permission created successfully');
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
        $permission = Permission::find($id);
        return view('permissions.show',compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $permission = permission::find($id);
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:permissions|min:3|regex:/^[a-zA-Z _-]+$/',
        ],[
            'name.regex' => 'The input field must contain only letters, spaces, underscores, or dashes.',
        ]);
       
        if($validator->passes()){
            $permission = Permission::find($id);;
            $permission->name = $request->input('name');
            $permission->guard_name = 'web';
            $permission->update();
            return redirect()->route('permissions.index')->with('success','Permission update successfully');
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        //
        
        $id = $request->id;
        $permission = Permission::find($id);
        if( $permission == null){
            session()->flash('error','Permission not found');
            return response()->json([
                'status' => false,
            ]);
        }

        $permission->delete();
        session()->flash('success','Permission deleted successfully');
        return response()->json([
            'status' => true,
        ]);
    }
}
