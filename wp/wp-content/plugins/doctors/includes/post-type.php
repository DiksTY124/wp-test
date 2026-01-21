<?php
if (!defined('ABSPATH')) exit;

add_action('init', function () {

    $labels = [
        'name'               => 'Врачи',
        'singular_name'      => 'Врач',
        'add_new'            => 'Добавить врача',
        'add_new_item'       => 'Добавить нового врача',
        'edit_item'          => 'Редактировать врача',
        'new_item'           => 'Новый врач',
        'view_item'          => 'Посмотреть врача',
        'search_items'       => 'Найти врача',
        'not_found'          => 'Врачи не найдены',
        'menu_name'          => 'Врачи',
    ];

    register_post_type('doctors', [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'doctors'],
        'menu_icon'          => 'dashicons-businessperson',

        // Поддержка стандартных полей
        'supports'           => [
            'title',
            'editor',
            'thumbnail',
            'excerpt',
        ],


    ]);
});
