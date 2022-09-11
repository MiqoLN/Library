<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        $data = Book::filter(strtolower($request->input('query')));
        if ($data == '404') {
            return abort(404, 'Wrong query');
        }
        return response()->json($data);
    }
    public function getId(int $id) : JsonResponse
    {
        $book = Book::id($id);
        if(!$book->count()) {
            return abort(404, 'Id not found');
        }
        return response()->json($book);
    }
    public function store(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:books|max:255',
            'text' => 'required',
        ]);
        if($validator->fails()){
            abort(422,'Wrong input format');
        }
        $book = Book::create($request->all());
        return response()->json($book, 201);
    }
}
