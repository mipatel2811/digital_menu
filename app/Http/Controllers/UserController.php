<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('users', ['title' => 'Users', 'roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allroles = Role::all();
        $roles = [];
        foreach($allroles as $role) {
            $roles[$role->role] = $role->role_name;
        }

        $formAttributes = ['url' => route('users.store'),'method' => 'POST', 'role' => 'form', 'files' => true];
        
        return view('user-form', ['title' => 'Add User', 'roles' => $roles, 'user' => null, 'formAttributes' => $formAttributes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'image' => ['sometimes', 'image'],
            'phone' => ['required', 'digits:10'],
            'role_id' => ['required'],
            'approved' => ['required'],            
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        if(isset($input['image']) && !empty($input["image"])) {            
            $fileName = rand().$input["image"]->getClientOriginalName();
            $input['image']->move(public_path('images/users/'),$fileName);
            $input["profile_image"] = $fileName;
        }

        User::create($input);
        
        return redirect(route('users.index'))->with('success', "User Created Successfully");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $allroles = Role::all();
        $roles = [];
        foreach($allroles as $role) {
            $roles[$role->role] = $role->role_name;
        }
        $formAttributes = ['url' => route('users.update',$user->id),'method' => 'PUT', 'role' => 'form', 'files' => true];
        return view('user-form', ['title' => 'Edit User', 'roles' => $roles, 'user' => $user, 'formAttributes' => $formAttributes]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],            
            'password' => ['sometimes','confirmed'],
            // 'password_confirmation' => [ 'string', 'min:8', ],
            'role_id' => ['required'],
            'image' => ['sometimes', 'image'],
            'phone' => ['required', 'digits:10'],
            'approved' => ['required'],            
        ]);

        // $input['email'] = NULL;

            
        $input = $request->all();

        if(isset($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }

        if(isset($input['image']) && !empty($input["image"])) {
            if(file_exists(public_path('images/users/').$user->profile_image)) {
                unlink(public_path('images/users/').$user->profile_image);
            }
            $fileName = rand().$input["image"]->getClientOriginalName();
            $input['image']->move(public_path('images/users/'),$fileName);
            $input["profile_image"] = $fileName;
        }
        
        $user->update($input);

        return redirect(route('users.index'))->with('success', "User Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {        
        if(file_exists(public_path('images/users/').$user->profile_image)) {
            unlink(public_path('images/users/').$user->profile_image);
        }
        $user->delete();
        return response()->json(['status' => 1]);
    }

    public function getUsers(Request $request) {
        return Datatables::make($this->getForDataTable($request->all()))
            ->escapeColumns(['id'])
            ->editColumn('profile_image', function ($user) {
                $image = $user->profile_image ? '/images/users/'.$user->profile_image : '/images/avatar.png';                 
                return "<img src='". $image . "' height='50' width='50'/>";

            })            
            ->editColumn('name', fn($user) => $user->name)
            ->editColumn('email', fn($user) => $user->email)       
            ->editColumn('role', fn($user) => $user->role->role_name)                 
            ->editColumn('approved', function ($user) {
                if ($user->approved == 1) {
                    return "<label class='badge bg-success'>Approved</label>";
                } else {
                    return "<label class='badge bg-warning'>Not Approved</label>";
                }
            })
            ->editColumn('created_at', fn($user) => Carbon::parse($user->created_at)->format('F d, Y'))
            ->addColumn('actions', function ($user) {
                return "<a href='".route('users.edit', $user->id)."' class='btn btn-tool'><i class='fas fa-pen'></i></a>
                <a href='javascript:;' class='btn btn-tool delete_" . $user->id . "' data-url='" . route('users.destroy', $user->id) . "'  onclick='deleteRecorded(" . $user->id . ")'><i class='fas fa-trash'></i></a>";
            })
            ->make(true);
    }

    public function getForDataTable($input)
    {
        $dataTableQuery = User::query();


        if (isset($input['date']) && $input['date'] != '') {
            $from = explode(' - ', $input['date'])[0];
            $to = explode(' - ', $input['date'])[1];
            $from = date('Y-m-d',strtotime($from));
            $to = date('Y-m-d',strtotime($to));
            $dataTableQuery->whereBetween('users.created_at', [$from, $to]);
        }

        // if (isset($input['date']) && $input['date'] != '') {
        //     $dataTableQuery->whereDate('components.created_at', '=', $input['date']);
        // }


        if (isset($input['role_id']) && $input['role_id'] != '') {
            $dataTableQuery->where('role_id', $input['role_id']);
        }


        return  $dataTableQuery;
    }
}
