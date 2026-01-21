<?php
if (!defined('ABSPATH')) exit;

add_action('init', function () {

    // Специализация
    register_taxonomy('specialization', ['doctors'], [
        'labels' => [
            'name' => 'Специализации',
            'singular_name' => 'Специализация',
            'add_new_item' => 'Добавить специализацию',
            'edit_item' => 'Редактировать специализацию',
        ],
        'public' => true,
        'hierarchical' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'specialization'],
    ]);

    // Город
    register_taxonomy('city', ['doctors'], [
        'labels' => [
            'name' => 'Города',
            'singular_name' => 'Город',
            'add_new_item' => 'Добавить город',
            'edit_item' => 'Редактировать город',
        ],
        'public' => true,
        'hierarchical' => false,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'city'],
    ]);
});
