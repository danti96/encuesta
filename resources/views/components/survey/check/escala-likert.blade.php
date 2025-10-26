<template x-if="rows.type==='escala_likert'">
    <div>
        <div class="flex w-full p-4 border-l-4 rounded-lg shadow-sm bg-gray-50 dark:bg-gray-700 border-hsp-600">
            <div class="flex-shrink-0 mr-3">
                <i class="text-xl fa-solid fa-question-circle text-hsp-600"></i>
            </div>
            <label class="block text-sm font-semibold text-gray-900 dark:text-gray-100 sm:text-base">
                <span x-text="rows.question"></span>
            </label>
        </div>
        <div class="grid grid-cols-1 gap-3 "
            :class="[
                rows.options.length > 3 ? 'sm:grid-cols-4' : '',
                rows.options.length === 3 ? 'sm:grid-cols-3' : '',
                rows.options.length === 2 ? 'sm:grid-cols-2' : '',
            ]">
            <template x-for="(option, index) in rows.options" :key="index">
                <label x-bind:for="option.id"
                    class="p-3 text-center transition-all duration-200 border rounded-lg cursor-pointer border-gray-300 bg-white hover:bg-gray-50">
                    <input type="radio" class="hidden" :value="option?.id" x-bind:name="option?.id">
                    <span x-text="option.value"></span>
                </label>
            </template>
        </div>
    </div>
</template>
