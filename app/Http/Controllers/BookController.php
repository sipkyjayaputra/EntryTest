<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Relation;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index()
    {
        return view('admin.book.index');
    }

    public function create()
    {
        return view('admin.book.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'publisher' => 'required',
            'year' => 'required',
            'author_id' => 'required',
        ]);

        $book = new Book();
        $book->fill($validatedData);
        $book->save();

        $book = Book::latest()->first();
        for ($i=0; $i < count($request->author_id); $i++) {
            if($request->author_id[$i] != ''){
                $relation = new Relation();
                $relation->book_id = $book->id;
                $relation->author_id = $request->author_id[$i];
                $relation->save();
            }
        }
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        $authors_list = Relation::where('book_id', $book->id)->with('authors')->get();
        return view('admin.book.show', compact('book', 'authors_list'));
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $authors_list = Relation::where('book_id', $book->id)->with('authors')->get();
        $authors_option = Author::all();
        return view('admin.book.edit', compact('book', 'authors_list', 'authors_option'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'publisher' => 'required',
            'year' => 'required',
            'author_id' => 'required',
        ]);

        $book = Book::findOrFail($id);
        $book->fill($validatedData);
        $book->save();
        Relation::where('book_id', $book->id)->delete();

        for ($i=0; $i < count($request->author_id); $i++) {
            if($request->author_id[$i] != ''){
                $relation = new Relation();
                $relation->book_id = $book->id;
                $relation->author_id = $request->author_id[$i];
                $relation->save();
            }
        }
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        Relation::where('book_id', $book->id)->delete();
        $book->delete();
    }

    public function data()
    {
        return datatables(Book::all())
            ->addColumn('action', 'admin.book.action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }

    public function listAuthor(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = DB::table("authors")
            		->select("id","name")
            		->where('name','LIKE',"%$search%")
            		->get();
        }else{
            $data = DB::table("authors")
            		->select("id","name")
            		->get();
        }

        return response()->json($data);
    }
}
