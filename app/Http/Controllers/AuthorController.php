<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    public function index()
    {
        return view('admin.author.index');
    }

    public function create()
    {
        return view('admin.author.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        $author = new Author();
        $author->fill($validatedData);
        $author->save();

        return redirect()->route('author.index')->with('Data has been saved successfully!');
    }

    public function show($id)
    {
        $author = Author::findOrFail($id);
        return view('admin.author.show', compact('author'));
    }

    public function edit($id)
    {
        $author = Author::findOrFail($id);
        return view('admin.author.edit', compact('author'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        $author = Author::findOrFail($id);
        $author->fill($validatedData);
        $author->save();
    }

    public function destroy($id)
    {
        $author = Author::findOrFail($id);
        $author->delete();
    }

    public function data()
    {
        return datatables(Author::all())
            ->addColumn('action', 'admin.author.action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
}
