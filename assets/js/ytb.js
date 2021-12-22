/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************!*\
  !*** ./src/js/ytb.js ***!
  \***********************/
var youtube_ids = document.getElementById('youtube_ids').value;
youtube_ids = youtube_ids.split(',');
var array_youtube_ids = [];

for (var i = 0; i < youtube_ids.length; i++) {
  array_youtube_ids.push('id=' + youtube_ids[i]);
}

array_youtube_ids = array_youtube_ids.join('&');
console.log("array_youtube_ids");
console.log(array_youtube_ids);
/*
fetch("https://youtube.googleapis.com/youtube/v3/playlistItems?part=id&part=snippet&part=contentDetails%20&part=status&maxResults=50&playlistId=PLanrn6bPgjsaNw_IdAf90xRU6pQs-kF3v&key=AIzaSyA5hWJ8FJrTZr412seBlVgzCIoykzBm8yM")
    .then(res => res.json())
    .then( (data) => {
        //console.log(data);
        let html = '';
        data.items.forEach((item, index) => {
            //console.log(item);
            if(index > 2){
                return false;
            }
            const { snippet } = item;
            const { thumbnails } = snippet
            if(index === 0){
                html += `<div class="row" style="margin-top: 15px">`;
            }

            html += `<div class="col-md-4">
                                <div class="card-content">
                                    <div class="card-img">
                                        <img src="${thumbnails.standard.url}" alt="">
                                        <span><h4>${snippet.title}</h4></span>
                                    </div>
                                    <div class="card-desc">
                                        <h3>${snippet.title}</h3>
                                        <p>${snippet.description}</p>
                                        <a href="#" class="btn-card">Read</a>
                                    </div>
                                </div>
                            </div>`;

            if(index === data.items.length){
                html += `</div>`;
            }else if(index !== 0 && ( index+1 ) % 3 === 0){
                html += `</div><div class="row" style="margin-top: 15px">`;
            }
        });

        $("#playlist_inner").append(html);
    });

//UNO X UNO SOLO
//https://youtube.googleapis.com/youtube/v3/playlists?part=snippet%20&id=PLanrn6bPgjsaR1_bAV5-3aUAxOH-p9aNq&maxResults=10&key=[YOUR_API_KEY]
*/
//fetch("https://youtube.googleapis.com/youtube/v3/playlists?part=snippet%20&channelId=UCsTl5H5X4SvTUkCCaMbAWyg&maxResults=10&key=AIzaSyA5hWJ8FJrTZr412seBlVgzCIoykzBm8yM")

fetch("https://youtube.googleapis.com/youtube/v3/playlists?part=snippet%20&" + array_youtube_ids + "&maxResults=10&key=AIzaSyA5hWJ8FJrTZr412seBlVgzCIoykzBm8yM").then(function (res) {
  return res.json();
}).then(function (data) {
  //console.log(data);
  var html = '';
  data.items.forEach(function (item, index) {
    var id = item.id,
        snippet = item.snippet;
    var title = snippet.title,
        description = snippet.description,
        channelTitle = snippet.channelTitle,
        thumbnails = snippet.thumbnails;
    html += "<div class=\"vtr__card\">\n                            <div class=\"vtr__card__image\">\n                                <img loading=\"lazy\" src=\"".concat(thumbnails.high.url, "\" alt=\"imagen\">\n                                <div class=\"type\">\n                                    <img loading=\"lazy\" src=\"./assets/images/play-youtube.svg\" alt=\"imagen\">\n                                </div>\n                            </div>\n                            <div class=\"vtr__card__info\">\n                                <div class=\"vtr__card__info__top\">\n                                    <h2 class=\"title\">").concat(title, "</h2>\n                                    <h3 class=\"sub-title\">").concat(channelTitle, "</h3>\n                                    <!--<small class=\"reproductions\">350,000 Reproducciones</small>-->\n                                </div>\n                            </div>\n                            <div class=\"vtr__card__bottom\">\n                                <a href=\"#\" class=\"button\">Agregar a mi lista</a>\n                            </div>\n                        </div>");
  });
  $("#ytb_content").html("");
  $("#ytb_content").html(html);
});
fetch("https://youtube.googleapis.com/youtube/v3/channels?part=snippet&part=statistics%20&id=UCsTl5H5X4SvTUkCCaMbAWyg&key=AIzaSyA5hWJ8FJrTZr412seBlVgzCIoykzBm8yM").then(function (res) {
  return res.json();
}).then(function (data) {
  console.log(data);
});
/******/ })()
;