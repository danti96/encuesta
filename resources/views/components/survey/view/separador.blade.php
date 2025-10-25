<template x-if="rows.type==='separar_pregunta'">
    <div class="container px-4 py-8 mx-auto bg-white rounded-lg">
        {{-- Paso 2: Nombre y descripción --}}
        <div class="flex justify-between">
            <h2 class="text-xl sm:text-2xl text-gray-900 dark:text-white font-bold px-3">
                Pregunta <span x-text="index + 1"></span> - Separador
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
        <div class="flex flex-col items-center justify-between md:flex-row">
            {{-- Sección de título "PREGUNTAS FRECUENTES" --}}
            <div
                class="mb-6 text-4xl font-extrabold leading-none text-center text-blue-700 md:mb-0 custom-font md:text-left">
                <div class="flex flex-col items-center mt-12 text-3xl sm:flex-row sm:mt-4">
                    <i class="fa-solid fa-layer-group"></i>
                    <span x-text="rows.question"></span>
                </div>
            </div>

            {{-- Sección de burbujas de preguntas --}}
            <div class="relative hidden w-48 h-32 md:w-64 md:h-40 sm:block">
                <img src="{{ asset('images/Question_book.png') }}" alt="Question_book.png" srcset="">
            </div>
        </div>
    </div>
</template>
