let mix = require('laravel-mix');

mix.setPublicPath('./assets');
mix.js('src/js/script.js', 'js');
mix.sass('src/scss/style.scss', 'css').options({
	processCssUrls: false,
	autoprefixer: {
		grid: true
	}
});

mix.disableNotifications();
