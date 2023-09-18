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
                <div class="flex divide-x-2 divide-gray-100 float-right">
                    <x-action-link :show="Auth::user()->can('update', $article)" href="{{route('articles.edit', $article->id)}}">Edit</x-action-link>
                    <x-action-link :show="$article->status !== App\Enum\ArticleStatus::Published && Auth::user()->can('publish', $article)" method="PATCH" href="{{route('articles.publish', $article->id)}}" confirm="Are you sure to publish {{$article->title}}?">Publish</x-action-link>
                    <x-action-link :show="$article->status === App\Enum\ArticleStatus::Published && Auth::user()->can('unpublish', $article)" method="PATCH" href="{{route('articles.unpublish', $article->id)}}" confirm="Are you sure to unpublish {{$article->title}}?">Unpublish</x-action-link>
                    <x-action-link :show="Auth::user()->can('delete', $article)" method="DELETE" href="{{route('articles.destroy', $article->id)}}" confirm="Are you sure to delete {{$article->title}}?">Delete</x-action-link>
                </div>
                <p class="">By {{$article->author->name}}, {{$article->created_at->diffForHumans()}}</p>
            </div>
            <img class="w-full object-cover lg:rounded mt-12" src="{{$article->image}}" alt="">
            <div class="px-4 lg:px-0 mt-12 text-gray-700 text-lg leading-relaxed w-full ">{!! $article->body !!}</div>

            <!-- comments -->
            <section class="mt-10 space-y-6" id="comments">
                <form method="POST" action="{{route('comments.store', $article->id)}}#comments" class="border border-gray-200 p-6 rounded-xl">
                    @csrf()
                    <header>
                        <h2 class="font-bold">Leave a comment?</h2>
                    </header>
                    <div class="mt-5">
                        <x-text-area name="body" :value="old('body')" class="w-full" rows="5" placeholder="Place your comment here" />
                        <x-input-error :messages="$errors->first('body')" class="mt-2" />
                    </div>
                    <div class="flex justify-end">
                        <x-primary-button>Post Comment</x-primary-button>
                    </div>
                </form>
                @foreach($article->comments as $comment)
                <x-article-comment :comment="$comment"></x-article-comment>
                @endforeach
            </section>
        </article>
    </x-section>
</x-app-layout>
