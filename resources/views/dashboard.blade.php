@push('scripts')
    <script>
        const createSurvey = () => {
            return {
                currentStep: 0,
                steps: 2,
                form: {
                    nombre: '🧾 ENCUESTA DE CALIDAD DE SERVICIO',
                    descripcion: '',
                    survey: []
                },
                formValidate() {
                    if (this.form.nombre.trim() === '') {
                        alert('El nombre de la encuesta es obligatorio.');
                        return;
                    }
                    this.currentStep++;
                },
                addItem(question) {
                    this.form.survey.push(question)
                },
                buttonDisabled: false,
                store() {
                    if (this.form.survey.length == 0) {
                        Toast.warning(
                            'La encuesta no puede tener preguntas vacías, asegurese de agregar una pregunta.');
                        return;
                    }

                    this.buttonDisabled = true;
                    const route = `{{ route('encuesta.store') }}`;
                    const request = {
                        ...this.form,
                    }

                    const success = (e) => {
                        const message = (e?.data?.message) ? e?.data?.message : 'Encuesta creada correctamente.';
                        Toast.success(message);
                        this.buttonDisabled = false;
                    }

                    const failed = (e) => {
                        const message = (e?.response?.data?.message) ? e?.response?.data?.message :
                            'Error al crear encuesta, revise los datos ingresados o recarge la página.';
                        console.error(message);
                        Toast.warning(message);
                        this.buttonDisabled = false;
                    }

                    axios.post(route, request).then(success).catch(failed);
                }
            };
        };
        const componentSurveys = () => {
            return {
                questions: [],
                typeQuestion: 'matriz_preguntas',
                createQuestion: true,
                createComponent() {
                    if (this.typeQuestion == '') {
                        alert('Seleccione tipo de pregunta');
                        return;
                    }
                    this.createQuestion = !this.createQuestion;
                },
                addItem(detail) {
                    this.questions.push(detail);
                    this.createQuestion = true;
                },
                removeQuestion(index) {
                    this.questions.splice(index, 1);
                },
                removeOption(index, indexOption) {
                    this.questions[index].options.splice(indexOption, 1);
                },
                addOption(index) {
                    this.questions[index].options.push({
                        value: ''
                    });
                }
            }
        }
    </script>
@endpush
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Crear Encuesta
        </h2>
    </x-slot>
    <div class="p-8" x-data="createSurvey()">
        <div class="bg-white dark:bg-gray-800 shadow-md border dark:border-gray-800 rounded-md space-y-4 max-w-3xl mx-auto p-4"
            x-show="currentStep=== 0">
            {{-- Paso 1: Nombre y descripción --}}
            <h2 class="text-xl sm:text-2xl text-gray-900 dark:text-white font-bold px-4 pt-4">
                1 Paso: crear nombre y descripción de la encuesta
            </h2>
            <form @submit.prevent="formValidate()" class="space-y-4">
                <div class="p-4 text-sm px-3 font-semibold py-1 rounded-lg space-y-2">
                    <div class="flex flex-col gap-2">
                        <label for="Nombre"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre:</label>
                        <input type="text" x-model="form.nombre" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="Nombre"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción:</label>
                        <textarea x-model="form.descripcion"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            rows="3"></textarea>
                    </div>
                </div>
                {{-- Opciones  --}}
                <div class="flex justify-end w-full px-4 py-3 gap-4">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Siguiente
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <div x-data="componentSurveys()" @add-question="addItem($event.detail)" x-show="currentStep === 1">
            <div class="bg-white dark:bg-gray-800 shadow-md border dark:border-gray-800 rounded-md space-y-4 max-w-3xl mx-auto p-4"
                x-show="currentStep === 1">
                {{-- Seleccione tipo de pregunta --}}
                <div x-show="createQuestion">
                    <form class="space-y-4" @submit.prevent="createComponent()">
                        {{-- Paso 2: Nombre y descripción --}}
                        <h2 class="text-xl sm:text-2xl text-gray-900 dark:text-white font-bold px-4 pt-4">
                            2 Paso: Seleccione el tipo de pregunta a agregar
                        </h2>
                        <div class="p-4 text-sm px-3 font-semibold py-1 rounded-lg space-y-2">
                            <div class="flex flex-col gap-2">
                                <div class="w-full max-w-sm mx-auto">
                                    <label for="tipo_pregunta"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Seleccione el tipo de pregunta
                                    </label>
                                    <select id="tipo_pregunta" x-model="typeQuestion" required
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">Seleccione</option>
                                        <option value="opcion_multiple" selected>Opción multiple</option>
                                        <option value="escala_likert">Escala likert</option>
                                        <option value="pregunta_abierta">Pregunta abierta</option>
                                        <option value="escala_clasificacion">Escala clasificacion</option>
                                        <option value="matriz_preguntas">Matriz de preguntas</option>
                                        <option value="separar_pregunta">Agregar Separación</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between sm:justify-center w-full px-4 py-3 sm:gap-4">
                            <button type="button" @click="currentStep--"
                                class=" focus:ring-gray-300  hover:bg-gray-800  bg-gray-700  focus:ring-4 focus:outline-none text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center sm:me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                                </svg>
                                Volver
                            </button>
                            <button type="submit"
                                class=" bg-blue-700  hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center sm:me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Crear Pregunta
                            </button>
                        </div>
                    </form>
                </div>
                {{-- Agregar pregunta --}}
                <template x-if="!createQuestion">
                    <div>
                        <x-survey.create.opcion-multiple />
                        <x-survey.create.escala-clasificacion />
                        <x-survey.create.escala-likert />
                        <x-survey.create.pregunta-abierta />
                        <x-survey.create.matriz-preguntas />
                        <x-survey.create.separador />
                    </div>
                </template>
            </div>

            <template x-for="(rows, index) in questions">
                <div
                    class="bg-white dark:bg-gray-800 shadow-md border dark:border-gray-800 rounded-md space-y-4 max-w-3xl mx-auto p-4">
                    <x-survey.view.opcion-multiple />
                    <x-survey.view.escala-clasificacion />
                    <x-survey.view.escala-likert />
                    <x-survey.view.pregunta-abierta />
                    <x-survey.view.matriz-preguntas />
                    <x-survey.view.separador />
                </div>
            </template>
            <pre x-text="JSON.stringify(questions, null, 2)"></pre>
        </div>
        <div x-show="currentStep === 2">
            <div class="flex w-full px-4 py-3 gap-4 overflow-auto">
                <div class="w-full">
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
