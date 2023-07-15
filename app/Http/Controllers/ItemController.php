<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Term;
use App\Models\Bar;
use App\Models\ItemsRelationship;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = ItemsRelationship::all();
        return view('items', [
            'title' => "Items",            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $terms = Term::all();
        $bars = Bar::all();        
        return view('items-form',[
            'title' => "Create Items",
            'item' => null,
            'terms' => $terms,
            'barsList' => $bars,
            'formAttributes' => [
                'url' => route("items.store"),
                'method' => "POST",
                "role" => "form",
                'files' => true,
            ]
        ]);
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
            'name' => 'required|string',
            'slug' => 'required|string',
            'category' => 'required',
            'brand' => 'required',
            'ingredients' => 'required',
            'media_type' => 'required|string',
            'price' => 'required|integer|min:0',
            'sale_price' => 'required|integer|min:0',
        ]);

        $input = $request->all();

        if(isset($input["media_type"])) {
            $media = null;            
            if($input["media_type"] == "video" && isset($input["video"]) && !empty($input["video"])) {  // If media is type of video
                $media = rand().$input["video"]->getClientOriginalName();
                $input["video"]->move(public_path('images/items/'), $media);
                $input["media"] = $media;
            } else if($input["media_type"] == "image" && isset($input["images"]) && !empty($input["images"])) { // If media is type of Image
                $media = [];
                foreach($input["images"] as $image) {
                    $imageName = rand().$image->getClientOriginalName();
                    $image->move(public_path('images/items/'),$imageName);                    
                    $media[] = $imageName;
                }
                $input["media"] = json_encode($media);
            }
        }
        
        $item = Item::create($input);

        $terms = array_merge([$input["category"]], [$input['brand']]);
        $terms = array_merge($terms, $input["ingredients"]);
        
        foreach($terms as $key=>$term) {
            ItemsRelationship::create([
                'item_id' => $item->id,
                'term_id' => $term,
            ]);            
        }        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
