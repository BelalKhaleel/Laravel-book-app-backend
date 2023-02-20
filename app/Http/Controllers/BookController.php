<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{
    public function addAuthor(Request $request){
         
        $author = new Author;
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $author->first_name = $firstname;
        $author->last_name = $lastname;
        $author->save();
        return response()->json([
            'message' => 'Author created successfully!',
     
        ]);
    }


    public function addProfile(Request $request){
         
        $profile = new Profile;
        $about = $request->input('about');
        $social = $request->input('social_link');
        $author_id = $request->input('author_id');
        $author = Author::find($author_id);
        $profile->about = $about;
        $profile->social_media_link = $social;
        $profile->author()->associate($author);
        $profile->save();
        return response()->json([
            'message' => 'Profile created successfully!',
     
        ]);


    }

    public function getAuthor(Request $request, $id){
         
        $author =  Author::find($id)->with(['profile'])->get();
  
        return response()->json([
            'message' => $author,
     
        ]);
    }

    public function addCategory(Request $request){
         
        $category = new Category;
        $name = $request->input('name');

        $category->name = $name;
        $category->save();
        return response()->json([
            'message' => 'Category created successfully!',
     
        ]);
    }

    public function addBook(Request $request){
         $book = new Book;
         $author_id = $request->input('author_id');
         $author = Author::find($author_id);
         $title = $request->input('title');
         $description = $request->input('description');
         $categories = json_decode($request->input('categories'));
        //  return response()->json([
        //     'message' => $request->all(),
     
        // ]);
         $image_path = $request->file('image')->store('images','public');
         $book->title =$title;
         $book->description = $description;
         $book->image = $image_path;
         $book->author()->associate($author);
         $book->save();
         $book->categories()->sync($categories);
        return response()->json([
            'message' => 'Book created successfully!',
     
        ]);
    }


    public function getBook(Request $request, $id){
         
        $book =  Book::where('id',$id)->with(['author','categories'])->get();
  
        return response()->json([
            'message' => $book,
     
        ]);
    }

    public function editBook(Request $request, $id){
        $book =  Book::find($id);
        $inputs= $request->except('image','categories','_method');
        $book->update($inputs);
        if($request->has('categories')){
            $book->categories()->sync(json_decode($request->input('categories')));
        }
        if($request->hasFile('image')){
            Storage::delete('public/'.$book->image);
            $image_path = $request->file('image')->store('images','public');
            $book->update(['image' => $image_path]);

        }

        return response()->json([
            'message' => 'Book edited successfully!',
            'book' => $book,
     
        ]);
  
   }

   public function deleteAuthor(Request $request, $id){
         
    $author =  Author::find($id);
    $author->delete();
    return response()->json([
        'message' => 'Author deleted Successfully!',
 
    ]);
}
   
}
