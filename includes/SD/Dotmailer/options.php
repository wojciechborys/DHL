<?php
namespace SD\Dotmailer\OptionsAdmin;

use SD\Dotmailer\Api;

/**
 * Dodaje stronę ustawień API dotmailera.
 *
 * @return void
 */
function addSettingsPage() {
    \add_submenu_page(
        'options-general.php',
        'Opcje dotmailer',
        'dotmailer',
        'manage_options',
        'dotmailer-options',
        __NAMESPACE__.'\\optionsPage'
    );
}
\add_action('admin_menu', __NAMESPACE__.'\\addSettingsPage');

/**
 * Wyświetla stronę ustawień dotmailera.
 *
 * @return void
 */
function optionsPage() {
    $api = new Api();

    $login = $api->getLogin();
    $password = $api->getPassword();
    $books = $api->getAddressBooks();
    $bookId = $api->getMainAddressBookId();
    ?>
    <div class="wrap">
        <h1>Opcje dotmailera</h1>

        <form action="<?php echo esc_url(admin_url('options-general.php')); ?>" method="post">
            <?php \wp_nonce_field('save-dotmailer-options', 'dotmailer-options-nonce', false); ?>

            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="dotmailer-login">Nazwa użytkownika</label>
                        </th>
                        <td>
                            <input name="dotmailer-login" id="dotmailer-login" value="<?php echo esc_attr($login); ?>" class="regular-text" type="text" placeholder="Wpisz login do usługi">
                            <p class="description">Nazwa użytkownika wykorzystywana do zapytań do API usługi.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="dotmailer-password">Hasło do usługi</label>
                        </th>
                        <td>
                            <input name="dotmailer-password" id="dotmailer-password" value="<?php echo esc_attr($password); ?>" class="regular-text" type="text" placeholder="Wpisz hasło">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="dotmailer-group-id">Książka adresowa</label>
                        </th>
                        <td>
                            <?php
                            $refreshButton = true;

                            if (!$login || !$password) :
                                $refreshButton = false;
                                ?><p class="description">Przed wybraniem książki adresowej wprowadź e-mail i/lub hasło do usługi.</p><?php
                            elseif (empty($books)) :
                                ?><p class="description">Przed wybraniem książki adresowej należy pobrać ich listę z usługi.</p><?php
                            else :
                                ?><select id="dotmailer-group-id" name="dotmailer-group-id">
                                    <option value="-1">Wybierz</option>
                                    <?php
                                    foreach ($books as $book) :
                                        ?><option value="<?php echo esc_attr($book['Id']); ?>"<?php
                                            selected($book['Id'], $bookId);
                                        //    disabled('Private', $book['Visibility']);
                                            ?>><?= esc_html($book['Name']); ?><?php
                                            if ('Private' === $book['Visibility']) :
                                                ?> [prywatna]<?php
                                            endif;
                                        ?></option><?php
                                    endforeach;
                                    ?>
                                </select>
                                <p class="description">Aby przypisywać użytkowników do książki adresowej, należy wcześniej ją wybraź spośród dostępnych w powyższym polu.</p><?php
                            endif;

                            if ($refreshButton) :
                                ?><p><button name="action" value="dotmailer-refresh-groups" class="button-secondary">Odśwież listę</button></p><?php
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button name="action" value="dotmailer-save-options" class="button-primary">Zapisz</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div><?php
}

/**
 * Zpisuje ustawienia API dotmailera.
 *
 * @return void
 */
function saveOptions() {
    if (!isset($_POST['action'])) {
        return;
    }

    $action = \filter_input(INPUT_POST, 'action');

    if ('dotmailer-refresh-groups' !== $action && 'dotmailer-save-options' !== $action) {
        return;
    }

    if (!\current_user_can('manage_options')) {
        return;
    }

    $nonce = \filter_input(INPUT_POST, 'dotmailer-options-nonce');

    if (!\wp_verify_nonce($nonce, 'save-dotmailer-options')) {
        return;
    }

    $redirecUrl = \admin_url('options-general.php?page=dotmailer-options');
    $redirecUrl = \add_query_arg('page', 'dotmailer-options', $redirecUrl);

    $api = new Api();

    if ('dotmailer-refresh-groups' === $action) {
        $books = $api->getAddressBooksFromService();
        $prevBooks = $api->getAddressBooks();
        if (empty($books)) {
            addUserNotice(
                'Nie powiodło się pobieranie książek adresowych z usługi.',
                'error'
            );

            \wp_redirect($redirecUrl);
            exit;
        }

        if (!empty($prevBooks)) {
            $diff = arrayRecursiveDiff($books, $prevBooks);

            if (empty($diff)) {
                addUserNotice(
                    'Książki w zapisane usłudze i w witrynie nie różnią się. Zapisywanie nie było konieczne.',
                    'info'
                );

                \wp_redirect($redirecUrl);
                exit;
            }
        }

        $saved = $api->saveAddressBooks($books);

        if ($saved) {
            addUserNotice(
                'Grupy zostały odświeżone.',
                'success'
            );
        } else {
            addUserNotice(
                'Odświeżanie grup zakończyło się niepowodzeniem.',
                'error'
            );
        }

        \wp_redirect($redirecUrl);
        exit;
    }

    $updated = [];

    $login = \filter_input(INPUT_POST, 'dotmailer-login');

    if ($login) {
        $saved = $api->saveLogin($login);
        $updated[] = $saved ? 'login' : false;
    }

    $password = \filter_input(INPUT_POST, 'dotmailer-password');
    $encode = \filter_input(INPUT_POST, 'dotmailer-encode');

    if ($password) {
        $saved = $api->savePassword($password, $encode);
        $updated[] = $saved ? 'hasło' : false;
    }

    $bookId = \filter_input(INPUT_POST, 'dotmailer-group-id');

    if ($bookId) {
        $saved = $api->saveMainAddressBookId($bookId);
        $updated[] = $saved ? 'książka adresowa' : false;
    }

    $cu = count($updated);
    $updated = \array_filter($updated);

    if (\count($updated)) {
        addUserNotice(
            \sprintf('Dane (%s) zostały zaktualizowane.', \implode(', ', $updated)),
            'success'
        );
    } elseif ($cu) {
        addUserNotice(
            'Nie było żadnych nowych danych do zapisania.',
            'info'
        );
    } else {
        addUserNotice(
            'Zapis danych nie powiódł się.',
            'error'
        );
    }

    \wp_redirect($redirecUrl);
    exit;
}
\add_action('init', __NAMESPACE__ . '\\saveOptions');

/**
 * Dodaje informację dla użytkownika dostępną po przeładowaniu strony.
 *
 * @param string $message Wiadomość.
 * @param string $type    Typ wiadomości: 'info', 'warning', 'success', 'error'.
 */
function addUserNotice ($message, $type = 'info') {
    switch($type) {
        case 'success':
        case 'warning':
        case 'error':
        case 'info':
            break;

        default:
            $type = 'info';
    }

    $uid = \get_current_user_id();

    if (!$uid) {
        return false;
    }

    $set = \set_transient(
        "dotmailer-user-{$uid}-notice",
        [
            'message' => $message,
            'type'    => $type
        ],
        15
    );
}

/**
 * Zwraca wiadomość dla użytkownika.]
 *
 * @return false|array
 */
function getUserNotice () {
    $uid = \get_current_user_id();

    if (!$uid) {
        return false;
    }

    $notice = \get_transient("dotmailer-user-{$uid}-notice");

    if (false === $notice) {
        return false;
    }

    \delete_transient("dotmailer-user-{$uid}-notice");

    if (!\is_array($notice) || !isset($notice['message']) || !isset($notice['type'])) {
        return false;
    }

    return $notice;
}

/**
 * Wyświetla wiadomość dla użytkownika.
 *
 * @return void
 */
function displayUserNotice () {
    $notice = getUserNotice();

    if (!$notice) {
        return;
    }

    ?>
    <div class="notice notice-<?php echo $notice['type']; ?> is-dismissible">
        <p><?php echo $notice['message']; ?></p>
    </div>
    <?php
}
\add_action('admin_notices', __NAMESPACE__ . '\\displayUserNotice');

/**
 * Funkcja pomocnicza przy sprawdzaniu różnic pomiędzy tablicami wielowymiarowymi.
 *
 * @param  array $aArray1
 * @param  array $aArray2
 * @return array
 */
function arrayRecursiveDiff(array $aArray1, array $aArray2) {
    $aReturn = [];

    foreach ($aArray1 as $mKey => $mValue) {
        if (\array_key_exists($mKey, $aArray2)) {
            if (\is_array($mValue)) {
                $aRecursiveDiff = arrayRecursiveDiff($mValue, $aArray2[$mKey]);

                if (count($aRecursiveDiff)) {
                    $aReturn[$mKey] = $aRecursiveDiff;
                }
            } else {
                if ($mValue != $aArray2[$mKey]) {
                    $aReturn[$mKey] = $mValue;
                }
            }
        } else {
            $aReturn[$mKey] = $mValue;
        }
    }

    return $aReturn;
}
