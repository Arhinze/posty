@props(['post' => $post])

<div class="mb-4">
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
    <a href="{{ route('users.posts', $post->user) }}" class="font-bold"><b>{{ $post->user->name }}</b></a>
    <span class="text-gray-600 text-sm">{{ $post->created_at->diffForHumans() }}</span>

    <p class="mb-2"> <a href="{{ route('posts.show', $post->id) }}">{{ $post->body }} </a> </p>

    <div class="flex items-center">
        @auth
            @if(!$post->likedBy(auth()->user()))
                <form method="post" action="{{ route('posts.likes', $post->id) }}" class="mr-1">
                    <!-- Note: since we are using route model binding, we can skip the 
                    $post->id parameter of we want to -->
                    @csrf
                    <button type="submit" class="text-blue-500">Like</button>
                </form> &nbsp;
            @else 
                <form method="post" action="{{ route('posts.likes', $post->id) }}" class="mr-1">
                    <!-- Note: since we are using route model binding, we can skip the 
                    $post->id parameter of we want to -->
                    @csrf
                    @method("DELETE")
                    <!-- Lavarel Method Spoofing -->
                    <button type="submit" class="text-blue-500">Unlike</button>
                </form> &nbsp;
            @endif

            <!--    -->
            @can('delete',$post)
                <form method="post" action="{{ route('posts.destroy', $post) }}" class="mr-1">
                    <!-- Note: since we are using route model binding, we can skip the 
                    $post->id parameter of we want to -->
                    @csrf
                    @method("DELETE")
                    <!-- Lavarel Method Spoofing -->
                    <button type="submit" class="text-blue-500" style="color:red">Delete Post</button>
                </form> &nbsp;
           @endcan
            
        @endauth

        <span>{{ $post->likes->count() }} 
            <!-- To say 'like' when it's 1 like and 'likes' when the likes are more than 1:-->
            {{ Str::plural('like', $post->likes->count()) }}
        </span>
    </div>
</div>