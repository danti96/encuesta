<template x-if="rows.type==='matriz_preguntas'">
    <div>
        {{-- Paso 2: Nombre y descripción --}}
        <div class="flex justify-between">
            <h2 class="text-xl sm:text-2xl text-gray-900 dark:text-white font-bold px-3">
                Pregunta <span x-text="index + 1"></span> - Matriz de preguntas
            </h2>
            <buttom @click="removeQuestion(index);"
                class="cursor-pointer bg-red-600 hover:bg-red-800 text-white text-sm px-3 py-2 font-semibold rounded-lg disabled:bg-gray-500 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
                Remover
            </buttom>
        </div>

        <div class="p-4 text-sm px-3 font-semibold py-1 rounded-lg space-y-2">
            <div class="flex flex-col gap-2">
                <label for="title"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Título</label>
                <input type="text" x-model="rows.title" id="title"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
        </div>
        <div class="p-4 text-sm px-3 font-semibold py-1 rounded-lg space-y-2">
            <div class="flex flex-col gap-2">
                <label for="pregunta"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pregunta</label>
                <textarea x-model="rows.question" id="pregunta"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    rows="4"></textarea>

            </div>
        </div>
        <div class="p-4 text-sm px-3 py-1 rounded-lg space-y-2">
            <div class="hidden sm:block">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th colspan="6" class="text-left">
                                <b>Columnas:</b>
                            </th>
                        </tr>
                        <tr>
                            <th></th>
                            <th class="px-2">
                                <input type="text" x-model="rows.columns[0]['value']"
                                    class="uppercase pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 max-w-96 text-xs
                                    appearance-none focus:outline-none focus:ring-0 focus:border-b-hsp-500 border-gray-200" />
                            </th>
                            <th class="px-2">
                                <input type="text" x-model="rows.columns[1]['value']"
                                    class="uppercase pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 max-w-96 text-xs
                                    appearance-none focus:outline-none focus:ring-0 focus:border-b-hsp-500 border-gray-200" />
                            </th>
                            <th class="px-2">
                                <input type="text" x-model="rows.columns[2]['value']"
                                    class="uppercase pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 max-w-96 text-xs
                                    appearance-none focus:outline-none focus:ring-0 focus:border-b-hsp-500 border-gray-200" />
                            </th>
                            <th class="px-2">
                                <input type="text" x-model="rows.columns[3]['value']"
                                    class="uppercase pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 max-w-96 text-xs
                                    appearance-none focus:outline-none focus:ring-0 focus:border-b-hsp-500 border-gray-200" />
                            </th>
                            <th class="px-2">
                                <input type="text" x-model="rows.columns[4]['value']"
                                    class="uppercase pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 max-w-96 text-xs
                                    appearance-none focus:outline-none focus:ring-0 focus:border-b-hsp-500 border-gray-200" />
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="grid sm:hidden">
                <div class="w-full space-y-2">
                    <div class="py-2 w-full">
                        <div class="p-2 w-full font-medium rounded-md">
                            Columnas:
                        </div>
                    </div>
                    <div class="flex px-2 items-center gap-2">
                        <span class="pl-1"><b>1</b></span> <input type="text" x-model="rows.columns[0]['value']"
                            class="uppercase pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 max-w-96 text-xs
                            appearance-none focus:outline-none focus:ring-0 focus:border-b-hsp-500 border-gray-200" />
                    </div>
                    <div class="flex px-2 items-center gap-2">
                        <span class="pl-1"><b>2</b></span> <input type="text" x-model="rows.columns[1]['value']"
                            class="uppercase pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 max-w-96 text-xs
                            appearance-none focus:outline-none focus:ring-0 focus:border-b-hsp-500 border-gray-200" />
                    </div>
                    <div class="flex px-2 items-center gap-2">
                        <span class="pl-1"><b>3</b></span> <input type="text" x-model="rows.columns[2]['value']"
                            class="uppercase pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 max-w-96 text-xs
                            appearance-none focus:outline-none focus:ring-0 focus:border-b-hsp-500 border-gray-200" />
                    </div>
                    <div class="flex px-2 items-center gap-2">
                        <span class="pl-1"><b>4</b></span> <input type="text" x-model="rows.columns[3]['value']"
                            class="uppercase pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 max-w-96 text-xs
                            appearance-none focus:outline-none focus:ring-0 focus:border-b-hsp-500 border-gray-200" />
                    </div>
                    <div class="flex px-2 items-center gap-2">
                        <span class="pl-1"><b>5</b></span> <input type="text" x-model="rows.columns[4]['value']"
                            class="uppercase pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 max-w-96 text-xs
                            appearance-none focus:outline-none focus:ring-0 focus:border-b-hsp-500 border-gray-200" />
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 text-sm px-3 py-1 rounded-lg space-y-2">
            <label for="sub-pregunta" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Sub Pregunta
            </label>
            <template x-for="(option, indexOption) in rows.options" :key="indexOption">
                <div class="flex w-full gap-3">
                    <button @click="removeOption(index, indexOption);"
                        class="text-xl p-1 text-red-800 transition ease-in-out delay-150 hover:translate-y-1 hover:scale-110 duration-300 w-8 ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5"
                                d="m14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21q.512.078 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48 48 0 0 0-3.478-.397m-12 .562q.51-.088 1.022-.165m0 0a48 48 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a52 52 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a49 49 0 0 0-7.5 0" />
                        </svg>
                    </button>
                    <input type="text" x-model="option.value"
                        class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
            </template>
            <button type="button" @click="addOption(index)"
                class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Nueva
                Pregunta</button>
        </div>
    </div>
</template>
