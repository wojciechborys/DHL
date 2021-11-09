<?php
namespace MintMedia\Dhl\Experiments;

include_once DHL_THEME_DIR . 'lib' . DIRECTORY_SEPARATOR . 'GoogleAnalytics' . DIRECTORY_SEPARATOR . 'Experiment.php';

/**
 * Inicjalizuje eksperyment.
 *
 * @return void
 */
function init () {
    $experiment = get_experiment();
}

if (!\is_admin()) {
    \add_action('init', __NAMESPACE__ . '\\init');
}

/**
 * Zwraca obiekt eksperymentu, w razie potrzeby wcześniej go inicjalizuje.
 *
 * @return UnitedPrototype\GoogleAnalytics\Experiment|null
 */
function get_experiment () {
    static $experiment = null;

    if (null === $experiment) {
        $id = get_experiment_id();

        if ($id) {
            $homeUrl = home_url('/');

            $parsedHost = parse_url($homeUrl, PHP_URL_HOST);
            \UnitedPrototype\GoogleAnalytics\Experiment::setDomainName($parsedHost);

            $parsedPath = parse_url($homeUrl, PHP_URL_PATH);
            \UnitedPrototype\GoogleAnalytics\Experiment::setCookiePath($parsedPath);

            $experiment = new \UnitedPrototype\GoogleAnalytics\Experiment($id);

            try{
                $experiment->chooseVariation();
            } catch (\Exception $ex) {
                $experiment = null;
            }
        }
    }

    return $experiment;
}

/**
 * Zwraca identyfikator eksperymentu.
 *
 * @return string|false
 */
function get_experiment_id () {
    return \get_option('dhl_experiment_id');
}

/**
 * Zwraca wybraną wariację strony.
 *
 * @return int
 */
function get_variation () {
    return 1; # wygrała wersja B

    // $experiment = get_experiment();
    //
    // if (null === $experiment) {
    //     return 0;
    // }

    // $variation = $experiment->getChosenVariation();
    //
    // if (!$variation) {
    //     return 0;
    // }

    // return $variation;
}

/**
 * Zwraca wersję eksperymentu.
 *
 * @return string
 */
function get_version () {
    $variation = get_variation();
    $ab = 'ABCDEFGHIJKLMOPQRSTUVWXYZ';

    return $ab[$variation];
}

/**
 * Rejestruje stronę ustawień eksperymentu.
 *
 * @return void
 */
function register_page () {
    \add_submenu_page(
        'options-general.php',
        'Ustawienia eksperymentu',
        'Wersje A/B',
        'manage_options',
        'dhl-experiments-settings',
        __NAMESPACE__ . '\\settings_page'
    );
}
\add_action('admin_menu', __NAMESPACE__ . '\\register_page');

/**
 * Wyświetla pola ustawień eksperymentu.
 *
 * @return void
 */
function settings_page () {
    $experiment_id = get_experiment_id();
    ?>
    <div class="wrap dhl-settings">
        <h2>Ustawienia eksperymentów</h2>

        <form action="<?php echo \esc_url(\admin_url('admin-post.php')); ?>" method="post">

            <input type="hidden" name="action" value="save_dhl_experiment_settings" />
            <?php wp_nonce_field('update-dhl-experiment-settings', '_dhl_settings_nonce', true); ?>

            <div class="dhl-settings__block dhl-settings__block--bordered">
                <h3 class="dhl-settings__header dhl-settings__header--section-name">Identyfikator</h3>

                <input type="text" class="dhl-settings__input dhl-settings__input--text" name="dhl_experiment_id" value="<?php echo \esc_attr($experiment_id); ?>" style="width:100%; max-width:450px; dispaly:block; padding:8px;" />

                <p class="description">Identyfikator eksperymentu z ustawień po stronie Google.</p>
            </div>

            <div class="dhl-settings__block">
                <button type="submit" class="button button-primary">Zapisz</button>
            </div>

        </form>
    </div>
    <?php
}

/**
 * Zapisuje ustawienia.
 *
 * @return void
 */
function save_options () {
    $redirect = \add_query_arg('page', 'dhl-experiments-settings', \admin_url('options-general.php'));

    if ( !\current_user_can('manage_options') ) {
        \wp_redirect($redirect);
        die;
    }

    $nonce = \filter_input(INPUT_POST, '_dhl_settings_nonce');

    if (!$nonce || !\wp_verify_nonce($nonce, 'update-dhl-experiment-settings')) {
        $redirect = \add_query_arg('success', '0', $redirect);
        \wp_redirect($redirect);
        die;
    }

    $experiment_id = \filter_input(INPUT_POST, 'dhl_experiment_id', FILTER_DEFAULT);

    if (null !== $experiment_id && false !== $experiment_id) {
        update_option('dhl_experiment_id', $experiment_id);
    }

    $redirect = \add_query_arg([
        'success' => '1'
    ], $redirect);

    \wp_redirect($redirect);
    die;
 }
 \add_action('admin_post_save_dhl_experiment_settings', __NAMESPACE__ . '\\save_options');
