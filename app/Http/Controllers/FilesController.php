<?php

namespace App\Http\Controllers;
use Response;
use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFileRequest;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::all();
        return view('files.index',[
            'files' =>$files
        ]);
    }

    public function open($fileName){
        return response()->file('file/'. $fileName);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('files.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $taskid)
    {
        if($request->hasfile('files'))
         {
            foreach($request->file('files') as $file)
            {
                $fileName = $taskid. '_' .time() .$file->getClientOriginalName(). '.' . $file->extension();

                $clientname = $file->getClientOriginalName();
                $type = $file->extension();
                $size = $file->getSize();
        
                $file->move(public_path('file'), $fileName);
                File::create([
                    'task_id' => $taskid,
                    'slug' => $clientname,
                    'name' => $fileName,
                    'type' => $type,
                    'size' => $size
                ]);
            }
         }
        
        return redirect()->back();
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $path = 'file/'. $file->name;
        $file->delete();
        unlink(public_path($path));

        return redirect()->back();
    }
}
