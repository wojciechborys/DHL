<?php

namespace SD\Erecruiter;

use SD\Posts\Creator;
use SD\Posts\Exceptions;

class Importer
{

    public function __construct()
    {

    }

    public function updateOffers($displayDebug = false)
    {

        # tablica wyników działania
        $results = [];

        if ($displayDebug) {
            echo '<h2>Synchronizacja z API</h2>';
        }

        # połączenie z API - pobranie
        $connector = new Connector();
        $offers = $connector->getOffers();

        $result['received'] = \count($offers);

        $offerPostType = 'offer';


        $currentOffersIDs = [];
        if ($displayDebug) {
            echo '<h3>Pobieranie ofert</h3>';
        }

        # wspólne argumenty do zapytań do bazy WP o oferty
        $args = [
            'post_type' => $offerPostType,
            'post_status' => ['publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash'],
            'posts_per_page' => -1,
            'fields' => 'ids'
        ];

        # tablice na informacje
        $results['posts_created'] = [];
        $results['posts_updated'] = [];
        $results['posts_pending'] = [];
        $results['terms_created'] = [];

        # tablice na błędy
        $results['post_errors'] = [];
        $results['meta_errors'] = [];
        $results['term_errors'] = [];

        foreach ($offers as $key => $offer) {
            if ($displayDebug) {
                echo '<h4>#' . $offer['id'] . ': ' . $offer['title'] . '</h4>';
            }

            # zapytanie o oferty
            $offerArgs = $args;
            $offerArgs['meta_query'] = [
                [
                    'key' => '_sd_erecruiter_id',
                    'value' => $offer['id'],
                    'compare' => '='
                ]
            ];
            $offerPosts = \get_posts($offerArgs);

            # dodanie / aktualizacja wpisu
            $postData = [
                'post_title' => $offer['title'],
                'post_content' => $offer['description'],
                'post_status' => 'publish',
                'post_type' => $offerPostType,
                'post_date' => $offer['publish-date']
            ];

            $creator = new Creator($postData);

            $update = !empty($offerPosts);

            if ($update) {
                if ($displayDebug) {
                    echo '<p>Oferta istnieje, aktualizowanie.</p>';
                }

                $creator->set_field('ID', reset($offerPosts)); // zawiera tylko ID
                $currentOffersIDs = array_merge($currentOffersIDs, $offerPosts);
            } elseif ($displayDebug) {
                echo '<p>Oferta nie istnieje, tworzenie nowego wpisu.</p>';
            }

            try {
                $creator->save(false);

                if ($update) {
                    $results['posts_updated'][] = $creator->get_ID();
                } else {
                    $results['posts_created'][] = $creator->get_ID();
                }

                if ($displayDebug) {
                    echo '<p>Ofertę ', (empty($offerPosts) ? 'utworzono' : 'zaktualizowano'), '. ID: ', $creator->get_ID(), '</p>';
                }
            } catch (Exceptions\PostException $ex) {
                if ($displayDebug) {
                    echo '<p>PODCZAS ZAPISYWANIA WPISU WYSTĄPIŁ BŁĄD: ', $ex->getMessage(), '</p>';
                }

                $results['post_errors'][] = [
                    'ID' => $creator->get_ID(),
                    'message' => $ex->getMessage(),
                    'type' => $update ? 'update' : 'create',
                ];
                continue;
            }

            if (!\in_array($creator->get_ID(), $currentOffersIDs)) {
                $currentOffersIDs[] = $creator->get_ID();
            }

            # aktualizacja / tworzenie metadanych
            $metaArr = [
                '_sd_erecruiter_id' => $offer['id'],
                '_sd_erecruiter_title' => $offer['title'],
                '_sd_erecruiter_public_date' => $offer['publish-date'],
                '_sd_erecruiter_expiry_date' => $offer['expiry-date'],
                '_sd_erecruiter_location' => $offer['location'],
                '_sd_erecruiter_url' => $offer['url'],
                '_sd_erecruiter_requirments' => $offer['requirements'],
                '_sd_erecruiter_opportunities' => $offer['opportunities'],
                '_sd_erecruiter_company_description' => $offer['company-description'],
                '_sd_erecruiter_clause' => $offer['clause']
            ];

            foreach ($metaArr as $metaKey => $metaValue) {
                $creator->set_meta($metaKey, $metaValue);
            }

            try {
                $creator->update_meta();
            } catch (\Exception $ex) {
                if ($displayDebug) {
                    echo '<p>', $ex->getMessage(), '</p>';
                    var_dump($creator->get_meta_errors());
                }

                $results['meta_errors'][] = [
                    'ID' => $creator->get_ID(),
                    'message' => $ex->getMessage()
                ];
            }

            # kategoria oferty
            if (empty($offer['category'])) {
                if ($displayDebug) {
                    echo '<p>Oferta nie została przypisana do żadnej kategorii, ponieważ nie ma jej przypisanej w eRecruiterze.</p>';
                }

                \wp_delete_object_term_relationships($creator->get_ID(), 'offercategory');
                continue;
            }

            $termId = \term_exists($offer['category'], 'offercategory', 0);
            if (!$termId) {
                $term = \wp_insert_term($offer['category'], 'offercategory');

                if ($term instanceof \WP_Error) {
                    if ($displayDebug) {
                        echo '<p>Podczas tworzenia kategorii oferty wystąpił błąd: ', $term->get_error_message(), '</p>';
                    }

                    $results['term_errors'][] = [
                        'ID' => $creator->get_ID(),
                        'message' => $term->get_error_message()
                    ];

                    continue;
                }

                $termId = [$term['term_id']];
                $results['terms_created'][] = $term['term_id'];
            }

            $x = \wp_set_post_terms($creator->get_ID(), $termId, 'offercategory', false);

            if ($displayDebug) {
                echo '<p>Oferta została przypisana do kategorii: &quot;', $offer['category'], '&quot; (id: ', \reset($termId), ')</p>';
            }
        }

        # wpisy przeterminowane
        if ($displayDebug) {
            echo '<h3>Aktualizowanie przeterminowanych wpisów.</h3>';
        }

        $outdatedOffersArgs = $args;
        $outdatedOffersArgs['post__not_in'] = $currentOffersIDs;

        $outdatedOffersArgs['meta_query'] = [
            [
                'key' => '_sd_erecruiter_id',
                'compare' => 'EXISTS'
            ]
        ];

        $outdatedOffers = \get_posts($outdatedOffersArgs);

        if (empty($outdatedOffers) && $displayDebug) {
            echo '<p>Brak nieaktualnych ofert.</p>';
        }

        foreach ($outdatedOffers as $outdatedPostID) {
            var_dump($outdatedPostID);
            $creator = new Creator(['ID' => $outdatedPostID]);
            $creator->set_field('post_status', 'pending');
//            echo 'wpis o ID: ' . $outdatedPostID . ' został usunięty z bazy WP';
//            wp_delete_post($outdatedPostID);
            try {
                $creator->save(false);

                if ($displayDebug) {
                    echo '<p>Ofertę ukryto. ID: ', $outdatedPostID, '</p>';
                }

                $results['posts_pending'] = $outdatedPostID;
            } catch (Exceptions\PostException $ex) {
                if ($displayDebug) {
                    echo '<p>Podczas aktualizowaniu wpisu (id: ', $outdatedPostID, ') wystąpił błąd: ' . $ex->getMessage() . '</p>';
                }

                $results['post_errors'][] = [
                    'ID' => $creator->get_ID(),
                    'message' => $ex->getMessage(),
                    'type' => 'pending',
                ];
            }
        }
        return $results;
    }

    public function removeDuplicates($displayDebug = false)
    {
        $args = array(
            'post_type' => 'offer',
            'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit'),
            'posts_per_page' => -1
        );
        $offerPosts = get_posts($args);
        $offerPostsData = [];
        echo '<br><br><h3>Lista zduplikowanych i przeniesionych do kosza postów</h3>';
        foreach ($offerPosts as $index => $offerSinglePost) {
            $offerPostsData[$offerSinglePost->ID] = get_post_meta($offerSinglePost->ID)['_sd_erecruiter_id'][0];
        }
        echo '<ul>';
        foreach (array_unique(array_diff_assoc($offerPostsData, array_unique($offerPostsData))) as $postToRemoveKey => $postToRemove) {
            echo '<li>';
            echo get_the_title($postToRemoveKey);
            echo '</li>';
            wp_update_post(array(
                    'ID' => $postToRemoveKey,
                    'post_status' => 'trash')
            );
        }
        echo '</ul>';
    }
}
