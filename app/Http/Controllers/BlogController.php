<?php

namespace App\Http\Controllers;

use App\Http\Controllers\api\BaseController;
use App\Models\Blog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('laravel');
    }

     /**
     * Retorna la tabla con la información
     *************************************
     * [26-Mayo-2022] [David Parroquiano]
     * @return void Vista renderizada en formato JSON
     */

    public function get_data(Request $request)
    {
        $search = $request->search;
        $blogs = Blog::where('name', 'LIKE', '%' . $search . '%')->get();
        return response()->json([
            'html' => view('cards', compact('blogs'))->render(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $blogs = Blog::all();      
        return $this->sendResponse($blogs, 'Se lista los blogs correctamente.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|unique:blogs',
                'description' => 'required',
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);
    
            $url = Storage::put('blogs', $request->file('image'));
    
            Blog::create(['name' => $request->name, 'description' => $request->description, 'image' => $url]);

            return response()->json(['message' => "El POST ".$request->name." se ha agregado correctamente.", "status" => 200], 200);
        }
        catch(Exception $ex){
            return response()->json(['message' => "Error: ".$ex->getMessage()], 500);
        }        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{

            $request->validate([
                'name' => 'required',
                'description' => 'required',
            ]);

            
            $url = $request->image;
            
            $blog = Blog::find($request->id);
            
            if ($request->file('image')) {
                $url = Storage::put('blogs', $request->file('image'));
                if ($blog->image) {
                    Storage::delete($blog->image);
                }
            }
            $blog->update(['name' => $request->name, 'description' => $request->description, 'image' => $url]);
            return response()->json(['message' => "El POST ".$request->name." se ha modificado correctamente.", "status" => 200], 200);
        }
        catch(Exception $ex){
            return response()->json(['message' => "Error: ".$ex->getMessage()], 500);
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Blog::find($request->id)->delete();
        return response()->json(['message' => "El POST ".$request->name." se ha eliminado correctamente.", "status" => 200], 200);
    }
}
