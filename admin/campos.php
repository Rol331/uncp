<?php
// Definición de los campos administrables. Una sola lista que usan el
// formulario (index.php) y el guardado (guardar.php). Para agregar o quitar
// un documento, edita solo este arreglo (y el data-doc en la página).
return [
    'documentos' => [
        'titulo' => 'Documentos del proceso de admisión',
        'ayuda'  => 'Para cada documento puedes subir un PDF nuevo o pegar un enlace '
                  . '(por ejemplo de Google Drive). Si subes un PDF, se usa ese.',
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
];
