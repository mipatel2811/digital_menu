<?php

namespace App\Http\Controllers;

use App\Models\Bar;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class BarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $users = User::where('role_id', 3)->get();
        return view("bars", [
            'title' => 'Bars',
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = [];
        $usersArray = User::where('role_id', 3)->get();
        foreach($usersArray as $user) {
            $users[$user->id] = $user->name;
        }
    
        return view('bars-form',[
            'title' => "Create Bar", 
            "bar" => null, 
            'users' => $users,
            "formAttributes" => [
                "url" => route('bars.store'), 
                "method" => "POST", 
                "files"=>true, 
                "role" => 'form'
                ]
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:bars',
            'user_id' => 'required|integer',
            'images' => 'required',            
        ]);

        $input = $request->all();

        if(isset($input["logo"]) && !empty($input['logo'])) {
            $fileName = rand().$input["logo"]->getClientOriginalName();
            $input["logo"]->move(public_path('images/bars/logo/'), $fileName);
            $input["logo"] = $fileName;
        }

        $images = [];
        if(isset($input["images"]) && !empty($input["images"])) {
            foreach($input["images"] as $image) {
                $imageName = rand().$image->getClientOriginalName();
                $image->move(public_path('images/bars/'), $imageName);
                $images[] = $imageName;
            }
        }

        $input["images"] = json_encode($images);

        Bar::create($input);

        return redirect(route('bars.index'))->with("success", "Bar Registered Successfully");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bar  $bar
     * @return \Illuminate\Http\Response
     */
    public function show(Bar $bar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bar  $bar
     * @return \Illuminate\Http\Response
     */
    public function edit(Bar $bar)
    {
        $users = [];
        $usersArray = User::where('role_id', 3)->get();
        foreach($usersArray as $user) {
            $users[$user->id] = $user->name;
        }
    
        return view('bars-form',[
            'title' => "Edit Bar", 
            "bar" => $bar, 
            'users' => $users,
            "formAttributes" => [
                "url" => route('bars.update', $bar->id), 
                "method" => "PUT", 
                "files"=>true, 
                "role" => 'form'
                ]
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bar  $bar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bar $bar)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => "required|unique:bars,slug,$bar->id",
            'user_id' => 'required|integer',
        ]);

        $input = $request->all();

        if(isset($input["logo"]) && !empty($input['logo'])) {
            if(file_exists(public_path('images/bars/logo/').$bar->logo)) {
                unlink(public_path('images/bars/logo/').$bar->logo);
            }
            $fileName = rand().$input["logo"]->getClientOriginalName();
            $input["logo"]->move(public_path('images/bars/logo/'), $fileName);
            $input["logo"] = $fileName;
        }

        $images = json_decode($bar->images);
        if(isset($input["images"]) && !empty($input["images"])) {
            foreach($images as $image) {
                if(file_exists(public_path('images/bars/').$image)) {
                    unlink(public_path('images/bars/').$image);
                }
            }

            $images = [];

            foreach($input["images"] as $image) {
                $imageName = rand().$image->getClientOriginalName();
                $image->move(public_path('images/bars/'), $imageName);
                $images[] = $imageName;
            }
        }

        $input["images"] = json_encode($images);

        $bar->update($input);

        return redirect(route('bars.index'))->with("success", "Bar Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bar  $bar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bar $bar)
    {
        if(file_exists(public_path('images/bars/logo/').$bar->logo)) {
            unlink(public_path('images/bars/logo/').$bar->logo);
        }
        $images = json_decode($bar->images);
        foreach($images as $image) {
            if(file_exists(public_path('images/bars/').$image)) {
                unlink(public_path('images/bars/').$image);
            }
        }

        $bar->delete();

        return response()->json(['status' => 1]);

    }

    public function getBars(Request $request) {
        return Datatables::make($this->getForDataTable($request->all()))
            ->escapeColumns(['id'])
            ->editColumn('logo', function ($bar) {
                $logo = $bar->logo ? '/images/bars/logo/'.$bar->logo : '/images/placeholder.png';                 
                return "<img src='". $logo . "' height='50' width='50'/>";
            })            
            ->editColumn('name', fn($bar) => $bar->name)
            ->editColumn('address', fn($bar) => $bar->address)       
            ->editColumn('city', fn($bar) => $bar->city)                 
            ->editColumn('owner', fn($bar) => $bar->owner?->name)                             
            ->editColumn('created_at', fn($bar) => Carbon::parse($bar->created_at)->format('F d, Y'))
            ->addColumn('actions', function ($bar) {
                return "<a href='".route('bars.edit', $bar->id)."' class='btn btn-tool'><i class='fas fa-pen'></i></a>
                <a href='javascript:;' class='btn btn-tool delete_" . $bar->id . "' data-url='" . route('bars.destroy', $bar->id) . "'  onclick='deleteRecorded(" . $bar->id . ")'><i class='fas fa-trash'></i></a>";
            })
            ->make(true);
    }

    public function getForDataTable($input)
    {
        $dataTableQuery = Bar::query();

        if (isset($input['date']) && $input['date'] != '') {
            $from = explode(' - ', $input['date'])[0];
            $to = explode(' - ', $input['date'])[1];
            $from = date('Y-m-d',strtotime($from));
            $to = date('Y-m-d',strtotime($to));
            $dataTableQuery->whereBetween('bars.created_at', [$from, $to]);
        }
        
        if (isset($input['user_id']) && $input['user_id'] != '') {
            $dataTableQuery->where('user_id', $input['user_id']);
        }

        return  $dataTableQuery;
    }

}
