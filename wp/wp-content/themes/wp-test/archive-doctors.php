<?php get_header(); ?>

<main class="doctors-archive">
    <h1>Наши врачи</h1>

    <?php
    // GET используется ТОЛЬКО для сохранения выбранных значений формы
    $selected_specialization = sanitize_text_field($_GET['specialization'] ?? '');
    $selected_city           = sanitize_text_field($_GET['city'] ?? '');
    $selected_sort           = sanitize_text_field($_GET['sort'] ?? '');
    ?>

    <form method="get" class="doctors-filters">

        <select name="specialization">
            <option value="">Все специализации</option>
            <?php
            foreach (get_terms(['taxonomy' => 'specialization', 'hide_empty' => false]) as $term) :
            ?>
                <option value="<?= esc_attr($term->slug); ?>"
                    <?= selected($selected_specialization, $term->slug); ?>>
                    <?= esc_html($term->name); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="city">
            <option value="">Все города</option>
            <?php
            foreach (get_terms(['taxonomy' => 'city', 'hide_empty' => false]) as $term) :
            ?>
                <option value="<?= esc_attr($term->slug); ?>"
                    <?= selected($selected_city, $term->slug); ?>>
                    <?= esc_html($term->name); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="sort">
            <option value="">Сортировка</option>
            <option value="rating" <?= selected($selected_sort, 'rating'); ?>>По рейтингу</option>
            <option value="price" <?= selected($selected_sort, 'price'); ?>>По цене</option>
            <option value="experience" <?= selected($selected_sort, 'experience'); ?>>По стажу</option>
        </select>

        <button type="submit">Применить</button>
    </form>

    <?php if (have_posts()) : ?>
        <div class="doctors-grid">

            <?php while (have_posts()) : the_post(); ?>

                <article <?php post_class('doctor-card'); ?>>
                    <a href="<?php the_permalink(); ?>">

                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium'); ?>
                        <?php endif; ?>

                        <h2><?php the_title(); ?></h2>
                    </a>

                    <div class="doctor-meta">
                        <?php
                        $experience = get_post_meta(get_the_ID(), 'experience_years', true);
                        $price      = get_post_meta(get_the_ID(), 'price_from', true);
                        $rating     = get_post_meta(get_the_ID(), 'rating', true);
                        ?>

                        <?php if ($experience !== '') : ?>
                            <p>Стаж: <?= esc_html($experience); ?> лет</p>
                        <?php endif; ?>

                        <?php if ($price !== '') : ?>
                            <p>Цена от: <?= esc_html($price); ?> ₽</p>
                        <?php endif; ?>

                        <?php if ($rating !== '') : ?>
                            <p>Рейтинг: <?= esc_html($rating); ?>/5</p>
                        <?php endif; ?>
                    </div>
                </article>

            <?php endwhile; ?>

        </div>

        <?php the_posts_pagination(); ?>

    <?php else : ?>
        <p>Врачи не найдены.</p>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
