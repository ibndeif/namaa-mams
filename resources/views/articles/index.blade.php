<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Articles') }}
        </h2>
    </x-slot>

    <x-section>
        <form method="GET" action="{{ route('articles.index') }}">
            <div class="flex ">
                <!-- Search term input -->
                <x-text-input class=" mt-1 mr-6" type="text" name="term" :value="request('term')" placeholder="Search Term" />
                <x-select-input class=" mt-1 mr-6" name="status" :value="request('status')" :options="[''=>'All', ...\App\Enum\ArticleStatus::toArrayForSelectInput()]" placeholder="Search Term" />


                <!-- Search Button -->
                <x-secondary-button type="submit" class=" mt-1">{{ __('Search') }}</x-secondary-button>

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
            <tbody class="divide-y divide-gray-200 dark:divide-gray-500">
                @foreach($articles as $article)
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-500">
                    <td class="px-6 py-4 whitespace-nowrap text-sm"><img src="{{ $article->image }}" class="object-fill" alt=""></td>
                    <td class=" px-6 py-4 whitespace-nowrap text-sm">{{ Str::limit($article->title, 50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $article->author->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $article->status }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $article->created_at }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a class="text-blue-500 hover:text-blue-700" href="#">Delete</a>
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
