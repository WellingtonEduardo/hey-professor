@props(['question'])

<div
    class="flex items-center justify-between rounded p-3 shadow shadow-blue-500/50 dark:bg-gray-800/50 dark:text-gray-400">
    <span>{{ $question->question }}</span>
    <div class="space-y-1">
        <x-form :action="route('question.like', $question)">
            <button type="submit" class="flex items-start space-x-2 text-green-500">
                <x-icons.thumbs-up class="h-5 w-5 cursor-pointer hover:text-green-300" />
                <span>{{ $question->likes }}</span>
            </button>
        </x-form>

        <x-form :action="route('question.like', $question)">
            <button type="submit" class="flex items-start space-x-2 text-red-500">
                <x-icons.thumbs-down class="h-5 w-5 cursor-pointer hover:text-red-300" />
                <span> {{ $question->unlikes }}</span>

            </button>
        </x-form>
    </div>
</div>
