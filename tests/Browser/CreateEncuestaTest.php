<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateEncuestaTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testCanCreateNewEncuesta(): void
    {
        // 1. Arrange: Define test data. 
        // We use time() to ensure the survey title is unique for each test run.
        $surveyTitle = 'ENCUESTA DE CALIDAD DE SERVICIO ' . time();
        $surveyDescription = 'Recolección de feedback sobre la experiencia del usuario.';

        $this->browse(function (Browser $browser) use ($surveyTitle, $surveyDescription) {
            // --- LOGIN PROCESS ---
            $browser->visit('/login');
            $browser->pause(1000); // Wait for redirection
            // Assuming this user exists or is created in your setup
            $browser->type('email', 'test@example.com');
            $browser->pause(1000);
            $browser->type('password', '123456789');
            $browser->pause(1000);
            $browser->press('INICIAR SESIÓN');
            $browser->assertPathIs('/dashboard');
            $browser->pause(1000);

            // 3. Crear titulo
            $browser->type('nombre', $surveyTitle);
            $browser->pause(1500);
            $browser->type('descripcion', $surveyDescription);
            $browser->pause(1000);
            $browser->click('#siguiente');
            $browser->pause(1500);

            // 4. Crear registro
            // -- Apellidos
            $browser->select('section-form-tipo', 'text');
            $browser->pause(1500);
            $browser->type('section-form-label', 'Apellidos');
            $browser->pause(1000);
            $browser->type('section-form-name', 'apellidos');
            $browser->pause(1000);
            $browser->click('#section-form-btn-agregar');
            $browser->pause(1500);
            // -- Nombres
            $browser->select('section-form-tipo', 'text');
            $browser->pause(1500);
            $browser->type('section-form-label', 'Nombres');
            $browser->pause(1000);
            $browser->type('section-form-name', 'nombre');
            $browser->pause(1000);
            $browser->click('#section-form-btn-agregar');
            $browser->pause(1500);
            // -- Fecha de nacimiento
            $browser->select('section-form-tipo', 'date');
            $browser->pause(1500);
            $browser->type('section-form-label', 'Fecha de nacimiento');
            $browser->pause(1000);
            $browser->type('section-form-name', 'fecha_nacimiento');
            $browser->pause(1000);
            $browser->click('#section-form-btn-agregar');
            $browser->pause(1500);

            $browser->click('#section-form-btn-crear');
            $browser->pause(1500);

            // -- AGREGAR PREGUNTAS
            $browser->select('tipo_pregunta', 'opcion_multiple');
            $browser->pause(1500);
            $browser->click('#section-survery-btn');
            $browser->pause(1500);
            $browser->click('#section-question-agg');
            $browser->pause(1500);


            $browser->select('tipo_pregunta', 'escala_likert');
            $browser->pause(1500);
            $browser->click('#section-survery-btn');
            $browser->pause(1500);
            $browser->click('#section-question-agg');
            $browser->pause(1500);

            $browser->select('tipo_pregunta', 'pregunta_abierta');
            $browser->pause(1500);
            $browser->click('#section-survery-btn');
            $browser->pause(1500);
            $browser->click('#section-question-agg');
            $browser->pause(1500);

            $browser->select('tipo_pregunta', 'escala_clasificacion');
            $browser->pause(1500);
            $browser->click('#section-survery-btn');
            $browser->pause(1500);
            $browser->click('#section-question-agg');
            $browser->pause(1500);

            $browser->select('tipo_pregunta', 'matriz_preguntas');
            $browser->pause(1500);
            $browser->click('#section-survery-btn');
            $browser->pause(1500);
            $browser->click('#section-question-agg');
            $browser->pause(1500);

            $browser->select('tipo_pregunta', 'separar_pregunta');
            $browser->pause(1500);
            $browser->click('#section-survery-btn');
            $browser->pause(1500);
            $browser->click('#section-question-agg');
            $browser->pause(1500);

            $browser->click('#section-survery-fin');


            $browser->pause(10000);
        });
    }
}
