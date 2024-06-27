<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Repositories\NoteRepositoryInterface;

class NoteController extends Controller
{
    protected $note;

    public function __construct(NoteRepositoryInterface $note) {
        $this->note= $note;
    }

    public function store(Request $request){
        $data = $request->all();
        try {
            DB::transaction(function () use($data) {
                $data['creator_user'] = auth()->id();
             
                Note::create($data);
               
            });
            // Alert::success('Success',"Note Added Successfully");
            // return back();
            $notes = Note::where('lead_id',$data['lead_id'])->get();
            return response()->json([
                'status' => true,
                'message' => 'Successfully Added Note',
                'view' => view('backend.components.leadNoteListData',compact('notes'))->render(),
                
            ]);
        } catch (\Throwable $th) {
            // Alert::error('Error',$th->getMessage());
            // return back();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                
            ]);
        }
    }
}
