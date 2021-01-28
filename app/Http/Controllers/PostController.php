<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Auth;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $posts = auth()
            ->user()
            ->posts()
            ->with('user')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        if ($posts == null || !$posts->first())
            return response()->json(['message' => 'No more posts'], 404);

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate(
            $request,
            [
                'content' => 'required',
                'image' => 'image'
            ]
        );

        $attachment = null;

        if ($request->hasFile('image'))
        {
            $file_name = Uuid::uuid();
            $file = $request->file('image');
            $file->storeAs('uploads', $file_name, 'public');
            $path = '/uploads/' . $file_name;
            $attachment = [
                'path' => $path,
                'type' => 'image',
                'name' => $file_name
            ];
        }

        $post = new Post([
            'content' => $data['content'],
            'attachment' => $attachment,
        ]);

        auth()->user()->posts()->save($post);

        $post->load('user');

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }
    /**
     * feed front page app
     *
     * we are getting all the posts of users we followed
     *
     * @return PostCollection
     **/

    public function feed()
    {
        $user = Auth::user();

        $feed = Post::with('user')
            ->whereHas('user', function ($query) use ($user)
            {
                $query->whereHas('followers', function ($q) use ($user)
                {
                    $q->where('user_id', $user->id);
                });
            })
            ->with(([
                'comments' => function ($query)
                {
                    $query->with('user')
                        ->orderBy('created_at', 'ASC');
                },
            ]))
            ->withCount('comments as total_comments')
            ->orWhere('user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        return PostResource::collection($feed);
    }


    public function destroy(Post $post)
    {
        //
    }
}
