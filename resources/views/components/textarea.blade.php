@props(['name', 'label', 'value' => null])

<div class="mb-4">
    <label for="{{ $name }}" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
        {{ $label }}
    </label>
    <textarea name="{{ $name }}" id="{{ $name }}" rows="4"
        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
        placeholder="Ask me anything...">{{ old($name, $value) }}</textarea>

    @error($name)
        <span class="text-red-500">
            {{ $message }}
        </span>
    @enderror
</div>
