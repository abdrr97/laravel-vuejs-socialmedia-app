<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;

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
        $this->validate(
            $request,
            [
                'content' => 'required',
                'image' => 'image'
            ]
        );

        $attachment = null;

        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $file_ext = '.' . $file->extension();
            $file_name =  now() . $file_ext;

            $file->storeAs('uploads', $file_name, 'public');
            $path = 'uploads/' . $file_name;
            $attachment = [
                'path' => $path,
                'name' => $file_name,
                'type' => 'image',
            ];
        }

        $post = new Post([
            'content' => $request->content,
            'attachment' => $attachment,
        ]);

        auth()->user()->posts()->save($post);

        $post->load('user');
        return new PostResource($post);
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
        $user = auth()->user();


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
                    $query->with('user')->orderBy('created_at', 'ASC');
                },
            ]))
            ->with('like')
            ->withCount('comments as total_comments')
            ->withCount('likes as total_likes')
            ->orWhere('user_id',  $user->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        return PostResource::collection($feed);
    }

    public function like(Post $post)
    {
        $like = $post->like()->first();

        if ($like)
        {
            $like->delete();

            return response()->json([
                'message' => 'Successfully Disliked post.',
                'like' => null,
                'total_likes' => $post->likes()->count()
            ]);
        }

        $like = $post->likes()->save(new PostLike(['user_id' => auth()->id()]));
        return response()->json([
            'message' => 'Successfully liked post.',
            'like' => $like,
            'total_likes' => $post->likes()->count()
        ]);
    }
    public function delete_post(Post $post)
    {

        if ($post->user->id != auth()->id())
            abort(403);

        if ($post == null || !$post->first())
            return response()->json(['message' => 'No post to delete'], 404);

        $post->delete();
        return response()->json(['success' => 'post was deleted successfully'], 200);
    }
}
