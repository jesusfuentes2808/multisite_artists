<?php
require('./backend/helper.php');
require('./backend/request.php');
require('./backend/youtube.php');
require('./backend/spotify.php');

$url = URL;
$alias = ALIAS;
$urlJson = URL_JSON;

// ARTIST MAIN CONTENT
$filename = dirname(__FILE__) . '/assets/json/artist.json';

if (file_exists($filename)) {
    $contentArtist = file_get_contents($filename);
    $data = json_decode($contentArtist);
} else {
    $contentArtist = requestUrl($urlJson . "/$alias/artist.json");
    $data = json_decode($contentArtist);
}

$banner = '';
$bannerSec = '';
$videoYoutubeId = 'kFs0xdjGXwU';
$title = 'Artistas';
$description = 'Artistas';
$keywords = 'artistas';
$content = 'Creamos un equipo en torno a sus necesidades y brindamos a nuestros clientes producciones de alta calidad <a href="https://www.themonkeydigital.com/">The Monkey Digital</a>';
$thumbnail = 'https://www.themonkeydigital.com/wp-content/uploads/2021/10/cab1.png';
$dataSites = [];

if($data){
    $content = $data->post->post_content;

    $title = $data->post->post_title;
    $thumbnail = $data->post_thumbnail;
    $videoYoutubeId = $data->field_custom->video_youtube_id[0];
    $dataSites = $data->artist_all;

    $banner = $data->field_custom->html_banner[0];
    $banner = trim($banner);

    $bannerSec = $data->field_custom->html_banner_sec[0];
    $bannerSec = trim($bannerSec);

        // SEO
        $title = $data->field_custom->seo_title[0];
        $title = trim($title);

        $description = $data->field_custom->seo_description[0];
        $description = trim($description);

        $keywords = $data->field_custom->seo_keywords[0];
        $keywords = trim($keywords);
        // END SEO
}


// END ARTIST MAIN CONTENT

// Global RANKING
$filename = dirname(__FILE__) . '/assets/json/ranking.json';

$dataRanking = null;

if (file_exists($filename)) {
    $contentRanking = file_get_contents($filename);
    $dataRanking = json_decode($contentRanking);
}

$htmlRanking = itemSpotifyRanking($dataRanking);

//ERROR RESPONSE;
//string(149) "{"code":"rest_no_route","message":"No se ha encontrado ninguna ruta que coincida con la URL y el m\u00e9todo de la solicitud.","data":{"status":404}}"
// END Global RANKING

// Global ARTIST AND ITEMS
$dataArtistWeek = null;
$filename = dirname(__FILE__) . '/assets/json/page_artist_item.json';

if (file_exists($filename)) {
    $contentArtistWeek = file_get_contents($filename);
    $dataArtistWeek = json_decode($contentArtistWeek);
    $titleArtistWeek = $dataArtistWeek->post->post_title;
    $itemsArtistItemWeek = $dataArtistWeek->items;
} else {
    $contentArtistWeek = requestUrl($urlJson . "/page_artist_item/page_artist_item.json");
    $dataArtistWeek = json_decode($contentArtistWeek);
    $titleArtistWeek = $dataArtistWeek->post->post_title;
    $itemsArtistItemWeek = $dataArtistWeek->items;
}

$thumbnailArtistWeek = $dataArtistWeek->post_thumbnail;
$implodeArtistItemWeek = implodeArrayGlobalList($itemsArtistItemWeek, 'track_id');

$htmlArtistWeek = itemSpotifyRanking($dataArtistWeek, 'items');

// END Global ARTIST AND ITEMS

// URL de formulario
$urlSubmit = $url . "/insert";


// Lista YOUTUBE

$filename = dirname(__FILE__) . '/assets/json/playlist_yt.json';
$dataYoutube = null;
if (file_exists($filename)) {
    $contentYoutube = file_get_contents($filename);
    $dataYoutube = json_decode($contentYoutube);
}

$htmlYoutube = itemsYoutube($dataYoutube);


// Lista SPOTIFY

$htmlSpotify = '';
$filename = dirname(__FILE__) . '/assets/json/playlist_sp.json';
$dataSpotify = null;
if (file_exists($filename)) {
    $contentSpotify = file_get_contents($filename);
    $dataSpotify = json_decode($contentSpotify);
}

$htmlSpotify = itemsSpotify($dataSpotify);

// Lista SPOTIFY

$htmlTrend = '';
$filename = dirname(__FILE__) . '/assets/json/in_trend.json';
$dataTrend = null;

if (file_exists($filename)) {
    $contentTrend = file_get_contents($filename);
    $dataTrend = json_decode($contentTrend);
}

$htmlTrend = itemSpotifyRanking($dataTrend, 'trend');

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="description" content="<?php echo $description ?>">
    <meta name="keywords" content="<?php echo $keywords ?>">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=11,IE=10,IE=9,IE=edge"/>
    <meta name="theme-color" content="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <link rel="icon" type="image/png" sizes="144x144" href="./assets/images/favicon.png">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title><?php echo $title ?></title>
    <script>
        window.url = "<?php echo $url; ?>";
        window.urlJson = "<?php echo $urlJson; ?>";
        window.alias = "<?php echo $alias; ?>";
        console.log(window.urlJson + "/" + window.alias + "/playlist_yt.json");
    </script>
</head>
<body>
<input type="hidden" id="video_youtube_id" value="<?php echo $videoYoutubeId; ?>">
<!--
<header class="vtr__header">
    <div class="vtr__container">
        <a class="vtr__header__logo" href="#">
            <img src="./assets/images/logo.svg" alt="Logo" loading="lazy">
        </a>
        <nav class="vtr__header__menu">
            <ul class="menu">
                <li>
                    <a href="#">Demo link</a>
                </li>
                <li>
                    <a href="#">Demo link</a>
                </li>
                <li>
                    <a href="#">Demo link</a>
                </li>
            </ul>
        </nav>
        <button class="vtr__header__hamburguer">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 40">
                <g stroke="#fff" stroke-width="3">
                    <path id="top-line" d="M10,10 L50,10 Z" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"></path>
                    <path id="middle-line" d="M10,20 L50,20 Z" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"></path>
                    <path id="bottom-line" d="M10,30 L50,30 Z" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"></path>
                </g>
            </svg>
        </button>
    </div>
</header>
-->
<main>
    <section class="vtr__video">
        <!--<iframe src="https://www.youtube.com/embed/ZhIsAZO5gl0?autoplay=1&mute=1&loop=1&controls=0"></iframe>-->
        <div id="player"></div>
        <div class="vtr__video__content">
            <div class="logo">
                <img loading="lazy" src="./assets/images/logo.svg" alt="Logo">
            </div>
            <button class="vtr__button js-scroll" id="#trend">Descubre tú música</button>
        </div>

        <div class="vtr__video__controls">
            <button
                class="control-play isPlay"
                data-pause="./assets/images/pause.svg"
                data-play="./assets/images/play.svg"
            >
                <img
                    loading="lazy"
                    class="play-image"
                    src="./assets/images/pause.svg"
                    alt="Play"
                >
            </button>
            <button
                class="control-volume isVolume"
                data-mute="./assets/images/mute.svg"
                data-volume="./assets/images/volume.svg"
            >
                <img
                    loading="lazy"
                    class="volume-image"
                    src="./assets/images/volume.svg"
                    alt="Volumen"
                >
            </button>
            <!--<button class="control-play">
                <img loading="lazy" src="./assets/images/play.svg" alt="Play">
            </button>

            <button style="color: white" class="control-pause">
                ||
            </button>
            <button class="control-volume">
                <img loading="lazy" src="./assets/images/volume.svg" alt="Volumen">
            </button>-->
        </div>

    </section>
    <section id="trend" class="vtr__trend bg-purple padding-top padding-bottom">
        <div class="vtr__container">
            <?php if ($banner !== ''): ?>
                <div class="vtr__advertising">
                    <?php echo $banner; ?>
                </div>
            <?php endif ?>
            <div class="vtr__flex vtr__flex__space-between padding-top-50">
                <div class="vtr__col__8">
                    <h2 class="vtr__title vtr__title--line"><span>En tendencia</span></h2>
                    <div class="vtr__loading in_trend_content__loading">
                        <img loading="lazy" src="./assets/images/loading.svg" alt="cargando">
                    </div>
                    <div id="trend_content" class="vtr__grid vtr__grid-gap-10 vtr__grid-col-3">
                        <?php if ( ! is_null($dataTrend) ) : ?>
                            <?php echo $htmlTrend; ?>
                        <?php endif ?>
                        <!--
                        <div class="vtr__card">
                            <div class="vtr__card__image">
                                <img loading="lazy" src="./assets/images/img1.jpg" alt="imagen">
                            </div>
                            <div class="vtr__card__info">
                                <div class="vtr__card__info__top">
                                    <h2 class="title">Taonoces Rojos</h2>
                                    <h3 class="sub-title">Sebastian Yatra</h3>
                                    <small class="reproductions">350,000 Reproducciones</small>
                                </div>
                            </div>
                            <div class="vtr__card__bottom">
                                <a href="#" class="button">Agregar a mi lista</a>
                            </div>
                        </div>
                        <div class="vtr__card">
                            <div class="vtr__card__image">
                                <img loading="lazy" src="./assets/images/img2.png" alt="imagen">
                            </div>
                            <div class="vtr__card__info">
                                <div class="vtr__card__info__top">
                                    <h2 class="title">Yonaguni</h2>
                                    <h3 class="sub-title">Toto</h3>
                                    <small class="reproductions">350,000 Reproducciones</small>
                                </div>
                            </div>
                            <div class="vtr__card__bottom">
                                <a href="#" class="button">Agregar a mi lista</a>
                            </div>
                        </div>
                        <div class="vtr__card">
                            <div class="vtr__card__image">
                                <img loading="lazy" src="./assets/images/img3.png" alt="imagen">
                            </div>
                            <div class="vtr__card__info">
                                <div class="vtr__card__info__top">
                                    <h2 class="title">Demo para saber la altura</h2>
                                    <h3 class="sub-title">Maluma</h3>
                                    <small class="reproductions">350,000 Reproducciones</small>
                                </div>
                            </div>
                            <div class="vtr__card__bottom">
                                <a href="#" class="button">Agregar a mi lista</a>
                            </div>
                        </div>
                        -->
                    </div>
                </div>
                <div class="vtr__col__4 bg-blur mt-30-mb  overflow-y">
                    <h2 class="vtr__title">Los más escuchados</h2>
                    <div class="vtr__loading ranking_content__loading">
                        <img loading="lazy" src="./assets/images/loading.svg" alt="cargando">
                    </div>
                    <div id="ranking_content" class="vtr__grid vtr__grid-gap-5">
                        <?php if ( ! is_null($dataRanking) ) : ?>
                            <?php echo $htmlRanking; ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>

            <div class="padding-top-50">
                <h2 class="vtr__title vtr__title--line"><span>Recien agregadas</span></h2>
                <div class="vtr__loading ytb_content__loading">
                    <img loading="lazy" src="./assets/images/loading.svg" alt="cargando">
                </div>
                <div id="ytb_content" class="vtr__grid vtr__grid-gap-10 vtr__grid-col-5">
                    <?php if ( ! is_null($dataYoutube) ) : ?>
                        <?php echo $htmlYoutube ?>
                    <?php endif ?>
                </div>
            </div>
            <div class="vtr__artist__week margin-top-50"
                 style="<?php echo ($thumbnailArtistWeek !== '') ? 'background-image: url(' . $thumbnailArtistWeek . ');' : ''; ?>">
                <div class="info">
                    <h2>Artista de la semana</h2>
                    <h3><?php echo $titleArtistWeek; ?></h3>
                </div>
                <div class="vtr__loading week_contect_content__loading">
                    <img loading="lazy" src="./assets/images/loading.svg" alt="cargando">
                </div>
                <div id="week_contect" class="vtr__grid vtr__grid-gap-10 vtr__grid-col-4">
                    <?php if ( ! is_null($dataArtistWeek) ) : ?>
                        <?php echo $htmlArtistWeek; ?>
                    <?php endif ?>
                </div>
            </div>
            <?php if ($bannerSec !== ''): ?>
                <div class="vtr__advertising margin-top-50">
                    <?php echo $bannerSec; ?>
                </div>
            <?php endif ?>
        </div>
    </section>
    <section class="vtr__bio">
        <div class="vtr__container">
            <div class="vtr__flex vtr__flex__space-between padding-top-50">
                <div class="vtr__col__8">
                    <h2>Biografia</h2>
                    <?php echo $content; ?>
                </div>
                <div class="vtr__col__4 bg-blur mt-30-mb">
                    <img loading="lazy" src="<?php echo $thumbnail; ?>" alt="imagen">
                </div>
            </div>
        </div>
    </section>
    <section class="vtr__trend bg-purple padding-top padding-bottom">
        <div class="vtr__container">
            <h2 class="vtr__title vtr__title--line"><span>Nuevos lanzamientos</span></h2>
            <div class="vtr__loading spt_content_content__loading">
                <img loading="lazy" src="./assets/images/loading.svg" alt="cargando">
            </div>
            <div id="spt_content" class="vtr__grid vtr__grid-gap-10 vtr__grid-col-5">
                <?php if( !empty($dataSpotify) ): ?>
                    <?php echo $htmlSpotify; ?>
                <?php endif; ?>
                <!--
                <div class="vtr__card">
                    <div class="vtr__card__image">
                        <img loading="lazy" src="./assets/images/img8.jpg" alt="imagen">
                        <div class="type">
                            <img loading="lazy" src="./assets/images/play-spotify.svg" alt="imagen">
                        </div>
                    </div>
                    <div class="vtr__card__info">
                        <div class="vtr__card__info__top">
                            <h2 class="title text-center">Taonoces Rojos</h2>
                           <div class="follo-popu">
                               <div class="followers">
                                   <span class="number">1.450.000</span>
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
                                   <span class="text">Popularidad</span>
                               </div>
                           </div>
                        </div>
                    </div>
                    <div class="vtr__card__bottom">
                        <a href="#" class="button">Agregar a mi lista</a>
                    </div>
                </div>
                <div class="vtr__card">
                    <div class="vtr__card__image">
                        <img loading="lazy" src="./assets/images/img7.jpg" alt="imagen">
                        <div class="type">
                            <img loading="lazy" src="./assets/images/play-spotify.svg" alt="imagen">
                        </div>
                    </div>
                    <div class="vtr__card__info">
                        <div class="vtr__card__info__top">
                            <h2 class="title text-center">Taonoces Rojos</h2>
                           <div class="follo-popu">
                               <div class="followers">
                                   <span class="number">1.450.000</span>
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
                                   <span class="text">Popularidad</span>
                               </div>
                           </div>
                        </div>
                    </div>
                    <div class="vtr__card__bottom">
                        <a href="#" class="button">Agregar a mi lista</a>
                    </div>
                </div>
                <div class="vtr__card">
                    <div class="vtr__card__image">
                        <img loading="lazy" src="./assets/images/img6.png" alt="imagen">
                        <div class="type">
                            <img loading="lazy" src="./assets/images/play-spotify.svg" alt="imagen">
                        </div>
                    </div>
                    <div class="vtr__card__info">
                        <div class="vtr__card__info__top">
                            <h2 class="title text-center">Taonoces Rojos</h2>
                           <div class="follo-popu">
                               <div class="followers">
                                   <span class="number">1.450.000</span>
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
                                   <span class="text">Popularidad</span>
                               </div>
                           </div>
                        </div>
                    </div>
                    <div class="vtr__card__bottom">
                        <a href="#" class="button">Agregar a mi lista</a>
                    </div>
                </div>
                <div class="vtr__card">
                    <div class="vtr__card__image">
                        <img loading="lazy" src="./assets/images/img5.png" alt="imagen">
                        <div class="type">
                            <img loading="lazy" src="./assets/images/play-spotify.svg" alt="imagen">
                        </div>
                    </div>
                    <div class="vtr__card__info">
                        <div class="vtr__card__info__top">
                            <h2 class="title text-center">Taonoces Rojos</h2>
                           <div class="follo-popu">
                               <div class="followers">
                                   <span class="number">1.450.000</span>
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
                                   <span class="text">Popularidad</span>
                               </div>
                           </div>
                        </div>
                    </div>
                    <div class="vtr__card__bottom">
                        <a href="#" class="button">Agregar a mi lista</a>
                    </div>
                </div>
                <div class="vtr__card">
                    <div class="vtr__card__image">
                        <img loading="lazy" src="./assets/images/img2.png" alt="imagen">
                        <div class="type">
                            <img loading="lazy" src="./assets/images/play-spotify.svg" alt="imagen">
                        </div>
                    </div>
                    <div class="vtr__card__info">
                        <div class="vtr__card__info__top">
                            <h2 class="title text-center">Taonoces Rojos</h2>
                           <div class="follo-popu">
                               <div class="followers">
                                   <span class="number">1.450.000</span>
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
                                   <span class="text">Popularidad</span>
                               </div>
                           </div>
                        </div>
                    </div>
                    <div class="vtr__card__bottom">
                        <a href="#" class="button">Agregar a mi lista</a>
                    </div>
                </div>
                <div class="vtr__card">
                    <div class="vtr__card__image">
                        <img loading="lazy" src="./assets/images/img8.jpg" alt="imagen">
                        <div class="type">
                            <img loading="lazy" src="./assets/images/play-spotify.svg" alt="imagen">
                        </div>
                    </div>
                    <div class="vtr__card__info">
                        <div class="vtr__card__info__top">
                            <h2 class="title text-center">Taonoces Rojos</h2>
                           <div class="follo-popu">
                               <div class="followers">
                                   <span class="number">1.450.000</span>
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
                                   <span class="text">Popularidad</span>
                               </div>
                           </div>
                        </div>
                    </div>
                    <div class="vtr__card__bottom">
                        <a href="#" class="button">Agregar a mi lista</a>
                    </div>
                </div>
                <div class="vtr__card">
                    <div class="vtr__card__image">
                        <img loading="lazy" src="./assets/images/img7.jpg" alt="imagen">
                        <div class="type">
                            <img loading="lazy" src="./assets/images/play-spotify.svg" alt="imagen">
                        </div>
                    </div>
                    <div class="vtr__card__info">
                        <div class="vtr__card__info__top">
                            <h2 class="title text-center">Taonoces Rojos</h2>
                           <div class="follo-popu">
                               <div class="followers">
                                   <span class="number">1.450.000</span>
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
                                   <span class="text">Popularidad</span>
                               </div>
                           </div>
                        </div>
                    </div>
                    <div class="vtr__card__bottom">
                        <a href="#" class="button">Agregar a mi lista</a>
                    </div>
                </div>
                <div class="vtr__card">
                    <div class="vtr__card__image">
                        <img loading="lazy" src="./assets/images/img6.png" alt="imagen">
                        <div class="type">
                            <img loading="lazy" src="./assets/images/play-spotify.svg" alt="imagen">
                        </div>
                    </div>
                    <div class="vtr__card__info">
                        <div class="vtr__card__info__top">
                            <h2 class="title text-center">Taonoces Rojos</h2>
                           <div class="follo-popu">
                               <div class="followers">
                                   <span class="number">1.450.000</span>
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
                                   <span class="text">Popularidad</span>
                               </div>
                           </div>
                        </div>
                    </div>
                    <div class="vtr__card__bottom">
                        <a href="#" class="button">Agregar a mi lista</a>
                    </div>
                </div>
                <div class="vtr__card">
                    <div class="vtr__card__image">
                        <img loading="lazy" src="./assets/images/img5.png" alt="imagen">
                        <div class="type">
                            <img loading="lazy" src="./assets/images/play-spotify.svg" alt="imagen">
                        </div>
                    </div>
                    <div class="vtr__card__info">
                        <div class="vtr__card__info__top">
                            <h2 class="title text-center">Taonoces Rojos</h2>
                           <div class="follo-popu">
                               <div class="followers">
                                   <span class="number">1.450.000</span>
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
                                   <span class="text">Popularidad</span>
                               </div>
                           </div>
                        </div>
                    </div>
                    <div class="vtr__card__bottom">
                        <a href="#" class="button">Agregar a mi lista</a>
                    </div>
                </div>
                <div class="vtr__card">
                    <div class="vtr__card__image">
                        <img loading="lazy" src="./assets/images/img2.png" alt="imagen">
                        <div class="type">
                            <img loading="lazy" src="./assets/images/play-spotify.svg" alt="imagen">
                        </div>
                    </div>
                    <div class="vtr__card__info">
                        <div class="vtr__card__info__top">
                            <h2 class="title text-center">Taonoces Rojos</h2>
                           <div class="follo-popu">
                               <div class="followers">
                                   <span class="number">1.450.000</span>
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
                                   <span class="text">Popularidad</span>
                               </div>
                           </div>
                        </div>
                    </div>
                    <div class="vtr__card__bottom">
                        <a href="#" class="button">Agregar a mi lista</a>
                    </div>
                </div>-->
            </div>
        </div>
    </section>
    <section class="vtr__instagram padding-top padding-bottom">
        <div class="vtr__container">
            <h2>Instagram</h2>
            <script src="https://apps.elfsight.com/p/platform.js" defer></script>
            <div class="elfsight-app-199c6011-c594-45f2-b081-9107b41a8355"></div>
            <!--
            <div class="vtr__grid vtr__grid-gap-20 vtr__grid-col-4">
                <a href="#" class="item">
                    <img loading="lazy" src="./assets/images/instagram1.jpg" alt="imagen">
                    <div class="actions">
                        <div class="actions__like">
                            <img loading="lazy" src="./assets/images/corazon.svg" alt="imagen">
                            <span class="number">20</span>
                        </div>
                        <div class="actions__comment">
                            <img loading="lazy" src="./assets/images/comentario.svg" alt="imagen">
                            <span class="number">100</span>
                        </div>
                    </div>
                </a>
                <a href="#" class="item">
                    <img loading="lazy" src="./assets/images/instagram2.jpg" alt="imagen">
                    <div class="actions">
                        <div class="actions__like">
                            <img loading="lazy" src="./assets/images/corazon.svg" alt="imagen">
                            <span class="number">20</span>
                        </div>
                        <div class="actions__comment">
                            <img loading="lazy" src="./assets/images/comentario.svg" alt="imagen">
                            <span class="number">100</span>
                        </div>
                    </div>
                </a>
                <a href="#" class="item">
                    <img loading="lazy" src="./assets/images/instagram3.jpg" alt="imagen">
                    <div class="actions">
                        <div class="actions__like">
                            <img loading="lazy" src="./assets/images/corazon.svg" alt="imagen">
                            <span class="number">20</span>
                        </div>
                        <div class="actions__comment">
                            <img loading="lazy" src="./assets/images/comentario.svg" alt="imagen">
                            <span class="number">100</span>
                        </div>
                    </div>
                </a>
                <a href="#" class="item">
                    <img loading="lazy" src="./assets/images/instagram4.jpg" alt="imagen">
                    <div class="actions">
                        <div class="actions__like">
                            <img loading="lazy" src="./assets/images/corazon.svg" alt="imagen">
                            <span class="number">20</span>
                        </div>
                        <div class="actions__comment">
                            <img loading="lazy" src="./assets/images/comentario.svg" alt="imagen">
                            <span class="number">100</span>
                        </div>
                    </div>
                </a>
                <a href="#" class="item">
                    <img loading="lazy" src="./assets/images/instagram5.jpg" alt="imagen">
                    <div class="actions">
                        <div class="actions__like">
                            <img loading="lazy" src="./assets/images/corazon.svg" alt="imagen">
                            <span class="number">20</span>
                        </div>
                        <div class="actions__comment">
                            <img loading="lazy" src="./assets/images/comentario.svg" alt="imagen">
                            <span class="number">100</span>
                        </div>
                    </div>
                </a>
                <a href="#" class="item">
                    <img loading="lazy" src="./assets/images/instagram6.jpg" alt="imagen">
                    <div class="actions">
                        <div class="actions__like">
                            <img loading="lazy" src="./assets/images/corazon.svg" alt="imagen">
                            <span class="number">20</span>
                        </div>
                        <div class="actions__comment">
                            <img loading="lazy" src="./assets/images/comentario.svg" alt="imagen">
                            <span class="number">100</span>
                        </div>
                    </div>
                </a>
                <a href="#" class="item">
                    <img loading="lazy" src="./assets/images/instagram7.jpg" alt="imagen">
                    <div class="actions">
                        <div class="actions__like">
                            <img loading="lazy" src="./assets/images/corazon.svg" alt="imagen">
                            <span class="number">20</span>
                        </div>
                        <div class="actions__comment">
                            <img loading="lazy" src="./assets/images/comentario.svg" alt="imagen">
                            <span class="number">100</span>
                        </div>
                    </div>
                </a>
                <a href="#" class="item">
                    <img loading="lazy" src="./assets/images/instagram8.jpg" alt="imagen">
                    <div class="actions">
                        <div class="actions__like">
                            <img loading="lazy" src="./assets/images/corazon.svg" alt="imagen">
                            <span class="number">20</span>
                        </div>
                        <div class="actions__comment">
                            <img loading="lazy" src="./assets/images/comentario.svg" alt="imagen">
                            <span class="number">100</span>
                        </div>
                    </div>
                </a>
            </div>
            -->
        </div>
    </section>
    <section class="vtr__contact padding-top padding-bottom">
        <div class="vtr__container">
            <div class="content">
                <h2>Contáctanos</h2>
                <p>Completa el siguiente formulario para realizar tu consulta</p>
                <form id="form_user">
                    <input name="artist_id" id="artist_id" type="hidden" value="<?php echo $alias ?>"
                           placeholder="Nombre y apellidos">
                    <div class="input">
                        <input name="name" id="name" type="text" placeholder="Nombre y apellidos">
                        <span id="name_error" class="error_message"></span>
                    </div>
                    <div class="input">
                        <input name="email" id="email" type="email" placeholder="Correo">
                        <span id="email_error" class="error_message"></span>
                    </div>
                    <div class="input">
                        <input name="telephone" id="telephone" type="text" placeholder="Teléfono">
                        <span id="telephone_error" class="error_message"></span>
                    </div>
                    <div class="input">
                        <textarea name="message" id="message" placeholder="Mensaje"></textarea>
                    </div>
                    <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
                    <div class="input">

                        <span id="recaptcha_error" class="error_message"></span>
                    </div>
                    <button type="submit">Enviar</button>
                </form>
            </div>
        </div>
    </section>
    <!--darle la clase open-->
    <div id="register_user" class="vtr__modal">
        <button class="vtr__modal__close">
            <img loading="lazy" src="./assets/images/close.svg" alt="imagen">
        </button>
        <div class="vtr__modal__container">
            <h2>¡Gracias!</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste voluptatem sit consequatur provident quos
                alias rerum, quas ipsam nostrum eligendi molestiae blanditiis quam quis harum cupiditate? Ipsa
                consequatur voluptate natus.</p>
        </div>
    </div>
</main>
<footer class="vtr__footer">
    <div class="vtr__container">
        <div class="vtr__grid vtr__grid-gap-20 vtr__grid-col-6">
            <div class="vtr__item">
                <h4>Sitios</h4>
                <ul>
                    <?php foreach ($dataSites as $item):
                        ?>
                        <li>
                            <a href="<?php echo $item->url[0]; ?>" target="_blank"><?php echo $item->post->post_title; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!--
            <div class="vtr__item">
                <h4>Ed Sheeran</h4>
                <ul>
                    <li><a href="#">Enlace 1</a></li>
                    <li><a href="#">Enlace 2</a></li>
                    <li><a href="#">Enlace 3</a></li>
                    <li><a href="#">Enlace 4</a></li>
                </ul>
            </div>
            <div class="vtr__item">
                <h4>Ed Sheeran</h4>
                <ul>
                    <li><a href="#">Enlace 1</a></li>
                    <li><a href="#">Enlace 2</a></li>
                    <li><a href="#">Enlace 3</a></li>
                    <li><a href="#">Enlace 4</a></li>
                </ul>
            </div>
            <div class="vtr__item">
                <h4>Ed Sheeran</h4>
                <ul>
                    <li><a href="#">Enlace 1</a></li>
                    <li><a href="#">Enlace 2</a></li>
                    <li><a href="#">Enlace 3</a></li>
                    <li><a href="#">Enlace 4</a></li>
                </ul>
            </div>
            <div class="vtr__item">
                <h4>Ed Sheeran</h4>
                <ul>
                    <li><a href="#">Enlace 1</a></li>
                    <li><a href="#">Enlace 2</a></li>
                    <li><a href="#">Enlace 3</a></li>
                    <li><a href="#">Enlace 4</a></li>
                </ul>
            </div>
            <div class="vtr__item">
                <h4>Ed Sheeran</h4>
                <ul>
                    <li><a href="#">Enlace 1</a></li>
                    <li><a href="#">Enlace 2</a></li>
                    <li><a href="#">Enlace 3</a></li>
                    <li><a href="#">Enlace 4</a></li>
                </ul>cluding versions of Lorem Ipsum.
            </div>
            -->
        </div>
        <div class="vtr__footer__bottom">
            <p>© <?php echo date("Y"); ?> Derechos reservados</p>
            <ul>
                <li>
                    <a href="#" target="_blank">
                        <img loading="lazy" src="./assets/images/facebook.svg" alt="imagen">
                    </a>
                </li>
                <li>
                    <a href="#" target="_blank">
                        <img loading="lazy" src="./assets/images/twitter.svg" alt="imagen">
                    </a>
                </li>
                <li>
                    <a href="#" target="_blank">
                        <img loading="lazy" src="./assets/images/linkedin.svg" alt="imagen">
                    </a>
                </li>
                <li>
                    <a href="#" target="_blank">
                        <img loading="lazy" src="./assets/images/whatsapp.svg" alt="imagen">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</footer>
<script src="assets/js/script.js"></script>
<?php if ( is_null($dataYoutube) ) : ?>
<script src="assets/js/ytb.js"></script>
<?php endif; ?>

<?php if ( is_null($dataSpotify) ) : ?>
<script src="assets/js/spt.js"></script>
<?php endif; ?>

<?php if ( is_null($dataRanking ) ) : ?>
<script src="assets/js/spt_ranking.js"></script>
<?php endif; ?>

<?php if ( is_null($dataTrend) ) : ?>
<script src="assets/js/spt_trend.js"></script>
<?php endif; ?>

<?php if ( is_null($dataArtistWeek) ) : ?>
<!--<script src="assets/js/spt_item_artist.js"></script>-->
<?php endif; ?>

<script src="assets/js/follow.js"></script>
<script src="assets/js/home.js"></script>
<script>


    const buttonPlay =  document.querySelector( '.vtr__video__controls .control-play' );
    const buttonVolume =  document.querySelector( '.vtr__video__controls .control-volume' );

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        const image =  document.querySelector( '.play-image' );
        const play = buttonPlay.getAttribute('data-play');
        buttonPlay.classList.remove('isPlay');
        image.setAttribute( 'src', play );
    }

    var tag = document.createElement('script');
    var video_youtube_id = document.getElementById('video_youtube_id').value;
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var player;

    buttonPlay.addEventListener('click', function (event) {

        const image =  document.querySelector( '.play-image' );
        //$(this).toggleClass( 'isPlay' );

        const pause = this.getAttribute('data-pause');
        const play = this.getAttribute('data-play');

        if ( buttonPlay.classList.contains('isPlay') ) {
            buttonPlay.classList.remove('isPlay');
            image.setAttribute( 'src', play );
            player.pauseVideo();
        } else {
            buttonPlay.classList.add('isPlay');
            image.setAttribute( 'src', pause );
            player.playVideo();
        }

    });

    buttonVolume.addEventListener('click', function (event) {
        //player.pauseVideo()
    });


    buttonVolume.addEventListener('click', function (event) {
        const mute = this.getAttribute('data-mute');
        const image = document.querySelector( '.volume-image' );
        const volume = this.getAttribute('data-volume');

        //$(this).toggleClass( 'isVolume' );

        if ( $( this ).hasClass('isVolume') ) {
            this.classList.remove('isVolume');
            image.setAttribute( 'src', mute );
            player.unMute();
        } else {
            this.classList.add('isVolume');
            image.setAttribute( 'src', volume );
            player.mute()
        }
    });


    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
            height: '100%',
            width: '100%',
            videoId: video_youtube_id,
            playerVars: {'autoplay': 1, 'controls': 0, 'mute': 1, 'showinfo': 0, 'rel': 1},
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });

        window.playyt = player;
    }



    // 4. The API will call this function when the video player is ready.
    function onPlayerReady(event) {
        //event.target.playVideo();
        console.log("AUTOPLAY");
        //event.target.playVideo();
    }

    // 5. The API calls this function when the player's state changes.
    //    The function indicates that when playing a video (state=1),
    //    the player should play for six seconds and then stop.
    var done = false;

    function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
            //setTimeout(stopVideo, 6000);
            //done = true;
        }
    }

    function stopVideo() {
        player.stopVideo();
    }

    $(".search-link").on('click', function (event) {
        event.preventDefault();
        if (!!player.isMuted()) {
            player.unMute();
            $(".search-link b").html("UNMUTE");
        } else {
            player.mute();
            $(".search-link b").html("MUTE");
        }
    });
</script>
<script src='https://www.google.com/recaptcha/api.js' async defer></script>
<input id="url_form" type="hidden" value="<?php echo $urlSubmit; ?>">
</body>
</html>
