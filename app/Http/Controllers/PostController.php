<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware(['auth'])->only(['store', 'destroy']);
    }

    public function index(){
        // $posts = Post::get(); //collection
        //$posts = Post::orderBy('created_at','desc')->with(['user','likes'])->paginate(10); //collection 
        // OR :
        $posts = Post::latest()->with(['user','likes'])->paginate(10);

        return view('posts.index', [
            'posts'=>$posts
        ]);
    }

    public function show(Post $post){
        //$posts = $this->posts;
        //$posts = $user->posts()->latest()->with(['user','likes'])->paginate(10); //collection

        return view("posts.show", [
            'post'=>$post
        ]);
    }

    public function store(Request $request){
        //Validate
        $this->validate($request, [
            'body'=>'required'
        ]);

        $request->user()->posts()->create($request->only('body'));

        return back();
        //create post
        /*
        Post::create([
            'user_id' => auth()->id(),
            'body' => $request->body()
        ]);
        */

        /* auth()->user()->posts->create([

        ]);  OR ::: */

        /*
        $request->user()->posts()->create([
            'body'=>$request->body
            //laravel automatically adds the user_id attribute in the database for you from 
            //this user's $request object;
        ]); OR ::: */

        
    }

    public function destroy(Post $post, Request $request){
        //dd($post);
        /*
        if(!$post->ownedBy(auth()->user())){
            dd('sorry, access denied');
        }
        */
        $this->authorize('delete', $post);

        $post->delete();

        return back();
    }
}
