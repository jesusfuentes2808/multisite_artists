window.$ = window.jQuery = require('jquery');
( function( $ ) {
    $( function() {
        const body = $( 'body' );
        const openMenu = $( '.vtr__header__hamburguer' );
        const menu = $( '.vtr__header__menu' );
        const header = $( '.vtr__header' );
        const buttonPlay = $( '.vtr__video__controls .control-play' );
        const buttonVolume = $( '.vtr__video__controls .control-volume' );

        $( '.js-scroll' ).on( 'click', function() {
            var $this = $( this );
            var linkHref = $this.attr( 'id' );
            $( 'html, body' ).animate({
                scrollTop: $( linkHref ).offset().top
            }, 800 );
            return false;
        });
        openMenu.on( 'click', function( e ) {
            body.toggleClass( 'mb-scroll' );
            $(this).toggleClass( 'active' );
            menu.toggleClass( 'active' );
            header.toggleClass( 'active' );
        });

        buttonPlay.on( 'click', function( e ) {
            const pause = $(this).attr('data-pause');
            const play = $(this).attr('data-play');
            const image = $( '.play-image' );
            $(this).toggleClass( 'isPlay' );

            if ( $( this ).hasClass('isPlay') ) {
                image.attr( 'src', pause );
            } else {
                image.attr( 'src', play );
            }
        });

        buttonVolume.on( 'click', function( e ) {
            const mute = $(this).attr('data-mute');
            const volume = $(this).attr('data-volume');
            const image = $( '.volume-image' );
            $(this).toggleClass( 'isVolume' );

            if ( $( this ).hasClass('isVolume') ) {
                image.attr( 'src', mute );
            } else {
                image.attr( 'src', volume );
            }
        });
    });
}( jQuery ) );
