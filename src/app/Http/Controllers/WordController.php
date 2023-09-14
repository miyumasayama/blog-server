<?php

namespace App\Http\Controllers;

use App\Models\Word;

use Illuminate\Http\Request;

class WordController extends Controller
{
    public function index(){
        $words = Word::all();
        return $words;
    }
    public function create(Request $request){
        $student = new Word;
        $student->title = $request->title;
        $student->definition = $request->definition;
        $student->save();

        return response()->json([
            "message" => "word record created"
        ], 201);
    }



}
