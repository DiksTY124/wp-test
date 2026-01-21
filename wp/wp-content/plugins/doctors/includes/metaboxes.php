<?php
if (!defined('ABSPATH')) exit;

add_action('add_meta_boxes', function () {
    add_meta_box(
        'doctor_meta',
        'Данные врача',
        'render_doctor_meta_box',
        'doctors',
        'normal',
        'default'
    );
});

function render_doctor_meta_box($post) {
    wp_nonce_field('save_doctor_meta', 'doctor_meta_nonce');

    $experience = get_post_meta($post->ID, 'experience_years', true);
    $price = get_post_meta($post->ID, 'price_from', true);
    $rating = get_post_meta($post->ID, 'rating', true);
    ?>

    <p>
        <label>Стаж (лет)</label><br>
        <input type="number" name="experience_years" value="<?= esc_attr($experience) ?>" min="0">
    </p>

    <p>
        <label>Цена от</label><br>
        <input type="number" name="price_from" value="<?= esc_attr($price) ?>" min="0">
    </p>

    <p>
        <label>Рейтинг (0–5)</label><br>
        <input type="number" step="0.1" min="0" max="5" name="rating" value="<?= esc_attr($rating) ?>">
    </p>

        <?php
}

add_action('save_post_doctors', function ($post_id) {

    if (!isset($_POST['doctor_meta_nonce']) ||
        !wp_verify_nonce($_POST['doctor_meta_nonce'], 'save_doctor_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    $fields = [
        'experience_years' => 'absint',
        'price_from' => 'absint',
        'rating' => 'floatval',
    ];

    foreach ($fields as $key => $sanitize) {
        if (isset($_POST[$key])) {
            update_post_meta(
                $post_id,
                $key,
                call_user_func($sanitize, $_POST[$key])
            );
        }
    }
});
