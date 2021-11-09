import $ from 'jquery'

var YouTubeIframeLoader = require('youtube-iframe');

$(document).ready(function () {
  var player;
  if ($('body').find('.video-section')) {
    YouTubeIframeLoader.load(function (YT) {
      player = new YT.Player('ytVideo', {
        videoId: $('#ytVideo').attr('data-yt-id'),
        host: 'https://www.youtube.com',
        playerVars: {
          showinfo: 0,
          autohide: 0,
          rel: 0,
          controls: 2,
          enablejsapi: 1,
          modestbranding: 1,
        },
        events: {
          // call this function when player is ready to use
          'onReady': onPlayerReady,
          'onStateChange': onPlayerStateChange
        }
      })
      function onPlayerReady(event) {
        $('.video-section').on('click touch', '.play-btn', function () {
          player.playVideo();
          $(this).parent('.video-overlay').addClass('video-overlay--hidden');
        });
      }

      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.ENDED) {
          // player.stopVideo();
          $('.video-section .video-overlay').removeClass('video-overlay--hidden');
        }
        if (event.data === 1) {
          $('#video-overlay').hide();
        }
      }
    })
  }
});