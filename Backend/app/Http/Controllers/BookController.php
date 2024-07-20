<?php
namespace App\Http\Controllers;

use App\Models\BorrowedBook;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function search(Request $request) {
        $query = Book::query();

        $searchQuery = $request->input('query');

        if ($searchQuery) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('title', 'like', "%{$searchQuery}%")
                  ->orWhere('description', 'like', "%{$searchQuery}%")
                  ->orWhere('genre', 'like', "%{$searchQuery}%");
            });
        }

        $books = $query->paginate(10); // Paginate the results

        return response()->json($books);
    }



    public function borrow($id) {
        $user = Auth::user();

        $borrowedBook = BorrowedBook::create([
            'user_id' => $user->id,
            'book_id' => $id,
        ]);

        return response()->json($borrowedBook, 200);
    }

    public function returnBook($id) {
        $user = Auth::user();

        BorrowedBook::where('user_id', $user->id)
            ->where('book_id', $id)
            ->delete();

        return response()->json(['message' => 'Book returned successfully'], 200);
    }

    public function getBorrowedBooks() {
        $user = Auth::user();

        $borrowedBooks = BorrowedBook::with('book')
            ->where('user_id', $user->id)
            ->get();

        return response()->json($borrowedBooks);
    }


    public function index()
    {
        // Adjust the number of items per page as needed
        $books = Book::paginate(10);

        return response()->json($books); // Return as JSON
    }



}
