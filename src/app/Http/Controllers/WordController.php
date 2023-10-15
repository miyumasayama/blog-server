<?php

namespace App\Http\Controllers;

use App\Models\Word;

use Illuminate\Http\Request;

use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]

class WordController extends Controller
{

    public function index(Request $request){
        $words = Word::paginate($request->per_page);
        return $words;
    }

    public function create(Request $request){
        $word = new Word;
        $word->title = $request->title;
        $word->definition = $request->definition;
        $word->save();

        return response()->json([
            "word" => $word
        ], 201);
    }

    public function edit(Request $request){
        $word = Word::find($request->id);
        if (!$word) {
            return response()->json(['error' => 'Word not found'], 404);
        }
        $word = $request;
        $word->save();

        return response()->json(['word' => $word], 200);
    }


}
