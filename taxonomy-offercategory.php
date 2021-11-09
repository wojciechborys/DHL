<?php
/**
 * Template Name: Oferty
 */

use SD\Template\Tags;
use Roots\Sage\Assets;

Tags\introSection();
?>

<section class="offers">
    <div class="offers__container container">
        <div class="offers__row row justify-content-center">

            <div class="col-12 col-md-11 col-lg-9">
                <h1 class="offers__header"><?= category_description(); ?></h1>
            </div>

            <div class="offers__content col-12 col-md-11">

                <table class="table offers__table">

                    <tr>
                        <th>Stanowisko</th>
                        <th>Lokalizacja</th>
                        <th class="text-right">Data publikacji</th>
                    </tr>

                    <?php
                    $query = new WP_Query(array(
                        'post_type' => 'offer',
                        'posts_per_page' => -1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'offercategory',
                                'field' => 'slug',
                                'terms' => htmlspecialchars($_GET['offercategory'], ENT_QUOTES, 'UTF-8')
                            )
                        )));
                    while ($query->have_posts()) : $query->the_post();
                        ?>

                        <tr>
                            <td>
                                <a href="<?php echo esc_attr(get_post_meta(get_the_ID(), '_sd_erecruiter_url', true)) ?>"
                                   target="_blank"><?php the_title() ?></a>
                            </td>
                            <td>
                                <?php echo get_post_meta(get_the_ID(), '_sd_erecruiter_location', true); ?>
                            </td>
                            <td class="text-right">
                                <?php echo get_post_meta(get_the_ID(), '_sd_erecruiter_public_date', true); ?>
                            </td>
                        </tr>

                    <?php
                    endwhile;
                    ?>

                </table>

            </div>

        </div>
    </div>
</section>
