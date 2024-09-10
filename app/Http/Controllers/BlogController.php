<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }
    /**
     * Display a listing of the resource.
     */

     
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Blog $blog, User $user)
    {
        // dd($user->id);
    
        $commentField = $request->validate([
            'comment' => 'required|string'
        ]);

        $commentField['user_id'] = $user->id;
        
        $comment = $blog->create($commentField);
        // dd($comment);

        // $comment = Blog::create([
        //     'user_id' => $user->id,
        //     'comment' => $request->input('comment')
        // ]);

        return response()->json([
            'message' => 'comment created successfully',
            'comment' => $comment
        ]);


    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
