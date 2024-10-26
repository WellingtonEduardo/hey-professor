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


        <hr class="my-6 border-dashed border-gray-700">

        <div class="mb-2 font-bold uppercase dark:text-gray-400">
            DRAFTS
        </div>

        <div class="space-y-4 dark:text-gray-400">

            <x-table>
                <x-table.thead>
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Question
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </x-table.thead>

                <tbody>
                    @foreach ($questions->where('draft', true) as $item)
                        <x-table.tr>
                            <x-table.td>
                                {{ $item->question }}
                            </x-table.td>

                            <x-table.td>

                                <x-form :action="route('question.destroy', $item)" delete onsubmit="return confirm('Tem certeza?')">
                                    <button type="submit" class="text-red-500 hover:underline">
                                        Deletar
                                    </button>
                                </x-form>

                                <x-form :action="route('question.publish', $item)" put>
                                    <button type="submit" class="text-blue-500 hover:underline">
                                        Publicar
                                    </button>
                                </x-form>

                                <a href="{{ route('question.edit', $item) }}" class="text-blue-500 hover:underline">
                                    Editar
                                </a>

                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </tbody>

            </x-table>
        </div>



        <hr class="my-6 border-dashed border-gray-700">

        <div class="mb-2 font-bold uppercase dark:text-gray-400">
            MY QUESTIONS
        </div>

        <div class="space-y-4 dark:text-gray-400">

            <x-table>
                <x-table.thead>
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Question
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </x-table.thead>

                <tbody>
                    @foreach ($questions->where('draft', false) as $item)
                        <x-table.tr>
                            <x-table.td>
                                {{ $item->question }}
                            </x-table.td>

                            <x-table.td>

                                <x-form :action="route('question.destroy', $item)" delete onsubmit="return confirm('Tem certeza?')">
                                    <button type="submit" class="text-red-500 hover:underline">
                                        Deletar
                                    </button>
                                </x-form>

                                <x-form :action="route('question.archive', $item)" patch>
                                    <button type="submit" class="text-blue-500 hover:underline">
                                        Arquive
                                    </button>
                                </x-form>

                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </tbody>

            </x-table>
        </div>



        <hr class="my-6 border-dashed border-gray-700">

        <div class="mb-2 font-bold uppercase dark:text-gray-400">
            ARCHIVED QUESTIONS
        </div>

        <div class="space-y-4 dark:text-gray-400">

            <x-table>
                <x-table.thead>
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Question
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </x-table.thead>

                <tbody>
                    @foreach ($archivedQuestions as $item)
                        <x-table.tr>
                            <x-table.td>
                                {{ $item->question }}
                            </x-table.td>

                            <x-table.td>


                                <x-form :action="route('question.restore', $item)" patch>
                                    <button type="submit" class="text-blue-500 hover:underline">
                                        Restore
                                    </button>
                                </x-form>


                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </tbody>

            </x-table>
        </div>




    </x-container>
</x-app-layout>
