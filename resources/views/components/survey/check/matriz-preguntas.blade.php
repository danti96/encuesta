<template x-if="rows.type==='matriz_preguntas'">
    <div>
        <!-- Título -->
        <div class="text-center">
            <h3 class="text-base font-bold text-gray-700">
                <span x-text="rows.title ?? ''"></span>
            </h3>
        </div>
        <!-- 💻 Vista en tabla para pantallas grandes -->
        <div class="hidden overflow-x-auto sm:block">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr>
                        <th class="p-3 text-left bg-gray-100 rounded-tl-lg"></th>
                        <template x-for="(head, index) in rows.columns" :key="index">
                            <th class="p-3 font-semibold text-center text-white bg-blue-700">
                                <span x-text="head.value"></span>
                            </th>
                        </template>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(option, index) in rows.options" :key="index">
                        <tr class="transition border-b hover:bg-gray-50">
                            <!-- Texto de la fila -->
                            <td class="p-3 font-medium text-gray-700 bg-white">
                                <span x-text="option.value"></span>
                            </td>

                            <!-- Radios -->
                            <template x-for="(head, idx) in rows.columns" :key="idx">
                                <td class="p-3 text-center bg-white">
                                    <input type="radio" class="w-4 h-4 text-hsp-600 focus:ring-hsp-500">
                                </td>
                            </template>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <!-- 📱 Vista tipo tarjetas en móviles -->
        <div class="block space-y-3 sm:hidden">
            <template x-for="(option, index) in rows.options" :key="index">
                <div class="p-4 bg-white border rounded-lg shadow-sm">

                    <!-- Texto de la pregunta -->
                    <h4 class="mb-2 text-sm font-semibold text-gray-800">
                        <span x-text="option.value"></span>
                    </h4>

                    <!-- Opciones tipo íconos -->
                    <div class="flex items-center justify-between gap-1 text-xs">
                        <template x-for="(head, idx) in rows.columns" :key="idx">
                            <label class="flex flex-col items-center gap-1 cursor-pointer">
                                <input type="radio" class="sr-only peer">
                                <div
                                    class="flex items-center justify-center w-12 h-12 p-2 text-gray-700 transition border border-gray-300 rounded-lg peer-checked:border-hsp-600 peer-checked:bg-blue-50">
                                    <!-- Íconos según la opción -->
                                    <template x-if="head.value == 'Muy Insatisfecho'">
                                        <i class="text-lg text-red-500 fa-solid fa-face-sad-cry"></i>
                                    </template>
                                    <template x-if="head.value == 'Insatisfecho'">
                                        <i class="text-lg text-orange-400 fa-solid fa-face-frown"></i>
                                    </template>
                                    <template x-if="head.value == 'Neutral'">
                                        <i class="text-lg text-gray-500 fa-solid fa-face-meh"></i>
                                    </template>
                                    <template x-if="head.value == 'Satisfecho'">
                                        <i class="text-lg text-green-500 fa-solid fa-face-smile"></i>
                                    </template>
                                    <template x-if="head.value == 'Muy Satisfecho'">
                                        <i class="text-lg text-blue-500 fa-solid fa-face-laugh-beam"></i>
                                    </template>
                                </div>
                                <span class="text-[10px] font-medium text-gray-600 text-center leading-tight"
                                    x-text="head.value"></span>
                            </label>
                        </template>
                    </div>
                </div>

            </template>


        </div>
    </div>
</template>
