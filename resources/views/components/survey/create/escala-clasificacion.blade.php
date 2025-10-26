<template x-if="typeQuestion==='escala_clasificacion'">
    <div x-data="{
        question: '¿Cómo calificaría la amabilidad del personal que le atendió?',
        numScal: 11,
        options: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
        selected: null,
        colorScale: ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-lime-400', 'bg-green-500', 'bg-green-600'],
        generateList() {
            if (!this.numScal || this.numScal < 0) {
                this.options = [];
                return;
            }
            this.options = Array.from(Array(this.numScal).keys())
        },
        pushQuestion() {
            if (this.numScal == 0) {
                alert('No se puede agregar una pregunta vacía.');
                return;
            }
            $dispatch('add-question', { type: 'escala_clasificacion', question: this.question, options: this.options });
            this.reset();
            createQuestion = !createQuestion;
        },
        reset() {
            this.question = '';
            this.numScal = 0;
            this.options = [];
            this.selected = null;
            createQuestion = !createQuestion;
        }
    }">
        {{-- Paso 2: Nombre y descripción --}}
        <h2 class="text-xl sm:text-2xl text-gray-900 dark:text-white font-bold px-3">
            Escala de clasificación
        </h2>

        <div class="p-4 text-sm px-3 font-semibold py-1 rounded-lg space-y-2">
            <div class="w-full mx-auto">
                <label for="pregunta" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Pregunta
                </label>
                <textarea x-model="question"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    rows="3"></textarea>
            </div>
            <div class="w-full mx-auto">
                <label for="pregunta" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Ingrese el número de la escala
                </label>
                <input type="number" min="0" max="11" x-model.number="numScal" @input="generateList"
                    id="numscal-input-tag"
                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <div class="w-full mx-auto flex justify-center flex-wrap gap-3">
                <template x-for="(option, index) in options" :key="index">
                    <div @click="selected=option"
                        class="flex items-center justify-center w-10 h-10 text-sm font-semibold text-white transition-all duration-200 rounded-md cursor-pointer sm:w-12 sm:h-12"
                        :class="selected == option ? 'bg-indigo-500 ring-2 ring-gray-700' :
                            colorScale[Math.floor(index / 2)]">
                        <span x-text="index"></span>
                    </div>
                </template>
            </div>
        </div>

        <div class="flex justify-between sm:justify-center w-full px-4 py-3 sm:gap-4">
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
