<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Articles') }}
        </h2>
    </x-slot>



    <x-section>
        <article>
            <h2 class="text-4xl font-semibold text-gray-800 leading-tight">{{$article->title}} </h2>
            <div>
                <div class="flex space-x-1 float-right">
                    <x-action-link href="{{route('articles.edit', $article->id)}}">Edit</x-action-link>&nbsp;|
                    @if($article->status !== App\Enum\ArticleStatus::Published)
                    <x-action-link method="PATCH" href="{{route('articles.publish', $article->id)}}" confirm="Are you sure to publish {{$article->title}}?">Publish</x-action-link>&nbsp;|
                    @else
                    <x-action-link method="PATCH" href="{{route('articles.unpublish', $article->id)}}" confirm="Are you sure to unpublish {{$article->title}}?">Unpublish</x-action-link>&nbsp;|
                    @endif
                    <x-action-link method="DELETE" href="{{route('articles.destroy', $article->id)}}" confirm="Are you sure to delete {{$article->title}}?">Delete</x-action-link>
                </div>
                <p class="">By {{$article->author->name}}, {{$article->created_at->diffForHumans()}}</p>
            </div>
            <img class="w-full object-cover lg:rounded mt-12" src="{{$article->image}}" alt="">
            <div class="px-4 lg:px-0 mt-12 text-gray-700 text-lg leading-relaxed w-full ">{{$article->body}}</div>
        </article>
    </x-section>
</x-app-layout>
