<template x-if="rows.type==='opcion_multiple'">
    <div>
        <div class="flex w-full p-4 border-l-4 rounded-lg shadow-sm bg-gray-50 dark:bg-gray-700 border-hsp-600">
            <div class="flex-shrink-0 mr-3">
                <i class="text-xl fa-solid fa-question-circle text-hsp-600"></i>
            </div>
            <label class="block text-sm font-semibold text-gray-900 dark:text-gray-100 sm:text-base">
                <span x-text="rows.question"></span>
            </label>
        </div>
        <div class="flex flex-wrap w-full gap-2 mt-4">
            <template x-for="(option, index) in rows.options" :key="index">
                <button
                    class="px-4 py-2 text-sm font-semibold transition-all duration-200 border rounded-full bg-white text-gray-700 border-gray-300 hover:bg-gray-100">
                    <span x-text="option.value"></span>
                </button>
            </template>
        </div>
    </div>
</template>
