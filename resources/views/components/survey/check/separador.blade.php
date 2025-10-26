<template x-if="rows.type==='separar_pregunta'">
    <div class="container px-4 py-8 mx-auto bg-white rounded-lg">
        {{-- Paso 2: Nombre y descripción --}}
        <div class="flex justify-between">
            <h2 class="text-xl sm:text-2xl text-gray-900 dark:text-white font-bold px-3">
                Pregunta <span x-text="index + 1"></span> - Separador
            </h2>
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
