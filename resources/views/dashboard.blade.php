<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Vote for a question') }}
        </x-header>
    </x-slot>

    <x-container>

        <div class="mb-2 font-bold uppercase dark:text-gray-400">Lista de perguntas</div>

        <div class="space-y-4 dark:text-gray-400">
            @foreach ($questions as $item)
                <x-question :question="$item" />
            @endforeach
        </div>

    </x-container>
</x-app-layout>
