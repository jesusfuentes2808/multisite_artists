<?php
require('./backend/helper.php');
require('./backend/request.php');
require('./backend/youtube.php');
require('./backend/spotify.php');

$url = URL;
$alias = ALIAS;
$urlJson = URL_JSON;
$urlMain = URL_MAIN;

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

        $discord  = '';
        if(isset($data->field_custom->discord)){
            $discord = $data->field_custom->discord[0];
            $discord = trim($discord);
        }


        $instagram  = '';
        if(isset($data->field_custom->instagram)){
            $instagram = $data->field_custom->instagram[0];
            $instagram = trim($instagram);
        }


        $getResponse1  = '';
        if(isset($data->field_custom->getresponse_url_1)){
            $getResponse1 = $data->field_custom->getresponse_url_1[0];
            $getResponse1 = trim($getResponse1);
        }

        $getResponse2  = '';
        if(isset($data->field_custom->getresponse_url_2)){
            $getResponse2 = $data->field_custom->getresponse_url_2[0];
            $getResponse2 = trim($getResponse2);
        }

        $telegram  = '#';
        if(isset($data->field_custom->telegram_url)){
            $telegram = $data->field_custom->telegram_url[0];
            $telegram = trim($telegram);
        }

        $gtm = '';
        if(isset($data->field_custom->gtm)){
            $gtm = $data->field_custom->gtm[0];
            $gtm = trim($gtm);
        }

        // COLOR
        $seccion_1 = '';
        if(isset($data->field_custom->seccion_1)) {
            $seccion_1 = $data->field_custom->seccion_1[0];
            $seccion_1 = trim($seccion_1);
        }

        $seccion_2 = '';
        if(isset($data->field_custom->seccion_2)) {
            $seccion_2 = $data->field_custom->seccion_2[0];
            $seccion_2 = trim($seccion_2);
        }


        $seccion_3 = '';
        if(isset($data->field_custom->seccion_3)) {
            $seccion_3 = $data->field_custom->seccion_3[0];
            $seccion_3 = trim($seccion_3);
        }


        $seccion_4 = '';
        if(isset($data->field_custom->seccion_4)) {
            $seccion_4 = $data->field_custom->seccion_4[0];
            $seccion_4 = trim($seccion_4);
        }


        $seccion_5 = '';
        if(isset($data->field_custom->seccion_5)) {
            $seccion_5 = $data->field_custom->seccion_5[0];
            $seccion_5 = trim($seccion_5);
        }


        $seccion_6 = '';
        if(isset($data->field_custom->seccion_6)) {
            $seccion_6 = $data->field_custom->seccion_6[0];
            $seccion_6 = trim($seccion_6);
        }

        $seccion_7 = '';
        if(isset($data->field_custom->seccion_7)) {
            $seccion_7 = $data->field_custom->seccion_7[0];
            $seccion_7 = trim($seccion_7);
        }

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
    <link rel=”canonical” href=”https://nichmusic.com/”>
    <link rel="icon" type="image/png" sizes="144x144" href="./assets/images/favicon.png">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title><?php echo $title ?></title>
    <script>
        window.url = "<?php echo $url; ?>";
        window.urlJson = "<?php echo $urlJson; ?>";
        window.urlMain = "<?php echo $urlMain; ?>";
        window.alias = "<?php echo $alias; ?>";
        console.log(window.urlJson + "/" + window.alias + "/playlist_yt.json");
    </script>
    <?php
        if(!empty($gtm)):
    ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','<?php echo $gtm ?>');</script>
    <!-- End Google Tag Manager -->
    <?php
        endif;
    ?>
    <?php
    if(!empty($getResponse1) && !empty($getResponse2)):
        ?>
    <!-- GetResponse Analytics -->
    <script type="text/javascript">
        (function(i, s, o, g, r, a, m){
            i.grpr = '<?php echo $getResponse1; ?>';
            i['__GetResponseAnalyticsObject'] = r;
            i[r] = i[r] || function() {(i[r].q = i[r].q || []).push(arguments)};
            a = s.createElement(o);
            m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m);
        })(window, document, 'script', '<?php echo $getResponse2; ?>', 'GrTracking');

        // Creates a default GetResponse Tracker with automatic cookie domain configuration.
        GrTracking('setDomain', 'auto');

        // Sends a pageview hit from the tracker just created.
        // always load current window.location.href - usefull for single page applications
        GrTracking('push');
    </script>
    <!-- End GetResponse Analytics -->
    <?php endif; ?>
</head>
<body>
<?php
if(!empty($gtm)):
?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $gtm ?>"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php
endif;
?>
<input type="hidden" id="video_youtube_id" value="<?php echo $videoYoutubeId; ?>">

<main>
    <section class="vtr__video">
        <!--<iframe src="https://www.youtube.com/embed/ZhIsAZO5gl0?autoplay=1&mute=1&loop=1&controls=0"></iframe>-->
        <div id="player"></div>
        <div class="vtr__video__content" >
            <div class="logo">
                <!--<img loading="lazy" src="./assets/images/logo.svg" alt="Logo">-->
            </div>
            <a href="<?php echo $telegram ?>" target="_blank">
                <button class="vtr__button js-scroll" id="trend" style="background: #039be5;">Unete a la comunidad Telegram</button>
            </a>
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
        </div>

    </section>
    <section id="trend" class="vtr__trend bg-purple padding-top-35 padding-bottom"  style="<?php echo ($seccion_1 !== '')? 'background-color:'.$seccion_1 : '' ?>">
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
                <h2 class="vtr__title vtr__title--line"><span>Lo más reciente en Youtube</span></h2>
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
    <?php
    if($seccion_2):
        ?>
        <style>
            .vtr__bio:after{
                background: none;
                opacity: 1;
            }
        </style>
    <?php
    endif;
    ?>
    <section class="vtr__bio" style="<?php echo ($seccion_2 !== '')? 'position: sticky; background-color:'.$seccion_2 : '' ?>">
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
    <section class="vtr__trend bg-purple padding-top padding-bottom" style="<?php echo ($seccion_3 !== '')? 'background-color:'.$seccion_3 : '' ?>">
        <div class="vtr__container">
            <h2 class="vtr__title vtr__title--line"><span>Nuevos Lanzamientos en Spotify</span></h2>
            <div class="vtr__loading spt_content_content__loading">
                <img loading="lazy" src="./assets/images/loading.svg" alt="cargando">
            </div>
            <div id="spt_content" class="vtr__grid vtr__grid-gap-10 vtr__grid-col-5">
                <?php if( !empty($dataSpotify) ): ?>
                    <?php echo $htmlSpotify; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
    if(! empty($instagram) ):
    ?>
    <section class="vtr__instagram padding-top-35 padding-bottom" style="<?php echo ($seccion_4 !== '')? 'background-color:'.$seccion_4 : '' ?>">
        <div class="vtr__container">
            <!--<h2>Instagram</h2>-->
            <?php echo $instagram; ?>
        </div>
    </section>
    <?php
    endif;
    ?>


    <?php
    if(! empty($discord) ):
    ?>
    <section class="bg-purple padding-top padding-bottom" style="<?php echo ($seccion_5 !== '')? 'background-color:'.$seccion_5 : '' ?>">
        <div class="vtr__container">
            <div class="content">
                <?php echo $discord ?>
                <!--
                <iframe src="https://discord.com/widget?id=921063903612514354&theme=dark" width="350" height="500" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
                -->
            </div>
        </div>
    </section>
    <?php
    endif;
    ?>

    <?php
    if($seccion_6):
        ?>
    <style>
        .vtr__contact:after{
            background: none;
            opacity: 1;
        }
    </style>
    <?php
    endif;
    ?>
    <section class="vtr__contact padding-top padding-bottom" style="<?php echo ($seccion_6 !== '')? 'position: sticky; background-color:'.$seccion_6 : '' ?>">
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
                    <div class="g-recaptcha" data-sitekey="6LcHgKAeAAAAACGU9z4-Fr6dix-z47HcAWobdAAr"></div>
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
            <p>Gracias por visitar nuestra comunidad e inscribirte. Aquí encontraras las últimas novedades tu artista favorito. Pronto responderemos tu consulta.</p>
        </div>
    </div>
</main>
<footer class="vtr__footer" style="<?php echo ($seccion_7 !== '')? 'background-color:'.$seccion_7 : '' ?>">
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
    let isMobile = false;
    const widthDisplay = $(window).width();
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        const image =  document.querySelector( '.play-image' );
        const play = buttonPlay.getAttribute('data-play');
        buttonPlay.classList.remove('isPlay');
        image.setAttribute( 'src', play );
        isMobile = true;
    }

    if(isMobile){
        //$(".vtr__video .logo").css("display","none");
        //$(".vtr__video .vtr__button").css("display","none");
        //$(".vtr__video").css("height","auto");
        //$(".vtr__video").css("padding","20px 0");
        $(".vtr__video__content img").css("width","10.625rem");
        $(".vtr__video").css("background","black");
        $(".vtr__video").css("height",((widthDisplay/2) + 150) + 'px' );
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

        if(isMobile){
            $(".vtr__video .logo").css("display","none");
            $(".vtr__video .vtr__button").css("display","none");
            //$(".vtr__video").css("height","auto");
            //$(".vtr__video").css("padding","20px 0");
            $(".vtr__video").css("background","black");
            $(".vtr__video").css("height",((widthDisplay/2) + 150) + 'px' );
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
