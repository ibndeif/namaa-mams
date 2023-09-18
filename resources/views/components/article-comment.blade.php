@props(['comment'])

<article class="bg-gray-100 border-gray-200 p-6 rounded-xl">
    @can('delete', $comment)
    <div class="float-right">
        <x-action-link method="DELETE" href="{{route('comments.destroy', [$comment->article_id, $comment->id])}}" confirm="Are you sure to delete this comment?">Delete</x-action-link>
    </div>
    @endcan

    <div>
        <header class="mb-4">
            <h3 class="font-bold">{{$comment->author->name}}</h3>
            <p class="text-xs">Posted <time>{{$comment->created_at->diffForHumans()}}</time></p>
        </header>
        <p>{{$comment->body}}</p>
    </div>
</article>
