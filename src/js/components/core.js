window.$ = window.jQuery = require('jquery');
( function( $ ) {
    $( function() {
        const body = $( 'body' );
        const openMenu = $( '.vtr__header__hamburguer' );
        const menu = $( '.vtr__header__menu' );
        const header = $( '.vtr__header' );
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
    });
}( jQuery ) );
