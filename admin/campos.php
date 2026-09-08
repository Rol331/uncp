<?php
// Secciones administrables del panel. Cada clave de este arreglo es a la vez
// la clave dentro de datos-admision.json. Para agregar campos, edita aquí
// (y pon el data-doc / data-fecha / data-costo correspondiente en la página).
//
//   tipo 'documentos' -> por cada item: subir PDF o pegar enlace.
//   tipo 'textos'     -> por cada item: un texto corto (fecha, monto, etc.).
return [

    'documentos' => [
        'menu'   => 'Admisión · Documentos',
        'titulo' => 'Documentos del proceso de admisión',
        'ayuda'  => 'Para cada documento puedes subir un PDF nuevo o pegar un enlace '
                  . '(por ejemplo de Google Drive). Si subes un PDF, se usa ese.',
        'tipo'   => 'documentos',
        'items'  => [
            'cronograma'          => 'Cronograma de inscripciones',
            'reglamento'          => 'Reglamento',
            'vacantes'            => 'Vacantes',
            'temario'             => 'Temario',
            'ponderaciones'       => 'Ponderaciones',
            'costos'              => 'Costos',
            'guia-postulante'     => 'Guía del postulante',
            'guia-inscripcion'    => 'Guía de inscripción en línea',
            'baremos-deportistas' => 'Baremos · Deportistas calificados',
            'baremos-efisica'     => 'Baremos · Educación Física',
            'voucher'             => 'Modelo de voucher de pago',
            'prospecto'           => 'Prospecto de admisión',
        ],
    ],

    'posgrado_cronograma' => [
        'menu'   => 'Posgrado · Cronograma',
        'titulo' => 'Cronograma de Posgrado 2026-II',
        'ayuda'  => 'Escribe solo la fecha de cada etapa. El resto del texto '
                  . '(Virtual, Hora, Lugar) se queda fijo en la página.',
        'tipo'   => 'textos',
        'items'  => [
            'inscripciones' => 'Inscripciones',
            'evaluacion'    => 'Evaluación',
            'resultados'    => 'Publicación de resultados',
            'constancias'   => 'Entrega de constancias',
        ],
    ],

    'posgrado_costos' => [
        'menu'   => 'Posgrado · Costos',
        'titulo' => 'Costos de inscripción de Posgrado',
        'ayuda'  => 'Edita los montos de inscripción (por ejemplo: S/ 211.00).',
        'tipo'   => 'textos',
        'items'  => [
            'maestria'  => 'Inscripción maestría',
            'doctorado' => 'Inscripción doctorado',
        ],
    ],

    'posgrado_resultados' => [
        'menu'   => 'Posgrado · Resultados',
        'titulo' => 'Resultados de Posgrado',
        'ayuda'  => 'Sube el PDF con la relación de ingresantes, o pega el enlace. '
                  . 'Las dos tarjetas aparecen en la página de Posgrado.',
        'tipo'   => 'documentos',
        'items'  => [
            'res-doctorado' => 'Resultados · Doctorados',
            'res-maestria'  => 'Resultados · Maestrías',
        ],
    ],

];
