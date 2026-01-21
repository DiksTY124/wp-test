<?php
get_header();

if (have_posts()) :
    while (have_posts()) : the_post();
        ?>
        <main class="doctor-single">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <h1><?php the_title(); ?></h1>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="doctor-photo">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <?php if (has_excerpt()) : ?>
                    <div class="doctor-excerpt">
                        <?php echo esc_html(get_the_excerpt()); ?>
                    </div>
                <?php endif; ?>

                <div class="doctor-meta">
                    <?php
                    $experience = get_post_meta(get_the_ID(), 'experience_years', true);
                    $price = get_post_meta(get_the_ID(), 'price_from', true);
                    $rating = get_post_meta(get_the_ID(), 'rating', true);
                    ?>

                    <?php if ($experience !== '') : ?>
                        <p><strong>Стаж:</strong> <?= esc_html($experience) ?> лет</p>
                    <?php endif; ?>

                    <?php if ($price !== '') : ?>
                        <p><strong>Цена от:</strong> <?= esc_html($price) ?> ₽</p>
                    <?php endif; ?>

                    <?php if ($rating !== '') : ?>
                        <p><strong>Рейтинг:</strong> <?= esc_html($rating) ?>/5</p>
                    <?php endif; ?>
                </div>

                <div class="doctor-content">
                    <?php the_content(); ?>
                </div>

                <div class="doctor-taxonomies">
                    <?php
                    $specializations = get_the_terms(get_the_ID(), 'specialization');
                    $cities = get_the_terms(get_the_ID(), 'city');
                    ?>

                    <?php if (!empty($specializations) && !is_wp_error($specializations)) : ?>
                        <p>
                            <strong>Специализация:</strong>
                            <?php
                            echo esc_html(
                                implode(', ', wp_list_pluck($specializations, 'name'))
                            );
                            ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($cities) && !is_wp_error($cities)) : ?>
                        <p>
                            <strong>Город:</strong>
                            <?php
                            echo esc_html(
                                implode(', ', wp_list_pluck($cities, 'name'))
                            );
                            ?>
                        </p>
                    <?php endif; ?>
                </div>

            </article>
        </main>
        <?php
    endwhile;
endif;

get_footer();
