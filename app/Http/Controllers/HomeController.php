<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Auth;
use Illuminate\Http\Request;
use Validator;

class HomeController extends Controller
{
   public function index(Request $request) {
    $books = Book::with('reviews') // Eager load reviews
                      ->orderBy('created_at', 'DESC')
                      ->where('status', 1);
    if(!empty($request->search)) {
        $books = $books->where('title', 'like', '%'.$request->search.'%');
    }
    $books = $books->paginate(8);
    $books->each(function ($book) {
        $book->reviews_count = $book->reviews->count();
        $book->average_rating = $book->reviews_count > 0
            ? $book->reviews->avg('ratings')
            : 0;
    });
        return view('home',compact('books'));
   }
   public function detail($id) {
    $book = Book::with('reviews','reviews.user')->find($id);
    if(!$book) {
        return redirect()->route('home')->with('book not found');
    }
    if($book->status == 0) {
        abort(404);
    }
    if ($book->reviews->isNotEmpty()) {
        $averageRating = $book->reviews->avg('ratings');
        $averageRatingPercentage = ($averageRating / 5) * 100;
    } else {
        $averageRating = 0;
        $averageRatingPercentage = 0;
    }
    $reviewsCount = Review::where('book_id',$book->id)->where('status',1)->count();
    $relatedBooks = Book::where('status',1)->take(3)->inRandomOrder()->where('id','!=',$id)->get();
        return view('detail',compact('book','relatedBooks','reviewsCount','averageRatingPercentage','averageRating'));
   }

   public function saveReview(Request $request) {
        $validator = Validator::make($request->all(),[
            'review' => 'required|min:10',
            'rating' => 'required'
        ]);
        if($validator->passes()) {
            $countReview = Review::where('user_id',Auth::user()->id)->where('book_id',$request->book_id)->count();
            if($countReview > 0) {
            session()->flash('error','You already submitted review');
            return response()->json([
                'status' => true,
            ]);
            }
            $review = new Review();
            $review->review = $request->review;
            $review->ratings = $request->rating;
            $review->user_id = Auth::user()->id;
            $review->book_id = $request->book_id;
            $review->save();
            session()->flash('success','review stored successfully');
            return response()->json([
                'status' => true,
                'message' => 'review stored successfully'
            ]);
        
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()]);
        }
   }
}
