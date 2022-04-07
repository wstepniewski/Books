<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $review->title }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="bg-white shadow overflow-hidden sm:rounded-lg">

                    <div class="border-t border-gray-200">
                        <dl>

                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Text
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <x-markdown>
                                        {{ $review->text }}
                                    </x-markdown>
                                </dd>
                            </div>
                            <div class="bg-white px-4 pb-5 flex items-center justify-end mt-4">

                                <form method="get" action="{{ route('books.reviews.edit', [$book, $review]) }}">

                                    <x-button class="ml-4">
                                        {{ __('Edit') }}
                                    </x-button>
                                </form>

                                <form method="post" action="{{ route('books.reviews.destroy', [$book, $review]) }}">

                                    @csrf
                                    @method("DELETE")

                                    <x-button class="ml-4">
                                        {{ __('Delete') }}
                                    </x-button>
                                </form>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
