<?php

function itemsYoutube($dataYoutube){
    if(empty($dataYoutube)){
        return '';
    }

    $htmlYoutube  = '';
    foreach($dataYoutube->items as $item){
        $codePlaylist = $item->codigo_de_playlist;
        foreach ($item->response->items as $itemYT){
            $channelId = $itemYT->snippet->channelId;
            $thumbnailsUrl = $itemYT->snippet->thumbnails->default->url;
            $snippetTitle = $itemYT->snippet->title;
            $channelTitle = $itemYT->snippet->channelTitle;
            $videoId = explode('/',$thumbnailsUrl);
            $videoId = $videoId[4];

            $htmlYoutube .= '<div class="vtr__card">
                                <div class="vtr__card__image">
                                    <img loading="lazy" src="https://img.youtube.com/vi/' . $videoId . '/hqdefault.jpg" alt="imagen">
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
                                <!--https://www.youtube.com/watch?v=q01z2vrQTrE&list=PLanrn6bPgjsbWdA7MPfyLAZS1D-byCfVb-->
                                <!--https://www.youtube.com/playlist?list=  codePlaylist  -->
                                    <a href="https://www.youtube.com/watch?v=' . $videoId . '&list=' . $codePlaylist . '" target="_blank" class="button">Escuchar playlist</a>
                                </div>
                            </div>';
        }
    }

    return $htmlYoutube;
}
