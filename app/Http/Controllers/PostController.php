<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Like;
use App\Comment;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

    }

    public function userPosts(Request $request)
    {
        $posts=Post::where(["user_id"=>auth()->user()->id])->get();
        $active_profile = "danger";
        return view('post_views/user_posts', compact('posts', 'active_profile'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('post_views/new_post');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if($request->hasfile('filename'))
        {
            $file = $request->file('filename');
            $name = time().$file->getClientOriginalName();
            $file->move(public_path().'/images/', $name);
        }
        $Post = new Post();
        $Post->body=$request->get('body');
        $Post->user_id=auth()->user()->id;
        $Post->image_path=$name;
        $Post->save();
        return redirect('Post/'.$Post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::with('user')->find($id);
        $count = Like::where('post_id', $id)->count();
        $userLike = Like::where(["user_id"=>auth()->user()->id, "post_id"=>$id])->get();
        $post_comments = Post::with('comments', 'comments.user')->find($id);
        return view('post_views/view_post', compact('post','count','userLike','post_comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::find($id);
        if($post->user_id==auth()->user()->id)
        return view('post_views/edit_post', compact('post'));
        else
        return redirect('not_found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $post = Post::find($id);
        if($post->user_id==auth()->user()->id){
            $post->body=$request->get('body');
            $post->save();
            return redirect('post/'.$id);
        }
        else
        return redirect('not_found');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::find($id);
        if($post->user_id==auth()->user()->id){
            $post->delete();
            return redirect('user/posts');
        }
        else
        return redirect('not_found');
    }
}
