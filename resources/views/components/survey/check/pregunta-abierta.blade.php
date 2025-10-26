<template x-if="rows.type==='pregunta_abierta'">
    <div>
        <label class="block mb-2 text-sm font-semibold text-gray-800 dark:text-gray-200">
            <span x-text="rows.question"></span>
        </label>

        <textarea maxlength="300" rows="4"
            class="block w-full p-2.5 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500"
            placeholder="Responde brevemente..."></textarea>

        <div class="mt-1 text-xs text-right text-gray-500 dark:text-gray-400">
            <span x-text="`${0}/300`"></span> caracteres
        </div>

    </div>
</template>
