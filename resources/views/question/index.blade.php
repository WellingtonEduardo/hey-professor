<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('My Questions') }}
        </x-header>
    </x-slot>

    <x-container>
        <x-form post :action="route('question.store')">
            <x-textarea name="question" label="Question" />
            <x-btn.primary>Save</x-btn.primary>
            <x-btn.reset>Cancel</x-btn.reset>
        </x-form>

        <hr class="my-4 border-dashed border-gray-700">

        <div class="mb-2 font-bold uppercase dark:text-gray-400">
            My Question
        </div>

        <div class="space-y-4 dark:text-gray-400">

            @foreach ($questions as $item)
                <x-question :question="$item" />
            @endforeach
        </div>

    </x-container>
</x-app-layout>
