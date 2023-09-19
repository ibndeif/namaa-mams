<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Articles') }}

            <x-action-link :href="route('articles.create')" class="text-white bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 focus:outline-none dark:focus:ring-blue-800 float-right  hover:text-gray-700">Create Article</x-action-link>
        </h2>

    </x-slot>

    <x-section>
        <form method="GET" action="{{ route('articles.index') }}">
            <div class="flex ">
                <!-- Search term input -->
                <x-text-input class=" mt-1 mr-6" type="text" name="term" :value="request('term')" placeholder="Search Term" />
                <x-select-input class=" mt-1 mr-6" name="status" :value="request('status')" :options="[''=>'All', ...\App\Enum\ArticleStatus::toArrayForSelectInput()]" placeholder="Search Term" />

                <!-- show my articles only -->
                <input type="checkbox" id="my-articles-only" name="my-articles-only" value="true" {{request('my-articles-only') == 'true'?'checked':''}} class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-5">
                <label for="my-articles-only" class="mt-4 ml-2">My articles only</label>

                <!-- Search Button -->
                <x-secondary-button type="submit" class=" mt-1 ml-2">{{ __('Search') }}</x-secondary-button>

            </div>
        </form>
    </x-section>

    <x-section>
        @if($articles->isEmpty())
        <p>{{ __('No Articles found') }}</p>
        @else
        <table class="table-auto min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead>
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">title</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created At</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-200">
                @foreach($articles as $article)
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-200">
                    <td class="px-6 py-4 whitespace-nowrap text-sm"><img src="{{ $article->image }}" class="object-fill" alt=""></td>
                    <td class=" px-6 py-4 whitespace-nowrap text-sm">{{ Str::limit($article->title, 40) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $article->author->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $article->status }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $article->created_at }}</td>
                    <td class="px-6 py-4 flex whitespace-nowrap divide-x-2 divide-gray-100 text-sm font-medium">
                        <x-action-link :show="Auth::user()->can('view', $article)" href="{{route('articles.show', $article->id)}}">View</x-action-link>
                        <x-action-link :show="Auth::user()->can('update', $article)" href="{{route('articles.edit', $article->id)}}">Edit</x-action-link>
                        <x-action-link :show="$article->status !== App\Enum\ArticleStatus::Published && Auth::user()->can('publish', $article)" method="PATCH" href="{{route('articles.publish', $article->id)}}" confirm="Are you sure to publish {{$article->title}}?">Publish</x-action-link>
                        <x-action-link :show="$article->status === App\Enum\ArticleStatus::Published && Auth::user()->can('unpublish', $article)" method="PATCH" href="{{route('articles.unpublish', $article->id)}}" confirm="Are you sure to unpublish {{$article->title}}?">Unpublish</x-action-link>
                        <x-action-link :show="Auth::user()->can('delete', $article)" method="DELETE" href="{{route('articles.destroy', $article->id)}}" confirm="Are you sure to delete {{$article->title}}?">Delete</x-action-link>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

        <div class="mt-6">
            {{ $articles->withQueryString()->links() }}
        </div>

        @endif
    </x-section>
</x-app-layout>
