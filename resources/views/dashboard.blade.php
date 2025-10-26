@push('scripts')
    <script>
        const createSurvey = () => {
            return {
                currentStep: 0,
                steps: 3,
                form: {
                    nombre: '',
                    descripcion: '',
                    register: {
                        fields: []
                    },
                    surveys: []
                },
                formValidate() {
                    if (this.form.nombre.trim() === '') {
                        alert('El nombre de la encuesta es obligatorio.');
                        return;
                    }
                    this.currentStep++;
                },
                addItem(detail) {
                    if (detail.type === 'register') {
                        this.form.register = detail.register;
                    } else if (detail.type === 'surveys') {
                        this.form.surveys = detail.surveys;
                    }
                    ToastNotification('Campos Agregado', 'Encuesta', 'info');
                },
                buttonDisabled: false,
                store() {
                    if (this.form.surveys.length == 0) {
                        ToastNotification(
                            'La encuesta no puede tener preguntas vacías, asegurese de agregar una pregunta.',
                            'Encuesta', 'warning');
                        return;
                    }

                    this.buttonDisabled = true;
                    const route = `{{ route('encuesta.store') }}`;
                    const request = {
                        ...this.form,
                    }

                    const success = (e) => {
                        const message = (e?.data?.message) ? e?.data?.message : 'Encuesta creada correctamente.';
                        ToastNotification(message, 'Encuesta', 'success');
                        this.buttonDisabled = false;
                    }

                    const failed = (e) => {
                        const message = (e?.response?.data?.message) ? e?.response?.data?.message :
                            'Error al crear encuesta, revise los datos ingresados o recarge la página.';
                        console.error(message);
                        ToastNotification(message, 'Encuesta', 'warning');
                        this.buttonDisabled = false;
                    }

                    axios.post(route, request).then(success).catch(failed);
                }
            };
        };
        const componentRegister = () => {
            return {
                fields: {
                    type: '',
                    label: '',
                    name: '',
                    required: false,
                },
                // campos creados
                fields: [],
                // objeto con los valores actuales del formulario
                form: {},

                // datos temporales para agregar un campo
                newField: {
                    id: null,
                    type: 'text',
                    label: '',
                    name: '',
                    required: false,
                    options: []
                },

                // helpers para opciones
                optionText: '',
                editOptionText: '',

                // --- Añadir opción al newField ---
                addOptionToNew() {
                    if (!this.optionText.trim()) return;
                    this.newField.options.push(this.optionText.trim());
                    this.optionText = '';
                },

                removeNewOption(i) {
                    this.newField.options.splice(i, 1);
                },

                editNewOption(i) {
                    this.optionText = this.newField.options[i];
                    this.newField.options.splice(i, 1);
                },

                // reset del formulario para crear nuevo campo
                resetNewField() {
                    this.newField = {
                        id: null,
                        type: 'text',
                        label: '',
                        name: '',
                        required: false,
                        options: []
                    };
                    this.optionText = '';
                },

                // Añadir campo desde newField
                addFieldFromNew() {
                    // validaciones básicas
                    if (!this.newField.label.trim()) {
                        alert('La etiqueta (label) es requerida.');
                        return;
                    }
                    if (!this.newField.name.trim()) {
                        alert('El name/clave es requerido.');
                        return;
                    }
                    // clonar y asignar id único
                    const f = JSON.parse(JSON.stringify(this.newField));
                    f.id = Date.now() + Math.floor(Math.random() * 999);
                    // si no hay opciones para radio/select, pedir al menos una
                    if ((f.type === 'radio' || f.type === 'select') && (!f.options || f.options.length === 0)) {
                        alert('Agrega al menos una opción para radio o select.');
                        return;
                    }
                    this.fields.push(f);
                    // inicializar valor en form
                    if (!(f.name in this.form)) {
                        this.$set ? this.$set(this.form, f.name, '') : (this.form[f.name] = '');
                    }
                    // reset newField
                    this.resetNewField();
                },

                // remover campo
                removeField(idx) {
                    const f = this.fields[idx];
                    if (confirm(`Eliminar campo "${f.label}"?`)) {
                        // quitar valor del form
                        if (f.name in this.form) delete this.form[f.name];
                        this.fields.splice(idx, 1);
                    }
                },

                finish(dispatch) {
                    dispatch('finishsurvey', {
                        type: 'register',
                        register: {
                            fields: this.fields,
                            form: this.form
                        }
                    });
                }
            }
        }
        const componentSurveys = () => {
            return {
                questions: [],
                typeQuestion: '',
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
                    ToastNotification('Pregunta agregada', 'Encuesta', 'success');
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
                },

                finish(dispatch) {
                    dispatch('finishsurvey', {
                        type: 'surveys',
                        surveys: this.questions
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
    <div class="p-8" x-data="createSurvey()" @finishsurvey="addItem($event.detail)">
        <div class="bg-white dark:bg-gray-800 shadow-md border dark:border-gray-800 rounded-md space-y-4 max-w-3xl mx-auto p-4"
            x-show="currentStep=== 0">
            {{-- Paso 1: Nombre y descripción --}}
            <h2 class="text-xl sm:text-2xl text-gray-900 dark:text-white font-bold px-4 pt-4">
                1 Paso: crear nombre y descripción de la encuesta
            </h2>
            <form @submit.prevent="formValidate()" class="space-y-4">
                <div class="p-4 text-sm px-3 font-semibold py-1 rounded-lg space-y-2">
                    <div class="flex flex-col gap-2">
                        <label for="nombre"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre:</label>
                        <input type="text" x-model="form.nombre" required id="nombre" name="nombre"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="descripcion"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción:</label>
                        <textarea x-model="form.descripcion" id="descripcion" name="descripcion"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            rows="3"></textarea>
                    </div>
                </div>
                {{-- Opciones  --}}
                <div class="flex justify-end w-full px-4 py-3 gap-4">
                    <button type="submit" id="siguiente"
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

        <div x-data="componentRegister()" @add-input="addItem($event.detail)" x-show="currentStep === 1">
            <div
                class="bg-white dark:bg-gray-800 shadow-md border dark:border-gray-800 rounded-md space-y-4 max-w-3xl mx-auto p-4">
                {{-- Paso 1: Nombre y descripción --}}
                <h2 class="text-xl sm:text-2xl text-gray-900 dark:text-white font-bold px-4 pt-4">
                    2 Paso: campos de registro de la encuesta
                </h2>
                <div class="space-y-4">
                    <!-- --- Panel para agregar nuevo campo --- -->
                    <div class="p-4 border rounded-lg bg-white shadow-sm">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium">Tipo</label>
                                <select x-model="newField.type" class="mt-1 block w-full rounded border p-2"
                                    id="section-form-tipo" name="section-form-tipo">
                                    <option value="text">Texto</option>
                                    <option value="date">Fecha</option>
                                    <option value="number">Número</option>
                                    <option value="radio">Radio</option>
                                    <option value="select">Select</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium">Label</label>
                                <input x-model="newField.label" type="text" id="section-form-label"
                                    name="section-form-label" class="mt-1 block w-full rounded border p-2"
                                    placeholder="Ej: Nombre">
                            </div>

                            <div>
                                <label class="block text-sm font-medium">Name (clave)</label>
                                <input x-model="newField.name" type="text" id="section-form-name"
                                    name="section-form-name" class="mt-1 block w-full rounded border p-2"
                                    placeholder="clave_unica">
                            </div>

                            <div>
                                <label class="block text-sm font-medium">Required</label>
                                <div class="mt-1">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" x-model="newField.required" class="mr-2">
                                        Sí
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Opciones dinámicas (aparece para radio/select) -->
                    <template x-if="newField.type === 'radio' || newField.type === 'select'">
                        <div class="mt-4">
                            <label class="block text-sm font-medium">Opciones</label>

                            <div class="flex gap-2 mt-2">
                                <input x-model="optionText" type="text" class="flex-1 rounded border p-2"
                                    placeholder="Texto de opción (valor será el mismo)">
                                <button type="button" @click="addOptionToNew()"
                                    class="px-3 py-2 rounded bg-blue-600 text-white">Agregar</button>
                            </div>

                            <ul class="mt-3 space-y-2">
                                <template x-for="(opt, i) in newField.options" :key="i">
                                    <li class="flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-3">
                                            <span class="px-3 py-1 rounded bg-gray-100 text-sm" x-text="opt"></span>
                                            <button type="button" @click="editNewOption(i)"
                                                class="text-sm text-yellow-600">Editar</button>
                                            <button type="button" @click="removeNewOption(i)"
                                                class="text-sm text-red-600">Eliminar</button>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </template>
                    {{-- Opciones  --}}
                    <div class="flex justify-between sm:justify-center w-full px-4 py-3 sm:gap-4">
                        <button type="button" @click="addFieldFromNew()" id="section-form-btn-agregar"
                            class=" bg-blue-700  hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center sm:me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            Agregar Campo
                        </button>
                        <button type="button" @click="currentStep--"
                            class=" focus:ring-gray-300  hover:bg-gray-800  bg-gray-700  focus:ring-4 focus:outline-none text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center sm:me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                            </svg>
                            Volver
                        </button>
                        <button type="button" @click="finish($dispatch);currentStep++;" id="section-form-btn-crear"
                            class=" bg-blue-700  hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center sm:me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            Crear Preguntas
                        </button>
                    </div>
                </div>
            </div>
            <!-- --- Vista previa / edición de los campos creados --- -->
            <div
                class="bg-white mt-4 dark:bg-gray-800 shadow-md border dark:border-gray-800 rounded-md space-y-4 max-w-3xl mx-auto p-4">
                <h3 class="font-medium mb-3">Campos añadidos</h3>
                <template x-if="fields.length === 0">
                    <p class="text-sm text-gray-500">Aún no hay campos.</p>
                </template>

                <div class="space-y-4">
                    <template x-for="(f, idx) in fields" :key="f.id">
                        <div
                            class="p-3 border rounded flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            <div class="flex-1">
                                <div class="flex items-baseline gap-3">
                                    <strong x-text="f.label"></strong>
                                    <span class="text-xs text-gray-500">· <span x-text="f.type"></span></span>
                                    <span class="text-xs text-gray-500" x-show="f.required">· requerido</span>
                                </div>

                                <!-- Render según tipo -->
                                <div class="mt-2">
                                    <!-- text / number -->
                                    <template x-if="f.type === 'text' || f.type === 'number' || f.type === 'date'">
                                        <input :type="f.type" :name="f.name" x-model="form[f.name]"
                                            class="w-full md:w-2/3 rounded border p-2" :placeholder="f.label">
                                    </template>

                                    <!-- radio -->
                                    <template x-if="f.type === 'radio'">
                                        <div class="flex flex-wrap gap-3">
                                            <template x-for="(opt, i) in f.options" :key="i">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" :name="f.name" :value="opt"
                                                        x-model="form[f.name]">
                                                    <span x-text="opt"></span>
                                                </label>
                                            </template>
                                        </div>
                                    </template>

                                    <!-- select -->
                                    <template x-if="f.type === 'select'">
                                        <select :name="f.name" x-model="form[f.name]"
                                            class="rounded border p-2 w-full md:w-2/3">
                                            <option value="">— Seleccionar —</option>
                                            <template x-for="(opt, i) in f.options" :key="i">
                                                <option :value="opt" x-text="opt"></option>
                                            </template>
                                        </select>
                                    </template>
                                </div>
                            </div>

                            <!-- acciones: editar opciones / eliminar campo -->
                            <div class="flex flex-col gap-2">
                                <button type="button" @click="removeField(idx)"
                                    class="px-3 py-1 bg-red-600 text-white rounded">Eliminar</button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <div x-data="componentSurveys()" @add-question="addItem($event.detail)" x-show="currentStep === 2">
            <div
                class="bg-white dark:bg-gray-800 shadow-md border dark:border-gray-800 rounded-md space-y-4 max-w-3xl mx-auto p-4">
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
                                    <select x-model="typeQuestion" required id="tipo_pregunta" name="tipo_pregunta"
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
                            <button type="submit" id="section-survery-btn"
                                class=" bg-blue-700  hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center sm:me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Crear Pregunta
                            </button>
                            <button type="button" @click="finish($dispatch);currentStep++" id="section-survery-fin"
                                class=" bg-blue-700  hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center sm:me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Completar Encuesta
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

            <!-- --- Vista previa --- -->
            <template x-for="(rows, index) in questions">
                <div
                    class="mt-4 bg-white dark:bg-gray-800 shadow-md border dark:border-gray-800 rounded-md space-y-4 max-w-3xl mx-auto p-4">
                    <x-survey.view.opcion-multiple />
                    <x-survey.view.escala-clasificacion />
                    <x-survey.view.escala-likert />
                    <x-survey.view.pregunta-abierta />
                    <x-survey.view.matriz-preguntas />
                    <x-survey.view.separador />
                </div>
            </template>
        </div>
        <div x-show="currentStep === 3">
            {{-- Opciones  --}}
            <div class="flex justify-between sm:justify-center w-full px-4 py-3 sm:gap-4">
                <button type="button" @click="currentStep--"
                    class=" focus:ring-gray-300  hover:bg-gray-800  bg-gray-700  focus:ring-4 focus:outline-none text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center sm:me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                    </svg>
                    Volver
                </button>
                <button type="button" @click="store();"
                    class=" bg-blue-700  hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center sm:me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 48 48" stroke-width="3">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M36.756 4.347a5.56 5.56 0 0 0-3.234-1.172A242 242 0 0 0 24 3c-7.364 0-12.515.277-15.743.539c-2.555.208-4.51 2.163-4.718 4.718C3.277 11.485 3 16.636 3 24s.277 12.515.539 15.743c.208 2.555 2.163 4.51 4.718 4.718C11.485 44.723 16.636 45 24 45s12.515-.277 15.743-.539c2.555-.208 4.51-2.163 4.718-4.718C44.723 36.515 45 31.364 45 24c0-3.729-.071-6.89-.175-9.522a5.56 5.56 0 0 0-1.173-3.234c-.86-1.09-1.988-2.428-3.229-3.668c-1.24-1.24-2.578-2.368-3.667-3.229" />
                            <path
                                d="M31.293 3.1c.034.705.056 1.544.056 2.526a52 52 0 0 1-.064 2.687c-.088 1.694-1.412 2.938-3.107 3.01c-1.063.044-2.446.078-4.179.078s-3.115-.034-4.178-.079c-1.695-.07-3.019-1.315-3.107-3.009a52 52 0 0 1-.065-2.687c0-.982.023-1.821.057-2.526m19.656 41.59c.126-2.013.237-4.851.237-8.615c0-4.47-.156-7.635-.31-9.662c-.128-1.704-1.425-3.013-3.128-3.15c-1.95-.156-4.953-.313-9.162-.313s-7.212.157-9.161.314c-1.704.136-3 1.445-3.129 3.15c-.153 2.026-.31 5.191-.31 9.661c0 3.764.111 6.602.238 8.615M19 31h10m-10 6h6" />
                        </g>
                    </svg>
                    Guardar
                </button>
            </div>
            <div
                class="bg-white mt-4 dark:bg-gray-800 shadow-md border dark:border-gray-800 rounded-md space-y-4 max-w-3xl mx-auto p-4">
                <div class="p-4 text-sm px-3 font-semibold py-1 rounded-lg space-y-2">
                    {{-- Paso 1: Nombre y descripción --}}
                    <div class="flex flex-col gap-2">
                        <h2 class="text-xl sm:text-2xl text-gray-900 dark:text-white font-bold px-4 pt-4"
                            x-text="form.nombre">
                        </h2>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h2 class="text-base sm:text-xl text-gray-900 dark:text-white font-bold px-4 pt-4"
                            x-text="form.descripcion">
                        </h2>
                    </div>
                </div>
            </div>
            <!-- --- Vista previa / edición de los campos creados --- -->
            <div
                class="bg-white mt-4 dark:bg-gray-800 shadow-md border dark:border-gray-800 rounded-md space-y-4 max-w-3xl mx-auto p-4">
                <h3 class="font-medium mb-3">Campos</h3>
                <template x-if="form.register.fields.length === 0">
                    <p class="text-sm text-gray-500">Aún no hay campos.</p>
                </template>

                <div class="space-y-4">
                    <template x-for="(f, idx) in form.register.fields" :key="f.id">
                        <div
                            class="p-3 border rounded flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            <div class="flex-1">
                                <div class="flex items-baseline gap-3">
                                    <strong x-text="f.label"></strong>
                                    <span class="text-xs text-gray-500">· <span x-text="f.type"></span></span>
                                    <span class="text-xs text-gray-500" x-show="f.required">· requerido</span>
                                </div>

                                <!-- Render según tipo -->
                                <div class="mt-2">
                                    <!-- text / number -->
                                    <template x-if="f.type === 'text' || f.type === 'number' || f.type === 'date'">
                                        <input :type="f.type" :name="f.name"
                                            x-model="form.register.form[f.name]"
                                            class="w-full md:w-2/3 rounded border p-2" :placeholder="f.label">
                                    </template>

                                    <!-- radio -->
                                    <template x-if="f.type === 'radio'">
                                        <div class="flex flex-wrap gap-3">
                                            <template x-for="(opt, i) in f.options" :key="i">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" :name="f.name"
                                                        :value="opt" x-model="form.register.form[f.name]">
                                                    <span x-text="opt"></span>
                                                </label>
                                            </template>
                                        </div>
                                    </template>

                                    <!-- select -->
                                    <template x-if="f.type === 'select'">
                                        <select :name="f.name" x-model="form.register.form[f.name]"
                                            class="rounded border p-2 w-full md:w-2/3">
                                            <option value="">— Seleccionar —</option>
                                            <template x-for="(opt, i) in f.options" :key="i">
                                                <option :value="opt" x-text="opt"></option>
                                            </template>
                                        </select>
                                    </template>
                                </div>
                            </div>

                            <!-- acciones: editar opciones / eliminar campo -->
                            <div class="flex flex-col gap-2">
                                <button type="button" @click="removeField(idx)"
                                    class="px-3 py-1 bg-red-600 text-white rounded">Eliminar</button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <!-- --- Vista previa --- -->
            <template x-for="(rows, index) in form.surveys">
                <div
                    class="mt-4 bg-white dark:bg-gray-800 shadow-md border dark:border-gray-800 rounded-md space-y-4 max-w-3xl mx-auto p-4">
                    <x-survey.check.opcion-multiple />
                    <x-survey.check.escala-clasificacion />
                    <x-survey.check.escala-likert />
                    <x-survey.check.pregunta-abierta />
                    <x-survey.check.matriz-preguntas />
                    <x-survey.check.separador />
                </div>
            </template>
        </div>
    </div>

</x-app-layout>
