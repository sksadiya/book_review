<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function index(Request $request) {
    $books = Book::orderBy('created_at','DESC')->where('status',1);
    if(!empty($request->search)) {
        $books = $books->where('title', 'like', '%'.$request->search.'%');
    }
    $books = $books->paginate(8);
        return view('home',compact('books'));
   }
   public function detail($id) {
    $book = Book::find($id);
    if(!$book) {
        return redirect()->route('home')->with('book not found');
    }
    if($book->status == 0) {
        abort(404);
    }
    $relatedBooks = Book::where('status',1)->take(3)->inRandomOrder()->get();
        return view('detail',compact('book','relatedBooks'));
   }
}
