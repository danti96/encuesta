<template x-if="typeQuestion==='matriz_preguntas'">
    <div x-data="{
        title: 'title',
        question: '¿Cómo calificaría la amabilidad del personal que le atendió?',
        option: '',
        options: [{ value: '¿Cómo calificaría la amabilidad del personal que le atendió?' }, { value: '¿Cómo calificaría la amabilidad del personal que le atendió?' }, { value: '¿Cómo calificaría la amabilidad del personal que le atendió?' }, { value: '¿Cómo calificaría la amabilidad del personal que le atendió?' }],
        columns: [
            { value: 'Muy Insatisfecho' },
            { value: 'Insatisfecho' },
            { value: 'Neutral' },
            { value: 'Satisfecho' },
            { value: 'Muy Satisfecho' },
        ],
        removeItem(index) {
            this.options = this.options.splice(index, 1);
        },
        addItem() {
            this.options.push({ value: this.option });
            this.option = '';
        },
        pushQuestion() {
            if (this.options.length == 0) {
                alert('No se puede agregar una pregunta vacía.');
                return;
            }
            $dispatch('add-question', { type: 'matriz_preguntas', title: this.title, question: this.question, options: this.options, columns: this.columns });
            this.options = [];
            this.option = '';
            this.question = '';
        },
        reset() {
            this.title = '';
            this.question = '';
            this.option = '';
            this.options = [{ value: '' }, { value: '' }, { value: '' }, { value: '' }];
            this.columns = [
                { value: 'Muy Insatisfecho' },
                { value: 'Insatisfecho' },
                { value: 'Neutral' },
                { value: 'Satisfecho' },
                { value: 'Muy Satisfecho' },
            ];
            createQuestion = !createQuestion;
        }
    }">
        <div class="p-4 text-sm px-3 font-semibold py-1 rounded-lg space-y-2">
            <div class="flex flex-col gap-2">
                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Título</label>
                <input type="text" x-model="title" id="title"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
        </div>
        <div class="p-4 text-sm px-3 font-semibold py-1 rounded-lg space-y-2">
            <div class="flex flex-col gap-2">
                <label for="pregunta"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pregunta</label>
                <textarea x-model="question" id="pregunta"
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
                                <input type="text" x-model="columns[0]['value']"
                                    class="uppercase pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 max-w-96 text-xs
                                    appearance-none focus:outline-none focus:ring-0 focus:border-b-hsp-500 border-gray-200" />
                            </th>
                            <th class="px-2">
                                <input type="text" x-model="columns[1]['value']"
                                    class="uppercase pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 max-w-96 text-xs
                                    appearance-none focus:outline-none focus:ring-0 focus:border-b-hsp-500 border-gray-200" />
                            </th>
                            <th class="px-2">
                                <input type="text" x-model="columns[2]['value']"
                                    class="uppercase pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 max-w-96 text-xs
                                    appearance-none focus:outline-none focus:ring-0 focus:border-b-hsp-500 border-gray-200" />
                            </th>
                            <th class="px-2">
                                <input type="text" x-model="columns[3]['value']"
                                    class="uppercase pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 max-w-96 text-xs
                                    appearance-none focus:outline-none focus:ring-0 focus:border-b-hsp-500 border-gray-200" />
                            </th>
                            <th class="px-2">
                                <input type="text" x-model="columns[4]['value']"
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
                        <span class="pl-1"><b>1</b></span> <input type="text" x-model="columns[0]['value']"
                            class="uppercase pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 max-w-96 text-xs
                            appearance-none focus:outline-none focus:ring-0 focus:border-b-hsp-500 border-gray-200" />
                    </div>
                    <div class="flex px-2 items-center gap-2">
                        <span class="pl-1"><b>2</b></span> <input type="text" x-model="columns[1]['value']"
                            class="uppercase pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 max-w-96 text-xs
                            appearance-none focus:outline-none focus:ring-0 focus:border-b-hsp-500 border-gray-200" />
                    </div>
                    <div class="flex px-2 items-center gap-2">
                        <span class="pl-1"><b>3</b></span> <input type="text" x-model="columns[2]['value']"
                            class="uppercase pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 max-w-96 text-xs
                            appearance-none focus:outline-none focus:ring-0 focus:border-b-hsp-500 border-gray-200" />
                    </div>
                    <div class="flex px-2 items-center gap-2">
                        <span class="pl-1"><b>4</b></span> <input type="text" x-model="columns[3]['value']"
                            class="uppercase pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 max-w-96 text-xs
                            appearance-none focus:outline-none focus:ring-0 focus:border-b-hsp-500 border-gray-200" />
                    </div>
                    <div class="flex px-2 items-center gap-2">
                        <span class="pl-1"><b>5</b></span> <input type="text" x-model="columns[4]['value']"
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
            <template x-for="(option, index) in options" :key="index">
                <div class="flex w-full gap-3">
                    <button @click="options.splice(index, 1);"
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
            <button type="button" @click="addItem()"
                class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Nueva
                Pregunta</button>
        </div>

        <div class="flex justify-center gap-4">
            <button type="button" @click="pushQuestion();" id="section-question-agg"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 48 48" stroke-width="3">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M36.756 4.347a5.56 5.56 0 0 0-3.234-1.172A242 242 0 0 0 24 3c-7.364 0-12.515.277-15.743.539c-2.555.208-4.51 2.163-4.718 4.718C3.277 11.485 3 16.636 3 24s.277 12.515.539 15.743c.208 2.555 2.163 4.51 4.718 4.718C11.485 44.723 16.636 45 24 45s12.515-.277 15.743-.539c2.555-.208 4.51-2.163 4.718-4.718C44.723 36.515 45 31.364 45 24c0-3.729-.071-6.89-.175-9.522a5.56 5.56 0 0 0-1.173-3.234c-.86-1.09-1.988-2.428-3.229-3.668c-1.24-1.24-2.578-2.368-3.667-3.229" />
                        <path
                            d="M31.293 3.1c.034.705.056 1.544.056 2.526a52 52 0 0 1-.064 2.687c-.088 1.694-1.412 2.938-3.107 3.01c-1.063.044-2.446.078-4.179.078s-3.115-.034-4.178-.079c-1.695-.07-3.019-1.315-3.107-3.009a52 52 0 0 1-.065-2.687c0-.982.023-1.821.057-2.526m19.656 41.59c.126-2.013.237-4.851.237-8.615c0-4.47-.156-7.635-.31-9.662c-.128-1.704-1.425-3.013-3.128-3.15c-1.95-.156-4.953-.313-9.162-.313s-7.212.157-9.161.314c-1.704.136-3 1.445-3.129 3.15c-.153 2.026-.31 5.191-.31 9.661c0 3.764.111 6.602.238 8.615M19 31h10m-10 6h6" />
                    </g>
                </svg>
                Agregar
            </button>
            <buttom @click="reset();"
                class="cursor-pointer bg-red-600 hover:bg-red-800 text-white text-sm px-3 py-2 font-semibold rounded-lg disabled:bg-gray-500 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
                Cancelar
            </buttom>
        </div>
    </div>
</template>
