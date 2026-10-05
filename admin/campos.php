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
            'Tarjetas de acceso (portada)' => [
                'acc1_tit' => 'Tarjeta 1 · título', 'acc1_desc' => 'Tarjeta 1 · descripción',
                'acc2_tit' => 'Tarjeta 2 · título', 'acc2_desc' => 'Tarjeta 2 · descripción',
                'acc3_tit' => 'Tarjeta 3 · título', 'acc3_desc' => 'Tarjeta 3 · descripción',
                'acc4_tit' => 'Tarjeta 4 · título', 'acc4_desc' => 'Tarjeta 4 · descripción',
            ],
            'Botones del carrusel (hero)' => [
                's1b1_txt' => 'Slide 1 · botón 1 · texto', 's1b1_link' => 'Slide 1 · botón 1 · enlace',
                's1b2_txt' => 'Slide 1 · botón 2 · texto', 's1b2_link' => 'Slide 1 · botón 2 · enlace',
                's2b1_txt' => 'Slide 2 · botón 1 · texto', 's2b1_link' => 'Slide 2 · botón 1 · enlace',
                's2b2_txt' => 'Slide 2 · botón 2 · texto', 's2b2_link' => 'Slide 2 · botón 2 · enlace',
                's3b1_txt' => 'Slide 3 · botón 1 · texto', 's3b1_link' => 'Slide 3 · botón 1 · enlace',
                's3b2_txt' => 'Slide 3 · botón 2 · texto', 's3b2_link' => 'Slide 3 · botón 2 · enlace',
            ],
            'Títulos de sección (portada)' => [
                'sec_carreras_tit' => 'Programas · título', 'sec_carreras_sub' => 'Programas · subtítulo',
                'sec_accesos_rotulo' => 'Accesos · rótulo', 'sec_accesos_tit' => 'Accesos · título', 'sec_accesos_sub' => 'Accesos · subtítulo',
                'sec_porque_rotulo' => '¿Por qué? · rótulo', 'sec_porque_tit' => '¿Por qué? · título', 'sec_porque_sub' => '¿Por qué? · subtítulo',
                'sec_video_rotulo' => 'Video · rótulo', 'sec_video_tit' => 'Video · título', 'sec_video_sub' => 'Video · subtítulo',
            ],
            'Video institucional' => [
                'video_id' => 'Enlace o ID del video de Google Drive',
            ],
            'Bloque final (¡Tu futuro comienza aquí!)' => [
                'cta_titulo'    => 'Título',
                'cta_texto'     => 'Texto',
                'cta_btn1_txt'  => 'Botón 1 · texto',
                'cta_btn1_link' => 'Botón 1 · enlace',
                'cta_btn2_txt'  => 'Botón 2 · texto',
                'cta_btn2_link' => 'Botón 2 · enlace',
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

    'secciones' => [
        'menu'       => 'Títulos de sección (internas)',
        'icono'      => '🏷️',
        'titulo'     => 'Títulos de sección de las páginas internas',
        'ayuda'      => 'Rótulo, título y subtítulo de cada sección de las páginas internas.',
        'tipo'       => 'textos',
        'multilinea' => true,
        'grupos'     => [
            'Admisión · Descarga la información del proceso' => ['adm_s1_rot' => 'Rótulo', 'adm_s1_tit' => 'Título', 'adm_s1_sub' => 'Subtítulo'],
            'Inscripción · Cinco pasos para inscribirte' => ['ins_s1_rot' => 'Rótulo', 'ins_s1_tit' => 'Título', 'ins_s1_sub' => 'Subtítulo'],
            'Inscripción · Qué necesitas tener listo' => ['ins_s2_rot' => 'Rótulo', 'ins_s2_tit' => 'Título'],
            'Posgrado · Los documentos del proceso' => ['pos_s1_rot' => 'Rótulo', 'pos_s1_tit' => 'Título', 'pos_s1_sub' => 'Subtítulo'],
            'Posgrado · Vacantes, cronograma y perfil del proyecto' => ['pos_s2_rot' => 'Rótulo', 'pos_s2_tit' => 'Título', 'pos_s2_sub' => 'Subtítulo'],
            'Posgrado · Cuánto cuesta inscribirse' => ['pos_s3_rot' => 'Rótulo', 'pos_s3_tit' => 'Título', 'pos_s3_sub' => 'Subtítulo'],
            'Posgrado · Resultados del proceso' => ['pos_s4_rot' => 'Rótulo', 'pos_s4_tit' => 'Título', 'pos_s4_sub' => 'Subtítulo'],
            'Posgrado · Cronograma · Cronograma Posgrado 2026 - II' => ['cro_s1_rot' => 'Rótulo', 'cro_s1_tit' => 'Título', 'cro_s1_sub' => 'Subtítulo'],
            'Posgrado · Costos · Costos de inscripción' => ['cos_s1_rot' => 'Rótulo', 'cos_s1_tit' => 'Título', 'cos_s1_sub' => 'Subtítulo'],
            'Prospecto · Qué encontrarás en el prospecto' => ['pro_s1_rot' => 'Rótulo', 'pro_s1_tit' => 'Título', 'pro_s1_sub' => 'Subtítulo'],
            'Prospecto · El prospecto capítulo por capítulo' => ['pro_s2_rot' => 'Rótulo', 'pro_s2_tit' => 'Título', 'pro_s2_sub' => 'Subtítulo'],
            'Prospecto · Dos formas de conseguir el prospecto' => ['pro_s3_rot' => 'Rótulo', 'pro_s3_tit' => 'Título', 'pro_s3_sub' => 'Subtítulo'],
            'Resultados · Consulta tu resultado' => ['res_s1_rot' => 'Rótulo', 'res_s1_tit' => 'Título', 'res_s1_sub' => 'Subtítulo'],
            'Resultados · Resultados por programa' => ['res_s2_rot' => 'Rótulo', 'res_s2_tit' => 'Título', 'res_s2_sub' => 'Subtítulo'],
            'Resultados · Los pasos después del resultado' => ['res_s3_rot' => 'Rótulo', 'res_s3_tit' => 'Título', 'res_s3_sub' => 'Subtítulo'],
        ],
    ],

    'seo' => [
        'menu'       => 'SEO (título y descripción)',
        'icono'      => '🔎',
        'titulo'     => 'SEO por página',
        'ayuda'      => 'Título de pestaña y descripción (para buscadores) de cada página.',
        'tipo'       => 'textos',
        'multilinea' => true,
        'grupos'     => [
            'Portada' => ['home_title' => 'Título de pestaña', 'home_desc' => 'Descripción (meta)'],
            'Admisión' => ['adm_title' => 'Título de pestaña', 'adm_desc' => 'Descripción (meta)'],
            'Inscripción' => ['ins_title' => 'Título de pestaña', 'ins_desc' => 'Descripción (meta)'],
            'Posgrado' => ['pos_title' => 'Título de pestaña', 'pos_desc' => 'Descripción (meta)'],
            'Posgrado · Cronograma' => ['cro_title' => 'Título de pestaña', 'cro_desc' => 'Descripción (meta)'],
            'Posgrado · Costos' => ['cos_title' => 'Título de pestaña', 'cos_desc' => 'Descripción (meta)'],
            'Prospecto' => ['pro_title' => 'Título de pestaña', 'pro_desc' => 'Descripción (meta)'],
            'Resultados' => ['res_title' => 'Título de pestaña', 'res_desc' => 'Descripción (meta)'],
        ],
    ],
    'banners' => [
        'menu'   => 'Banners de páginas',
        'icono'  => '🖼️',
        'titulo' => 'Banners de las páginas internas',
        'ayuda'  => 'Título, subtítulo e imagen del banner de cada página. (El texto del banner '
                  . 'de Inscripción se edita en «Inscripción · Página».)',
        'tipo'   => 'textos',
        'grupos' => [
            'Pregrado (admisión)'   => ['adm_tit' => 'Título', 'adm_sub' => 'Subtítulo'],
            'Posgrado'              => ['pos_tit' => 'Título', 'pos_sub' => 'Subtítulo'],
            'Posgrado · Cronograma' => ['cro_tit' => 'Título', 'cro_sub' => 'Subtítulo'],
            'Posgrado · Costos'     => ['cos_tit' => 'Título', 'cos_sub' => 'Subtítulo'],
            'Botones · Pregrado'            => ['adm_b1_txt' => 'Botón 1 · texto', 'adm_b1_link' => 'Botón 1 · enlace', 'adm_b2_txt' => 'Botón 2 · texto', 'adm_b2_link' => 'Botón 2 · enlace'],
            'Botones · Inscripción'         => ['ins_b1_txt' => 'Botón 1 · texto', 'ins_b1_link' => 'Botón 1 · enlace', 'ins_b2_txt' => 'Botón 2 · texto', 'ins_b2_link' => 'Botón 2 · enlace'],
            'Botones · Posgrado'            => ['pos_b1_txt' => 'Botón 1 · texto', 'pos_b1_link' => 'Botón 1 · enlace'],
            'Botones · Posgrado Cronograma' => ['cro_b1_txt' => 'Botón 1 · texto', 'cro_b1_link' => 'Botón 1 · enlace', 'cro_b2_txt' => 'Botón 2 · texto', 'cro_b2_link' => 'Botón 2 · enlace'],
            'Botones · Posgrado Costos'     => ['cos_b1_txt' => 'Botón 1 · texto', 'cos_b1_link' => 'Botón 1 · enlace', 'cos_b2_txt' => 'Botón 2 · texto', 'cos_b2_link' => 'Botón 2 · enlace'],
            'Prospecto'             => ['pro_tit' => 'Título', 'pro_sub' => 'Subtítulo'],
            'Resultados'            => ['res_tit' => 'Título', 'res_sub' => 'Subtítulo'],
            'Botones · Prospecto'   => ['pro_b1_txt' => 'Botón 1 · texto', 'pro_b1_link' => 'Botón 1 · enlace', 'pro_b2_txt' => 'Botón 2 · texto', 'pro_b2_link' => 'Botón 2 · enlace'],
            'Botones · Resultados'  => ['res_b1_txt' => 'Botón 1 · texto', 'res_b1_link' => 'Botón 1 · enlace', 'res_b2_txt' => 'Botón 2 · texto', 'res_b2_link' => 'Botón 2 · enlace'],
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
            'prospecto2'          => 'Prospecto de admisión 2',
        ],
    ],

    'admision_textos' => [
        'menu'       => 'Admisión · Textos tarjetas',
        'icono'      => '🗂️',
        'titulo'     => 'Textos de las tarjetas de documentos',
        'ayuda'      => 'Título y descripción de cada tarjeta de admision.html (el enlace/PDF se '
                      . 'edita en «Admisión · Documentos»).',
        'tipo'       => 'textos',
        'multilinea' => true,
        'grupos'     => [
            'Cronograma de inscripciones'      => ['cronograma_tit' => 'Título', 'cronograma_desc' => 'Descripción'],
            'Reglamento'                       => ['reglamento_tit' => 'Título', 'reglamento_desc' => 'Descripción'],
            'Vacantes'                         => ['vacantes_tit' => 'Título', 'vacantes_desc' => 'Descripción'],
            'Temario'                          => ['temario_tit' => 'Título', 'temario_desc' => 'Descripción'],
            'Ponderaciones'                    => ['ponderaciones_tit' => 'Título', 'ponderaciones_desc' => 'Descripción'],
            'Costos'                           => ['costos_tit' => 'Título', 'costos_desc' => 'Descripción'],
            'Guía del postulante'              => ['guia-postulante_tit' => 'Título', 'guia-postulante_desc' => 'Descripción'],
            'Guía de inscripción en línea'     => ['guia-inscripcion_tit' => 'Título', 'guia-inscripcion_desc' => 'Descripción'],
            'Baremos · Deportistas calificados'=> ['baremos-deportistas_tit' => 'Título', 'baremos-deportistas_desc' => 'Descripción'],
            'Baremos · Educación Física'       => ['baremos-efisica_tit' => 'Título', 'baremos-efisica_desc' => 'Descripción'],
            'Modelo de voucher de pago'        => ['voucher_tit' => 'Título', 'voucher_desc' => 'Descripción'],
            'Prospecto de admisión'            => ['prospecto_tit' => 'Título', 'prospecto_desc' => 'Descripción'],
            'Prospecto de admisión 2'          => ['prospecto2_tit' => 'Título', 'prospecto2_desc' => 'Descripción'],
        ],
    ],

    'carreras_botones' => [
        'menu'   => 'Carreras · Botones',
        'icono'  => '🔘',
        'titulo' => 'Botones de las páginas de carrera',
        'ayuda'  => 'Aplican a las 39 carreras a la vez. Para enlaces internos usa ../pagina.html '
                  . '(ej. ../inscripcion.html). Para enlaces externos, la URL completa (https://…).',
        'tipo'   => 'textos',
        'grupos' => [
            'Cómo postular (banner)'        => ['postular_txt' => 'Texto', 'postular_link' => 'Enlace'],
            'Solicitar información (banner)' => ['info_txt' => 'Texto', 'info_link' => 'Enlace'],
            'Inscríbete en línea (ficha)'    => ['inscribir_txt' => 'Texto', 'inscribir_link' => 'Enlace'],
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
                'insc_paso5_tit' => 'Paso 5 · título', 'insc_paso5_link' => 'Paso 5 · enlace de descarga',
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

    'inscripcion_modalidades' => [
        'menu'   => 'Inscripción · Modalidades',
        'icono'  => '💵',
        'titulo' => 'Costos por modalidad (pregrado)',
        'ayuda'  => 'El monto de cada modalidad (ej.: S/ 310.00 (Caja UNCP) o Sin costo). '
                  . 'Aparecen en inscripcion.html.',
        'tipo'   => 'textos',
        'items'  => [
            'mod_primeros'           => 'Primeros puestos',
            'mod_comuneros'          => 'Hijos de comuneros región Junín',
            'mod_violencia'          => 'Afectados de la violencia social',
            'mod_discapacidad'       => 'Personas con discapacidad',
            'mod_tras_interno'       => 'Traslado interno',
            'mod_tras_nacional'      => 'Traslado externo nacional',
            'mod_tras_particular'    => 'Traslado externo particular',
            'mod_tras_internacional' => 'Traslado externo internacional',
            'mod_segunda'            => 'Segunda carrera',
            'mod_terrorismo'         => 'Víctimas del terrorismo',
            'mod_dc'                 => 'Deportistas calificados (DC)',
            'mod_nativas'            => 'Estudiantes comunidades nativas',
            'mod_simulacro'          => 'Simulacro examen admisión',
            'mod_medico'             => 'Examen médico',
        ],
    ],

    'posgrado_documentos' => [
        'menu'   => 'Posgrado · Documentos',
        'icono'  => '📚',
        'titulo' => 'Documentos de Posgrado',
        'ayuda'  => 'Sube el PDF o pega el enlace de cada documento de posgrado.html.',
        'tipo'   => 'documentos',
        'items'  => [
            'pos-prospecto'  => 'Prospecto posgrado',
            'pos-doctorados' => 'Doctorados',
            'pos-maestrias'  => 'Maestrías',
            'pos-vacantes'   => 'Vacantes',
            'pos-perfil'     => 'Perfil del proyecto de investigación',
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
