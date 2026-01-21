<?php
if (!defined('ABSPATH')) exit;

add_action('pre_get_posts', function ($query) {

    // 1. Безопасность и область применения
    if (
        is_admin() ||
        !$query->is_main_query() ||
        !is_post_type_archive('doctors')
    ) {
        return;
    }

    // 2. Количество элементов на странице
    $query->set('posts_per_page', 9);

    /*
     * =========================
     * ФИЛЬТРАЦИЯ ПО ТАКСОНОМИЯМ
     * =========================
     */
    $tax_query = [];

    // Специализация
    if (!empty($_GET['specialization'])) {
        $tax_query[] = [
            'taxonomy' => 'specialization',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_GET['specialization']),
        ];
    }

    // Город
    if (!empty($_GET['city'])) {
        $tax_query[] = [
            'taxonomy' => 'city',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_GET['city']),
        ];
    }

    if (!empty($tax_query)) {
        $query->set('tax_query', $tax_query);
    }

    /*
     * =========================
     * СОРТИРОВКА
     * =========================
     */
    if (!empty($_GET['sort'])) {

        $sort = sanitize_text_field($_GET['sort']);

        switch ($sort) {

            case 'rating':
                $query->set('meta_key', 'rating');
                $query->set('orderby', 'meta_value_num');
                $query->set('order', 'DESC');
                break;

            case 'price':
                $query->set('meta_key', 'price_from');
                $query->set('orderby', 'meta_value_num');
                $query->set('order', 'ASC');
                break;

            case 'experience':
                $query->set('meta_key', 'experience_years');
                $query->set('orderby', 'meta_value_num');
                $query->set('order', 'DESC');
                break;
        }
    }
});
