let mix = require('laravel-mix');

mix.webpackConfig({
	stats: {
		warningsFilter: ['filter', /filter/, (warning) => true],
	}
});

mix.setPublicPath('./assets');
mix.js('src/js/script.js', 'js');
mix.js('src/js/home.js', 'js');
mix.js('src/js/ytb.js', 'js');
mix.js('src/js/spt.js', 'js');
mix.js('src/js/follow.js', 'js');
mix.sass('src/scss/style.scss', 'css').options({
	processCssUrls: false,
	autoprefixer: {
		grid: true
	}
});

mix.disableNotifications();
