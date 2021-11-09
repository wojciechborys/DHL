<?php
namespace SD\Admin\Offer;

/**
 * Dodaje metaboksy wpisu.
 *
 * @return void
 */
function addMetaBoxes() {

    \add_meta_box(
        'offer-meta-list-box',
        'Dane z eRecruitera',
        __NAMESPACE__.'\\offerMetaBox',
        ['offer'],
        'advanced',
        'high'
    );
}
\add_action('admin_init', __NAMESPACE__.'\\addMetaBoxes');

/**
 * Metaboks ustawień slajdu.
 *
 * @param WP_Post $post
 */
function offerMetaBox($post) {

    $metaKeys = [
		'_sd_erecruiter_id'                  => 'Identyfikator',
		'_sd_erecruiter_public_date'         => 'Data',
        '_sd_erecruiter_expiry_date'         => 'Data wygaśnięcia',
        '_sd_erecruiter_location'            => 'Lokalizacja',
        '_sd_erecruiter_url'                 => 'URL',
        '_sd_erecruiter_requirments'         => 'Wymagania',
        '_sd_erecruiter_opportunities'       => 'Mozliwości',
        '_sd_erecruiter_company_description' => 'Opis firmy',
        '_sd_erecruiter_clause'              => 'Klauzula'
	];
    ?>

    <table class="table form-table">
        <tr>
            <th>Pole</th>
            <th>Wartość</th>
        </tr>

        <?php
    foreach ($metaKeys as $key => $text) :
        $value = get_post_meta($post->ID, $key, true);
        ?><tr>
            <th scope="row"><?= $text; ?></th>
            <td><?= empty($value) ? '<i>[ puste ]</i>' : $value; ?></td>
        </tr><?php
    endforeach;
    ?>

    </table>

    <?php
}
