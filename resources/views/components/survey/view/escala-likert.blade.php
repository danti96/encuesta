<template x-if="rows.type==='escala_likert'">
    <div x-data="{
        selected: null,
        options: [{ value: 'Muy insatisfecho' }, { value: 'Insatisfecho' }, { value: 'Neutral' }, { value: 'Satisfecho' }, { value: 'Muy satisfecho' }],
    }">

        {{-- Paso 2: Nombre y descripción --}}
        <div class="flex justify-between">
            <h2 class="text-xl sm:text-2xl text-gray-900 dark:text-white font-bold px-3">
                Pregunta <span x-text="index + 1"></span> - Escala likert
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
                <div class="w-full pt-4 mx-auto">
                    <label for="pregunta" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Pregunta
                    </label>
                    <textarea x-model="rows.question"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        rows="3"></textarea>
                </div>
                <div class="w-full pt-4 mx-auto" x-data="{ view: true }">
                    <div class="mb-2 flex items-center gap-3">
                        <label for="pregunta" class="block text-sm font-medium text-gray-900 dark:text-white">
                            Opciones
                        </label>
                        <button @click="view = !view"
                            class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-lg dark:bg-gray-700 dark:text-gray-400 border border-gray-500">
                            <span x-show="view">Ver</span>
                            <span x-show="!view">Editar</span>
                        </button>
                    </div>

                    <div x-show="view" class="space-y-4">
                        <template x-for="(option, indexOption) in rows.options" :key="index">
                            <div class="flex w-full gap-3">
                                <button @click="removeOption(index, indexOption);"
                                    class="text-xl p-1 text-red-800 transition ease-in-out delay-150 hover:translate-y-1 hover:scale-110 duration-300 w-8 ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-full" viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.5"
                                            d="m14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21q.512.078 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48 48 0 0 0-3.478-.397m-12 .562q.51-.088 1.022-.165m0 0a48 48 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a52 52 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a49 49 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                                <input type="text" x-model="option.value"
                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>
                        </template>
                    </div>

                    <div x-show="!view" class="grid grid-cols-1 gap-3 "
                        :class="[
                            rows.options.length > 3 ? 'sm:grid-cols-5' : '',
                            rows.options.length === 3 ? 'sm:grid-cols-3' : '',
                            rows.options.length === 2 ? 'sm:grid-cols-2' : '',
                        ]">
                        <template x-for="(option, indexOption) in rows.options" :key="indexOption">
                            <label @click="selected = option" x-bind:for="option.value"
                                class="p-3 text-center transition-all duration-200 border rounded-lg cursor-pointer flex items-center justify-center gap-2"
                                :class="[
                                    selected === option ? 'border-blue-500 bg-blue-50 text-blue-700 shadow' :
                                    'border-gray-300 bg-white hover:bg-gray-50'
                                ]">
                                <input type="radio" class="hidden" :value="option"
                                    x-bind:name="option.value">
                                <span x-text="option.value"></span>
                            </label>
                        </template>
                    </div>

                </div>
            </div>
        </div>

        <div class="p-4 text-sm px-3 py-1 rounded-lg space-y-2">
            <div class="flex gap-2">
                <button @click="addOption(index)"
                    class="text-xl p-4 text-hsp-800 transition ease-in-out delay-150 hover:translate-y-1 hover:scale-110 duration-300 dark:text-white">
                    <div class="w-auto flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0a9 9 0 0 1 18 0" />
                        </svg>
                    </div>
                    <span class="hidden md:block sm:text-xs md:text-sm">Agregar</span>
                    <span class="block text-xs md:text-sm">Item</span>
                </button>
            </div>
        </div>
    </div>
</template>
