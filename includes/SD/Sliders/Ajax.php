<?php

namespace SD\Sliders;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ajax {
    
    /**
     * 
     * @todo    dorzucić sprawdzanie wejścia
     * @throws \Exception
     * @param integer $postId   Identyfikator artukuł
     * @param integer|string $userId  identyfikator użytkownika - WP User ID/IP
     */
    private function likeAction($postId, $userId) {
        
        if(empty($postId)) {
            throw new \Exception('Błędy identyfikator artukułu');
        }
        
        if(empty($userId)) {
            throw new \Exception('Pusty identyfikator użytkownika');
        }
        
        \update_post_meta($postId, '_like_'.$userId, '1');
        
        $likes = (int) \get_post_meta($postId, '_all_likes', true);
        $likes++;
        
        \update_post_meta($postId, '_all_likes', $likes);
        
        return $likes;
    }
    
    /**
     * 
     * @todo    dorzucić sprawdzanie wejścia
     * @throws \Exception
     * @param integer $postId   Identyfikator artukułu
     * @param integer|string $userId  identyfikator użytkownika - WP User ID/IP
     */
    private function unlikeAction($postId, $userId) {
                
        if(empty($postId)) {
            throw new \Exception('Błędy identyfikator artukułu');
        }
        
        if(empty($userId)) {
            throw new \Exception('Pusty identyfikator użytkownika');
        }
        
        \delete_post_meta($postId, '_like_'.$userId);

        $likes = (int) \get_post_meta($postId, '_all_likes', true);
        $likes--;
        
        \update_post_meta($postId, '_all_likes', $likes);
        
        return $likes;
        
    }
    
    public function anonymousLikeAction(){
        
        // is_user_logged_in() = true
        $data = array(
            'status' => 'success',
            'message' => 'Dziękujemy za oddanie głosu'
        );
        
        try {

            $postId = \filter_input(INPUT_POST, 'postid', FILTER_VALIDATE_INT);
            
            // PHP BUG - https://bugs.debian.org/cgi-bin/bugreport.cgi?bug=730094
            // na PHP 5.7 działa bez zarzutu
            //$ip = \filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP);
            // hack z użyciem filter_var aby działało i na wcześniejszych
            $ip = \filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
        
            $vote = \get_post_meta($postId, '_like_'.$ip, true);
            
            if(empty($vote)) {
                $data['likes'] = $this->likeAction($postId, $ip);
            } else {
                $data['likes'] = $this->unlikeAction($postId, $ip);
                $data['message'] = 'Już nie lubisz tego artykułu';
            }
            
        } catch(\Exception $e) {

            $data = array(
                'status' => 'error',
                'message' => 'Coś poszło nie tak'
            );
        }
        
        \wp_send_json($data);

    }
    
    public function userLikeAction(){
        
        // is_user_logged_in() = true
        $data = array(
            'status' => 'success',
            'message' => 'Dziękujemy za oddanie głosu'
        );
        
        try {
            $postId = \filter_input(INPUT_POST, 'postid', FILTER_VALIDATE_INT);
            $userId = \get_current_user_id();

            
            $vote = \get_post_meta($postId, '_like_'.$userId, true);
            
            if(empty($vote)) {
                $data['likes'] = $this->likeAction($postId, $userId);
            } else {
                $data['likes'] = $this->unlikeAction($postId, $userId);
                $data['message'] = 'Już nie lubisz tego artykułu';
            }
            
        } catch(\Exception $e) {

            $data = array(
                'status' => 'error',
                'message' => 'Coś poszło nie tak'
            );
        }
        
        \wp_send_json($data);

    }

    public function __construct() {
                
        \add_action('wp_ajax_love_action', array($this, 'userLikeAction'));
        \add_action('wp_ajax_nopriv_love_action', array($this, 'anonymousLikeAction'));
        
    }
}
