<template x-if="tipoPregunta==='separar_pregunta'">
    <div x-data="{
        question: '',
        generateUniqueId() {
            let id;
            do {
                id = Math.random().toString(36).substr(2, 9);
            } while (this.items.some(item => item.id === id));
            return id;
        },
        pushQuestion() {
            $dispatch('add-question', { type: 'separar_pregunta', question: this.question, id: this.generateUniqueId() });
            this.question = '';
        }
    }">
        <div class="p-4 text-sm px-3 font-semibold py-1 rounded-lg space-y-2">
            <div class="flex flex-col gap-2">
                <label for="Pregunta" class="block mb-2 text-sm">Separación:</label>
                <textarea x-model="question"
                    class="border rounded-lg border-gray-300 bg-gray-100 text-sm focus:ring-hsp-800 focus:border-hsp-800 block w-full"
                    rows="3"></textarea>
            </div>
        </div>

        <div class="flex justify-center gap-4 pt-4">
            <buttom @click="pushQuestion()"
                class="cursor-pointer bg-hsp-600 hover:bg-hsp-800 text-white text-sm px-3 py-2 font-semibold rounded-lg disabled:bg-gray-500">
                Agregar Pregunta
            </buttom>
            <buttom @click="resetQuestion()"
                class="cursor-pointer bg-red-600 hover:bg-red-800 text-white text-sm px-3 py-2 font-semibold rounded-lg disabled:bg-gray-500">
                Cancelar
            </buttom>
        </div>
    </div>
</template>
