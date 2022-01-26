<?php

function itemsYoutube($dataYoutube){
    $htmlYoutube  = '';
    foreach($dataYoutube->items as $item){
        $codePlaylist = $item->codigo_de_playlist;
        foreach ($item->response->items as $itemYT){
            $channelId = $itemYT->snippet->channelId;
            $thumbnailsUrl = $itemYT->snippet->thumbnails->high->url;
            $snippetTitle = $itemYT->snippet->title;
            $channelTitle = $itemYT->snippet->channelTitle;

            $htmlYoutube .= '<div class="vtr__card">
            <div class="vtr__card__image">
                <img loading="lazy" src="' . $thumbnailsUrl . '" alt="imagen">
                <div class="type">
                    <img loading="lazy" src="./assets/images/play-youtube.svg" alt="imagen">
                </div>
            </div>
            <div class="vtr__card__info">
                <div class="vtr__card__info__top">
                    <h2 class="title">' . $snippetTitle . '</h2>
                    <h3 class="sub-title">' . $channelTitle . '</h3>
                    <!--<small class="reproductions">350,000 Reproducciones</small>-->
                </div>
            </div>
            <div class="vtr__card__bottom">
                <a href="https://www.youtube.com/playlist?list=' . $codePlaylist . '" target="_blank" class="button">Agregar a mi lista</a>
            </div>
        </div>';
        }
    }

    return $htmlYoutube;
}
