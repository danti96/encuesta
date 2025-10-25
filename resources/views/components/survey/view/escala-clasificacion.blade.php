<template x-if="rows.type==='escala_clasificacion'">
    <div x-data="{
        numScal: rows.options.length,
        selected: null,
        colorScale: ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-lime-400', 'bg-green-500', 'bg-green-600'],
        generateList() {
            if (!this.numScal || this.numScal < 0) {
                rows.options = [];
                return;
            }
            rows.options = Array.from(Array(this.numScal).keys())
        },
    }">
        {{-- Paso 2: Nombre y descripción --}}
        <div class="flex justify-between">
            <h2 class="text-xl sm:text-2xl text-gray-900 dark:text-white font-bold px-3">
                Pregunta <span x-text="index + 1"></span> - Escala de clasificación
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
            <div class="w-full mx-auto">
                <label for="pregunta" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Pregunta
                </label>
                <textarea x-model="rows.question"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    rows="3"></textarea>
            </div>
            <div class="w-full mx-auto">
                <label for="pregunta" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Ingrese el número de la escala
                </label>
                <input type="number" min="0" max="11" x-model.number="numScal" @input="generateList"
                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <div class="w-full mx-auto flex justify-center flex-wrap gap-3">
                <template x-for="(option, indexOption) in rows.options" :key="indexOption">
                    <div @click="selected=option"
                        class="flex items-center justify-center w-10 h-10 text-sm font-semibold text-white transition-all duration-200 rounded-md cursor-pointer sm:w-12 sm:h-12"
                        :class="selected == option ? 'bg-indigo-500 ring-2 ring-gray-700' :
                            colorScale[Math.floor(indexOption / 2)]">
                        <span x-text="indexOption"></span>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>
