<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tag = Cache::remember('tags',30,function (){
                
                return Tag::with('tagable')->get()});


            return response()->json([
                'status' => 'success',
                'tags' => $tag
             ]);

        } catch (\Throwable $th) {
            Log::error($th);}
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Document $document)
    {
          try {
            $tag = $document->tags()->create([
                'tag' =>$request->tag,
            ]);
            return response()->json([
                'status' => 'success',
                'tags' => $tag
             ]);
        }catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
               'status' => 'error',
                'tags' => $tag
             ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        return response()->json([
            'status' => 'success',
            'tags' => $tag
         ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        try {

            $tag->delete();
           
            return response()->json([
                'status' => 'deleted success',
                'tags' => $tag
             ]);
        }catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
               'status' => 'error',
                'tags' => $tag
             ]);
        }
    }
}
