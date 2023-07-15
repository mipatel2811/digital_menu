<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;


class TermController extends Controller
{

    public $type = null;

    public function __construct() {
        $this->type = "category";
        if(request()->is('ingredients*')) {
            $this->type = "ingredients";
        }
        if(request()->is('brands*')) {
            $this->type = "brands";
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = Term::where('type', $this->type)->get();
        return view('terms', ["title" => $this->type, "terms" => $terms]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('terms-form',['title' => $this->type, 'term' => null, "formAttributes" => ["url" => route($this->type.'.store'), "method" => "POST"]]);
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
            'name' => 'required',
            'slug' => 'required|unique:terms',      
            'type' => "required"      
        ]);

        $input = $request->all();
    
        $input["slug"] = str_replace(' ','-', strtolower($input["slug"]));

        $input["type"] = $this->type;

        Term::create($input);

        return redirect(route($this->type.'.index'))->with("success", ucwords($this->type)." created Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function show(Term $term)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $term = Term::find($id);
        return view('terms-form',['title' => $this->type, 'term' => $term, "formAttributes" => ["url" => route($this->type.'.update', $term->id), "method" => "PUT"]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'name' => 'required',
            'slug' => "required|unique:terms,slug,$id",      
            'type' => "required"      
        ]);

        $term = Term::find($id);

        $input = $request->all();        

        $input["slug"] = str_replace(' ','-', strtolower(trim($input["slug"])));

        $input["type"] = $this->type;

        $term->update($input);

        return redirect(route($this->type.'.index'))->with("success", ucwords($this->type)." updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Term::find($id)->delete();
        return response()->json(['status' => 1]);
    }

    public function getTerms(Request $request) {
        return Datatables::make($this->getForDataTable($request->all()))
            ->escapeColumns(['id'])                
            ->editColumn('name', fn($term) => $term->name)
            ->editColumn('slug', fn($term) => $term->slug)                   
            ->editColumn('created_at', fn($term) => Carbon::parse($term->created_at)->format('F d, Y'))
            ->addColumn('actions', function ($term) {
                return "<a href='".route($this->type.'.edit', $term->id)."' class='btn btn-tool'><i class='fas fa-pen'></i></a>
                <a href='javascript:;' class='btn btn-tool delete_" . $term->id . "' data-url='" . route($this->type.'.destroy', $term->id) . "'  onclick='deleteRecorded(" . $term->id . ")'><i class='fas fa-trash'></i></a>";
            })
            ->make(true);
    }

    public function getForDataTable($input)
    {
        $dataTableQuery = Term::query()->where('type', $this->type);


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
