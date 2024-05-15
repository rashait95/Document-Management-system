<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\FilesFunctions;
use App\Http\Requests\UploadDocumentRequest;

class DocumentController extends Controller
{

    use FilesFunctions;
    /**
     * Display a listing of the resource.
     */
    public function getAlldocs()
    {
        try{
            $documents = Cache::remember('documents',60,function(){
                return Document::with('folders')->get();
            });
        return response()->json([
            'status' => 'success',
            'documents' => $documents
         ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'status' => 'cant get documents',
                
             ]);
        }
        

    }

    /**
     * Store a newly created resource in storage.
     */
    public function upload(UploadDocumentRequest $request)
    {
        try{
        DB::beginTransaction();
        $documentPath=$this->getPath($request->file);
        $document = Document::create([
            'name'       =>$request->title,
            'size' =>$request->size,
            'document_path'=>$documentPath,
            'folder_id' =>$request->folder_id,
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
    public function retrievedocument(Document $document)
    {
        return response()->json([
            'status' => 'retrived successfully',
            'document' => $document
         ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        try {
            $document->delete();
            return response()->json([
                'status' => 'deleted successfully',
                
             ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'status' => 'not deleted',
                
             ]);
        }
    }
}
