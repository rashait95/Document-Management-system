<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FolderRequest;
use App\Http\Traits\FolderFunctions;
use Illuminate\Support\Facades\Storage;

class FolderController extends Controller
{
    use FolderFunctions;
    /**
     * Display a listing of the resource.
     */
    public function getAlldocs(Request $request)
    {
        $path=Folder::all();
        return response()->json([
            'data'=>$path,
            'code'=>200,
           'message'=>'success'
        ]);
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FolderRequest $request)
    {
        try{
            DB::beginTransaction();
       $path=$this->getPath($request->file($request->folder_path));
       $folder=Folder::create([
           'folder_name'=>$request->folder_name,
           'size'=>$request->size,
           'folder_path'=>$path,
           'folder_id'=>$request->folder_id,
       ]);

       DB::commit();
       return response()->json([
           'status' => 'created successfully',
           'documents' => $document
        ]);
   } catch (\Throwable $th) {
       DB::rollback();
       Log::error($th);
       return response()->json([
           'status' => 'not uploaded',
           
        ]);
   }

    }

    /**
     * Display the specified resource.
     */
    public function show(Folder $folder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Folder $folder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Folder $folder)
    {
        try {

            $folder->delete();
           
            return response()->json([
                'status' => 'delete success',
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
