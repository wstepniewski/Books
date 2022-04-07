<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;

class BookReviewController extends Controller
{
    public function index(Book $book)
    {
        $reviews=$book->reviews;

        return view('reviews.index')->withReviews($reviews)->withBook($book);
    }

    public function create(Book $book)
    {
        return view('reviews.create')->withBook($book);
    }

    public function store(Request $request, Book $book)
    {
        $this->validate($request, [
            'title' => 'required',
            'text' => 'required'
        ]);

        $review = new Review();
        $review->title = $request->title;
        $review->text = $request->text;
        $review->book_id = $book->id;
        $review->save();

        return redirect()->route('books.reviews.show', [$book, $review]);
    }

    public function show(Book $book, Review $review)
    {
        if($review->book!=$book){
            return abort(404);
        }
        return view('reviews.show')->withReview($review)->withBook($book);
    }

    public function edit(Book $book,Review $review)
    {
        if($review->book!=$book){
            return abort(404);
        }
        return view('reviews.edit')->withBook($book)->withReview($review);
    }

    public function update(Request $request,Book $book, Review $review)
    {
        if($review->book!=$book){
            return abort(404);
        }
        $this->validate($request, [
            'title' => 'required',
            'text' => 'required'
        ]);

        $review->title = $request->title;
        $review->text = $request->text;
        $review->save();

        return redirect()->route('books.reviews.show', [$book, $review]);
    }

    public function destroy(Book $book, Review $review)
    {
        if($review->book!=$book){
            return abort(404);
        }

        $review->delete();

        return redirect()->route('books.reviews.index', $book);
    }
}
