<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Auth;
use File;
use Illuminate\Http\Request;
use Str;
use Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BookController extends Controller
{
    public function index() {
        $user = User::find(Auth::user()->id);
        $books = Book::latest();
        $books =  $books->paginate(10);
        return view('books.list',compact('user','books'));
    }
    public function create() {
        return view('books.add_book');
    }
    public function store(Request $request) {
        $rules = [
            'title' => 'required|unique:books|min:3',
            'author' => 'required|min:5',
            'status' => 'required',
        ];
        if(!empty($request->image)) {
            $rules['image'] = 'image';
        }
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return redirect()->route('books.create')->withErrors($validator->errors())->withInput();
        }
        $book = new Book();
        $book->title = $request->title;
        $book->slug = Str::slug($request->title);
        $book->author = $request->author;
        $book->status = $request->status;
        $book->description = $request->description;
        $book->save();

        if(!empty($request->image)) {
            //delete old image
            if(!empty($book->image)) {
                File::delete(public_path('uploads/books/'.$book->image));
                File::delete(public_path('uploads/books/thumb/'.$book->image));
            }
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext;
            $image->move('uploads/books',$imageName);
            $book->image = $imageName;
            $book->save();

            $manager = new ImageManager(new Driver());
            $img = $manager->read(public_path('uploads/books/'.$imageName));
            $img->resize(990);
            $img->save(public_path('uploads/books/thumb/'.$imageName));
        }
        return redirect()->route('books.list')->with('success','book stored successfull');
    }
    public function edit($id) {
        $book = Book::find($id);
        if($book == null) {
            return redirect()->route('books.list')->with('error','Record Not found');
        }
        return view('books.edit',compact('book'));
    }
    public function update(Request $request ,$id) {
        $book = Book::find($id);
        if($book == null) {
            return redirect()->route('books.list')->with('error','Record Not found');
        }
        $rules = [
            'title' => 'required|unique:books,title,'.$book->id.',id|min:3',
            'author' => 'required|min:5',
            'status' => 'required',
        ];
        if(!empty($request->image)) {
            $rules['image'] = 'image';
        }
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return redirect()->route('books.edit',$id)->withErrors($validator->errors())->withInput();
        }
        $book->title = $request->title;
        $book->slug = Str::slug($request->title);
        $book->status = $request->status;
        $book->description = $request->description;
        $book->save();
        if(!empty($request->image)) {
            //delete old image
            if(!empty($book->image)) {
                File::delete(public_path('uploads/books/'.$book->image));
                File::delete(public_path('uploads/books/thumb/'.$book->image));
            }
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext;
            $image->move('uploads/books',$imageName);
            $book->image = $imageName;
            $book->save();

            $manager = new ImageManager(new Driver());
            $img = $manager->read(public_path('uploads/books/'.$imageName));
            $img->resize(990);
            $img->save(public_path('uploads/books/thumb/'.$imageName));
        }
        return redirect()->route('books.list')->with('success','book updated successfull');
    }
    public function delete($id) {
        $book = Book::find($id);
        if($book == null) {
            return redirect()->route('books.list')->with('error','Record Not found');
        }
        $book->delete();
        return redirect()->route('books.list')->with('success','book deleted successfull');
    }
}
