let mix = require('laravel-mix');

mix.webpackConfig({
	stats: {
		warningsFilter: ['filter', /filter/, (warning) => true],
	}
});

mix.setPublicPath('./assets');
mix.js('src/js/script.js', 'js');
mix.sass('src/scss/style.scss', 'css').options({
	processCssUrls: false,
	autoprefixer: {
		grid: true
	}
});

mix.disableNotifications();
