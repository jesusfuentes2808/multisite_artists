/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************!*\
  !*** ./src/js/follow.js ***!
  \**************************/
var url_string = window.location.href;
var tokenIndex = url_string.indexOf("=");
var tokenIndexEnd = url_string.indexOf("&");
var accessToken = url_string.substring(tokenIndex + 1, tokenIndexEnd);
var track_id = localStorage.getItem('track_id');
var playlist_id = localStorage.getItem('playlist_id');

if (accessToken !== '' && track_id) {
  fetchFollow(track_id, 'track');
}

if (accessToken !== '' && playlist_id) {
  fetchFollow(playlist_id, 'playtlist');
}

function fetchFollow(id, type) {
  var url = '';

  if (type === 'track') {
    url = 'https://api.spotify.com/v1/me/tracks?ids=' + id;
  } else if (type === 'playtlist') {
    console.log("trackCustom|");
    url = 'https://api.spotify.com/v1/playlists/' + id + '/followers';
  }

  console.log("trackCustom");
  console.log(type);
  console.log(url); //fetch('https://api.spotify.com/v1/playlists/' + playList + '/followers',

  fetch(url, {
    method: 'PUT',
    headers: {
      'Authorization': 'Bearer ' + accessToken,
      'Content-Type': "application/json"
    }
  }).then(function (result) {
    console.log("SUCCESS - " + id);
    console.log(result);
  })["catch"](function (error) {
    console.log("ERROR - " + id);
    console.log(error);
  })["finally"](function () {
    localStorage.removeItem('track_id');
    localStorage.removeItem('playlist_id');
  });
}

$("body").on('click', ".follow_track_spotify_link", function (e) {
  e.preventDefault(); //localStorage.setItem('redirect_callback', window.location.href.split('?')[0]);

  localStorage.setItem('redirect_callback', window.location.protocol + '//' + window.location.host + '/gracias.html');
  localStorage.setItem('track_id', $(this).attr('data-id'));
  window.location.href = "http://accounts.spotify.com/authorize?client_id=8c470d86b5924553ad2e4f447de50851&redirect_uri=http:%2F%2Fmultisite_artists.test%3A8084%2Fcallback.html&scope=user-library-modify%20user-follow-modify%20playlist-modify-public&response_type=token&state=123";
});
$("body").on('click', ".follow_playlist_spotify_link", function (e) {
  e.preventDefault(); //localStorage.setItem('redirect_callback', window.location.href.split('?')[0]);

  localStorage.setItem('redirect_callback', window.location.protocol + '//' + window.location.host + '/gracias.html');
  localStorage.setItem('playlist_id', $(this).attr('data-id'));
  window.location.href = "http://accounts.spotify.com/authorize?client_id=8c470d86b5924553ad2e4f447de50851&redirect_uri=http:%2F%2Fmultisite_artists.test%3A8084%2Fcallback.html&scope=user-library-modify%20user-follow-modify%20playlist-modify-public&response_type=token&state=123";
});
/******/ })()
;