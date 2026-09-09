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
