<?php
// Secciones administrables del panel. Cada clave de este arreglo es a la vez
// la clave dentro de datos-admision.json. Para agregar campos, edita aquí
// (y pon el data-doc / data-fecha / data-costo correspondiente en la página).
//
//   tipo 'documentos' -> por cada item: subir PDF o pegar enlace.
//   tipo 'textos'     -> por cada item: un texto corto (fecha, monto, etc.).
return [

    'portada' => [
        'menu'   => 'Inicio · Portada',
        'icono'  => '🏠',
        'titulo' => 'Página de inicio',
        'ayuda'  => 'Edita los textos de la portada. Deja un campo igual si no vas a cambiarlo.',
        'tipo'   => 'textos',
        'grupos' => [
            'Slide 1 del banner' => [
                'hero1_etiqueta' => 'Etiqueta',
                'hero1_titulo'   => 'Título',
                'hero1_texto'    => 'Texto',
            ],
            'Slide 2 del banner' => [
                'hero2_etiqueta' => 'Etiqueta',
                'hero2_titulo'   => 'Título',
                'hero2_texto'    => 'Texto',
            ],
            'Slide 3 del banner' => [
                'hero3_etiqueta' => 'Etiqueta',
                'hero3_titulo'   => 'Título',
                'hero3_texto'    => 'Texto',
            ],
            'Estadísticas' => [
                'stat1_num' => 'N.º 1 · número',   'stat1_lbl' => 'N.º 1 · etiqueta',
                'stat2_num' => 'N.º 2 · número',   'stat2_lbl' => 'N.º 2 · etiqueta',
                'stat3_num' => 'N.º 3 · número',   'stat3_lbl' => 'N.º 3 · etiqueta',
                'stat4_num' => 'N.º 4 · número',   'stat4_lbl' => 'N.º 4 · etiqueta',
            ],
            '¿Por qué UNCP?' => [
                'ben1_titulo' => 'Beneficio 1 · título', 'ben1_texto' => 'Beneficio 1 · texto',
                'ben2_titulo' => 'Beneficio 2 · título', 'ben2_texto' => 'Beneficio 2 · texto',
                'ben3_titulo' => 'Beneficio 3 · título', 'ben3_texto' => 'Beneficio 3 · texto',
                'ben4_titulo' => 'Beneficio 4 · título', 'ben4_texto' => 'Beneficio 4 · texto',
            ],
            'Contacto (pie de página)' => [
                'contacto_direccion' => 'Dirección',
                'contacto_telefono'  => 'Teléfono',
                'contacto_correo'    => 'Correo',
            ],
            'Pie de página (footer)' => [
                'footer_texto'     => 'Texto de presentación',
                'footer_facebook'  => 'Facebook (enlace)',
                'footer_instagram' => 'Instagram (enlace)',
                'footer_youtube'   => 'YouTube (enlace)',
                'footer_tiktok'    => 'TikTok (enlace)',
                'footer_whatsapp'  => 'WhatsApp (número)',
                'footer_copyright' => 'Texto de copyright',
            ],
        ],
    ],

    'documentos' => [
        'menu'   => 'Admisión · Documentos',
        'icono'  => '📄',
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
        'icono'  => '📅',
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
        'icono'  => '💰',
        'titulo' => 'Costos de inscripción de Posgrado',
        'ayuda'  => 'Edita los montos de inscripción (por ejemplo: S/ 211.00).',
        'tipo'   => 'textos',
        'items'  => [
            'maestria'  => 'Inscripción maestría',
            'doctorado' => 'Inscripción doctorado',
        ],
    ],

    'inscripcion_pagina' => [
        'menu'       => 'Inscripción · Página',
        'icono'  => '📝',
        'titulo'     => 'Página de inscripción',
        'ayuda'      => 'Banner, los 4 pasos y los requisitos de inscripcion.html.',
        'tipo'       => 'textos',
        'multilinea' => true,
        'listas'     => ['insc_req_lista'],
        'grupos'     => [
            'Banner' => [
                'insc_titulo' => 'Título',
                'insc_bajada' => 'Subtítulo',
            ],
            'Pasos' => [
                'insc_paso1_tit' => 'Paso 1 · título', 'insc_paso1_txt' => 'Paso 1 · texto',
                'insc_paso2_tit' => 'Paso 2 · título', 'insc_paso2_txt' => 'Paso 2 · texto',
                'insc_paso3_tit' => 'Paso 3 · título', 'insc_paso3_txt' => 'Paso 3 · texto',
                'insc_paso4_tit' => 'Paso 4 · título', 'insc_paso4_txt' => 'Paso 4 · texto',
            ],
            'Requisitos' => [
                'insc_req_intro' => 'Texto de introducción',
                'insc_req_lista' => 'Lista de documentos (uno por línea)',
            ],
        ],
    ],

    'inscripcion_costos' => [
        'menu'   => 'Inscripción · Costos',
        'icono'  => '💳',
        'titulo' => 'Costos de inscripción (pregrado)',
        'ayuda'  => 'Montos y códigos de pago del recuadro en inscripcion.html.',
        'tipo'   => 'textos',
        'grupos' => [
            'Egresado de colegio estatal' => [
                'insc_estatal_monto'  => 'Monto',
                'insc_estatal_codigo' => 'Código de pago',
            ],
            'Egresado de colegio particular' => [
                'insc_particular_monto'  => 'Monto',
                'insc_particular_codigo' => 'Código de pago',
            ],
            'Participante libre' => [
                'insc_libre_monto'  => 'Monto',
                'insc_libre_codigo' => 'Código de pago',
            ],
        ],
    ],

    'posgrado_resultados' => [
        'menu'   => 'Posgrado · Resultados',
        'icono'  => '🏆',
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
