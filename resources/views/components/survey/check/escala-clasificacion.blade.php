<template x-if="rows.type==='escala_clasificacion'">
    <div x-data="{
        colorScale: ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-lime-400', 'bg-green-500', 'bg-green-600'],
    }">
        <div class="flex w-full p-4 border-l-4 rounded-lg shadow-sm bg-gray-50 dark:bg-gray-700 border-hsp-600">
            <div class="flex-shrink-0 mr-3">
                <i class="text-xl fa-solid fa-question-circle text-hsp-600"></i>
            </div>
            <label class="block text-sm font-semibold text-gray-900 dark:text-gray-100 sm:text-base">
                <span x-text="rows.question"></span>
            </label>
        </div>
        <div class="p-4 text-center border rounded-lg bg-gray-50">
            <p class="mb-3 text-xs text-gray-500 sm:hidden">🔥 Rojo: baja recomendación | Verde: alta </p>

            <div class="flex flex-wrap justify-center gap-3">
                <template x-for="(option, index) in rows.options" :key="index">
                    <div class="flex items-center justify-center w-10 h-10 text-sm font-semibold text-white transition-all duration-200 rounded-md cursor-pointer sm:w-12 sm:h-12"
                        :class="colorScale[Math.floor(index / 2)]">
                        <span x-text="option.value"></span>
                    </div>
                </template>

            </div>

            <div class="flex justify-between mt-3 text-xs text-gray-600">
                <span> No recomendaría</span>
                <span> Sí recomendaría</span>
            </div>
        </div>
    </div>
</template>
