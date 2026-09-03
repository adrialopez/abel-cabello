<?php
/**
 * ACF field groups for the Galería, Agenda and Testimonios CPTs.
 */

acf_add_local_field_group( [
    'key'      => 'group_ac_galeria',
    'title'    => 'Detalles de la galería',
    'fields'   => [
        [
            'key'     => 'field_ac_gal_tipo',
            'label'   => 'Tipo',
            'name'    => 'tipo',
            'type'    => 'select',
            'choices' => [ 'foto' => 'Foto', 'video' => 'Vídeo' ],
            'default_value' => 'foto',
        ],
        [
            'key'   => 'field_ac_gal_imagen',
            'label' => 'Imagen (o póster del vídeo)',
            'name'  => 'imagen',
            'type'  => 'image',
            'return_format' => 'url',
        ],
        [
            'key'               => 'field_ac_gal_video',
            'label'             => 'Archivo de vídeo',
            'name'              => 'video_archivo',
            'type'              => 'file',
            'return_format'     => 'url',
            'conditional_logic' => [ [ [ 'field' => 'field_ac_gal_tipo', 'operator' => '==', 'value' => 'video' ] ] ],
        ],
        [
            'key'   => 'field_ac_gal_leyenda',
            'label' => 'Leyenda',
            'name'  => 'leyenda',
            'type'  => 'text',
        ],
    ],
    'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'ac_galeria' ] ] ],
] );

acf_add_local_field_group( [
    'key'      => 'group_ac_evento',
    'title'    => 'Detalles del evento',
    'fields'   => [
        [
            'key'          => 'field_ac_evt_fecha',
            'label'        => 'Fecha',
            'name'         => 'fecha',
            'type'         => 'date_picker',
            'display_format'   => 'd/m/Y',
            'return_format'    => 'd/m/Y',
        ],
        [
            'key'   => 'field_ac_evt_ubicacion',
            'label' => 'Ubicación',
            'name'  => 'ubicacion',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_ac_evt_tipo',
            'label' => 'Tipo de evento',
            'name'  => 'tipo_evento',
            'type'  => 'text',
        ],
        [
            'key'     => 'field_ac_evt_estado',
            'label'   => 'Estado',
            'name'    => 'estado',
            'type'    => 'select',
            'choices' => [ 'confirmado' => 'Confirmado', 'disponible' => 'Disponible' ],
            'default_value' => 'confirmado',
        ],
        [
            'key'   => 'field_ac_evt_enlace',
            'label' => 'Enlace (opcional)',
            'name'  => 'enlace',
            'type'  => 'url',
        ],
    ],
    'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'ac_evento' ] ] ],
] );

acf_add_local_field_group( [
    'key'      => 'group_ac_testimonio',
    'title'    => 'Detalles del testimonio',
    'fields'   => [
        [
            'key'   => 'field_ac_test_texto',
            'label' => 'Texto',
            'name'  => 'texto',
            'type'  => 'textarea',
        ],
        [
            'key'   => 'field_ac_test_autor',
            'label' => 'Autor',
            'name'  => 'autor',
            'type'  => 'text',
            'default_value' => 'Cliente verificado',
        ],
        [
            'key'   => 'field_ac_test_evento',
            'label' => 'Tipo de evento',
            'name'  => 'evento',
            'type'  => 'text',
        ],
        [
            'key'           => 'field_ac_test_valoracion',
            'label'         => 'Valoración (1-5)',
            'name'          => 'valoracion',
            'type'          => 'number',
            'default_value' => 5,
            'min'           => 1,
            'max'           => 5,
        ],
    ],
    'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'ac_testimonio' ] ] ],
] );
