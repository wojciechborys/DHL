<?php

namespace SD\SimpleRating;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Klasa obsługująca polubienia.
 */
class Ajax {

    /**
     * Kostruktor.
     */
    public function __construct() {
        \add_action('wp_ajax_love_action', [$this, 'userLikeAction']);
        \add_action('wp_ajax_nopriv_love_action', [$this, 'anonymousLikeAction']);
    }

    /**
     * Dodaje 1 do licznika polubień wpisu.
     *
     * @throws \Exception
     * @param integer $postId   Identyfikator artukuł
     * @param integer|string $userId  identyfikator użytkownika - WP User ID/IP
     */
    private function likeAction($postId, $userId) {

        list($postId, $userId) = $this->verifyInput($postId, $userId);

        \update_post_meta($postId, "_like_{$userId}", '1');

        $likes = (int) \get_post_meta($postId, '_all_likes', true);
        ++$likes;

        \update_post_meta($postId, '_all_likes', $likes);

        return $likes;
    }

    /**
     * Odejmuje 1 od licznika polubień wpisu.
     *
     * @throws \Exception
     * @param integer $postId   Identyfikator artukułu
     * @param integer|string $userId  identyfikator użytkownika - WP User ID/IP
     */
    private function unlikeAction($postId, $userId) {

        list($postId, $userId) = $this->verifyInput($postId, $userId);

        \delete_post_meta($postId, "_like_{$userId}");

        $likes = (int) \get_post_meta($postId, '_all_likes', true);
        --$likes;

        \update_post_meta($postId, '_all_likes', $likes);

        return $likes;
    }

    /**
     * Weryfikuje identyfikator wpisu i identyfikator użytkownika.
     *
     * @todo Zweryfikować, czy samo sprawdzanie IP nie wystarczy. Ewentualnie inna metoda.
     * @throws Exception
     * @param mixed $postId Identyfikator wpisu.
     * @param mixed $userId Identyfikator użytkownika lub jego IP.
     * @return array Tablica z identyfikatorem wpisu i identyfikatorem użytkownika.
     */
    private function verifyInput($postId, $userId) {

        $postId = $this->postExists($postId);

        if (false === $postId) {
            throw new \Exception('Błędny identyfikator artykułu.');
        }

        $isIP = $this->isIp($userId);

        if (!$isIP) {
            $userId = $this->userExists($userId);
        }

        if (false === $userId && false === $isIP) {
            throw new \Exception('Błędny identyfikator użytkownika.');
        }

        return [$postId, $userId];
    }

    /**
     * Sprawdza, czy wpis istnieje na podstawie jego identyfikatora.
     *
     * @param  mixed $postId Identyfikator/obiekt wpisu.
     * @return int|false Identyfikator wpisu lub FALSE, jeśli nie istnieje.
     */
    private function postExists($postId) {

        if ($postId instanceof \WP_Post) {
            return $postId->ID;
        }

        $postId = (int) $postId;

        if (empty($postId) || false === \get_post_status($postId)) {
            return false;
        }

        return $postId;
    }

    /**
     * Sprawdza, czy użytkownik istnieje na podstawie jego identyfikatora.
     *
     * @param  mixed $postId Identyfikator/obiekt użytkownika.
     * @return int|false Identyfikator użytkownika lub FALSE, jeśli nie istnieje.
    */
    private function userExists($userId) {

        if ($userId instanceof \WP_User) {
            return $userId->ID;
        }

        $userId = (int) $userId;

        if (empty($userId) || false === \get_userdata($userId)) {
            return false;
        }

        return $userId;
    }

    /**
     * Sprawdza, czy podana zmienna jest numerem IP.
     *
     * @param  mixed $maybeIp Być może IP.
     * @return string|false IP lub FALSE, jeśli nie podana zmienna nie jest IP.
    */
    private function isIp($maybeIp) {

        if (\filter_var($maybeIp, FILTER_VALIDATE_IP)) {
            return $maybeIp;
        }

        return false;
    }

    /**
     * Zbiera dane z zapytania.
     *
     * @return array {
     *   Dane z zapytania ajaksowego.
     *
     *   @type int    $post_id Identyfikator wpisu.
     *   @type int    $user_id Identyfikator użytkownika.
     *   @type string $ip      Numer IP użytkownika.
     * }
     */
    private function collectData() {

        $postId = \filter_input(INPUT_POST, 'postid', FILTER_VALIDATE_INT);
        $userId = \get_current_user_id();

        // PHP BUG - https://bugs.debian.org/cgi-bin/bugreport.cgi?bug=730094
        // na PHP 5.7 działa bez zarzutu
        // $ip = \filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP);
        // hack z użyciem filter_var aby działało i na wcześniejszych wersjach PHP
        $ip = \filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);

        $data = [
            'post_id' => (int) $postId,
            'user_id' => (int) $userId,
            'ip'      => $ip,
        ];

        return $data;
    }

    /**
     * Lajkuje wpis - użytkownik nie zalogowany.
     *
     * @todo Scalić z metodą SD\SimpleRating\Ajax::userLikeAction() - są niemal identyczne.
     * @return void
     */
    public function anonymousLikeAction(){

        // is_user_logged_in() = true
        $data = [
            'status'  => 'success',
            'message' => 'Dziękujemy za oddanie głosu.'
        ];

        try {

            $collectedData = $this->collectData();

            $postId = $collectedData['post_id'];
            $ip = $collectedData['ip'];

            $vote = \get_post_meta($postId, "_like_{$ip}", true);

            if(empty($vote)) {
                $data['likes'] = $this->likeAction($postId, $ip);
            } else {
                $data['likes'] = $this->unlikeAction($postId, $ip);
                $data['message'] = 'Już nie lubisz tego artykułu.';
            }

        } catch(\Exception $e) {

            $data = [
                'status'  => 'error',
                'message' => 'Coś poszło nie tak.'
            ];
        }

        \wp_send_json($data);
    }

    /**
     * Lajkuje wpis - użytkownik zalogowany.
     *
     * @todo Scalić z metodą SD\SimpleRating\Ajax::anonymousLikeAction() - są niemal identyczne.
     * @return void
     */
    public function userLikeAction(){

        // is_user_logged_in() = true
        $data = [
            'status' => 'success',
            'message' => 'Dziękujemy za oddanie głosu.'
        ];

        try {
            $postId = \filter_input(INPUT_POST, 'postid', FILTER_VALIDATE_INT);
            $userId = \get_current_user_id();

            $vote = \get_post_meta($postId, '_like_'.$userId, true);

            if(empty($vote)) {
                $data['likes'] = $this->likeAction($postId, $userId);
            } else {
                $data['likes'] = $this->unlikeAction($postId, $userId);
                $data['message'] = 'Już nie lubisz tego artykułu.';
            }

        } catch(\Exception $e) {

            $data = [
                'status'  => 'error',
                'message' => 'Coś poszło nie tak.'
            ];
        }

        \wp_send_json($data);
    }

}
