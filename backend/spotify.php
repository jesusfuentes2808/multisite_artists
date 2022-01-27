<?php

function itemsSpotify($dataSpotify){
    if(empty($dataSpotify)){
        return '';
    }

    $htmlSpotify = '';

    foreach ($dataSpotify->items as $item){
        $followers = $item->response->followers;
        $id = $item->response->id;
        $name = $item->response->name;
        $images = $item->response->images;
        $popularityProm = 0;

        $valuePopularity = array_map(function($item){
            return $item->track->popularity;
        }, $item->response->tracks->items);

        $totalItemsPopularity = count($valuePopularity);
        $sumPopularity = array_reduce($valuePopularity, function($a, $b) { return $a + $b; }, 0);
        $promPopularity = ($sumPopularity / $totalItemsPopularity);
        $promPopularity = number_format($promPopularity, 2, '.', '');

        $htmlSpotify .= '<div class="vtr__card">
                            <div class="vtr__card__image">
                                <img loading="lazy" src="' . $images[0]->url . '" alt="imagen">
                                <div class="type">
                                    <img loading="lazy" src="./assets/images/play-spotify.svg" alt="imagen">
                                </div>
                            </div>
                            <div class="vtr__card__info">
                                <div class="vtr__card__info__top">
                                    <h2 class="title text-center">' . $name . '</h2>
                                   <div class="follo-popu">
                                       <div class="followers">
                                           <span class="number">' . $followers->total . '</span>
                                           <span class="text">Seguidores</span>
                                       </div>
                                       <div class="popular">
                                           <div class="boxs">
                                               <div class="box"></div>
                                               <div class="box"></div>
                                               <div class="box"></div>
                                               <div class="box"></div>
                                               <div class="box"></div>
                                           </div>
                                           <span class="text">Popularidad: ' . $promPopularity . ' % </span>
                                       </div>
                                   </div>
                                </div>
                            </div>
                            <div class="vtr__card__bottom">
                                <a href="#" class="button follow_playlist_spotify_link" data-id="' . $id . '">Agregar a mi lista</a>
                            </div>
                        </div>';
    }

    return $htmlSpotify;
}

function getPopularity ($item) {
    $valuePopularity = array_map(function($item){
        return $item->track->popularity;
    }, $item->response->tracks->items);

    $totalItemsPopularity = count($valuePopularity);
    $sumPopularity = array_reduce($valuePopularity, function($a, $b) { return $a + $b; }, 0);
    $promPopularity = ($sumPopularity / $totalItemsPopularity);
    $promPopularity = number_format($promPopularity, 2, '.', '');

    return $promPopularity;
}

function itemSpotifyRanking($dataRanking){
    if(empty($dataRanking)){
        return '';
    }
    $htmlRanking = '';

    foreach($dataRanking->items as $item){
        $name = $item->response->name;
        $album = $item->response->album;
        $artists = $item->response->artists;
        $popularity = $item->response->popularity;

        $images = $album->images;

        $artistList = array_map(function($item){
            return $item->name;
        }, $artists);

        $artistListFinal = '';
        if(count($artistList) > 3){
            for ($i=0; $i<3; $i++){
                $artistListFinal .= ($artistList[$i] . (($i !== 2) ? ', ' : ', +'));
            }
        } else {
            $artistListFinal  = implode(", ", $artistList);
        }

        $artistsAll = implode(", ",$artistList);

        $htmlRanking .= '<div class="vtr__card vtr__card--playlist">
                            <div class="vtr__card__image">
                                <img loading="lazy" src="' . $images[0]->url . '" alt="' . $artistsAll . '">
                            </div>
                            <div class="vtr__card__info">
                                <div class="vtr__card__info__top">
                                    <h2 class="title">' . $name . '</h2>
                                    <h3 class="sub-title">' . $artistListFinal . '</h3>
                                </div>
                                <a href="#" class="vtr__card__info__add">
                                    <img loading="lazy" src="./assets/images/icon-open-plus.svg" alt="imagen">
                                </a>
                            </div>
                        </div>';
    }

    return $htmlRanking;
}
