<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Vote for a question') }}
        </x-header>
    </x-slot>

    <x-container>

        <form action="{{ route('dashboard') }}" method="GET" class="flex space-x-2">
            @csrf
            <x-text-input type="text" name="search" value="{{ request()->search }}" class="flex-1" />
            <x-btn.primary type="submit">
                Search
            </x-btn.primary>
        </form>



        <div class="mt-4 space-y-4 dark:text-gray-400">

            @if ($questions->isEmpty())
                <div class="m-auto flex justify-center dark:text-gray-300">

                    <div class="text-center">
                        <x-draw.searching width="300" />

                        <p class="mt-6 text-2xl dark:text-gray-300">
                            No questions found.
                        </p>
                    </div>

                </div>
            @else
                @foreach ($questions as $item)
                    <x-question :question="$item" />
                @endforeach

                {{ $questions->withQueryString()->links() }}

            @endif





        </div>

    </x-container>
</x-app-layout>
