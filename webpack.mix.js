const mix = require('laravel-mix');
const syncRequest = require('sync-request');
const open = require('open');

//Config
const ngrokUrl = 'http://trends.au.ngrok.io';
const browserSyncConfig = {
	proxy: 'localhost',
	files: [
		'application/views/**/*.php',
		'application/views/*.php',
		'public/**/*.css',
		'public/**/*.js',
		'TGP-Admin/**/*.js',
		'TGP-Admin/**/*.css',
		'TGP-Admin/**/*.php'
	]
};

//Init
mix.setPublicPath('./');

//Copy files in production
if(mix.inProduction())
{
	mix.version();
}

//Sass
mix.sass('resources/scss/main.scss', 'public/css/main.css');

//JS

//Browsersync
switch (syncRequest('GET', ngrokUrl).statusCode)
{
	//Local
	case 404:

		mix.browserSync({
			ghostMode: false,
			...browserSyncConfig
		});
		break;


	//Ngrok
	default:

		mix.browserSync({
			open: false,
			ghostMode: false,
			socket: {
				domain: ngrokUrl
			},
			callbacks: {
				ready: () => { open(ngrokUrl); }
			},
			...browserSyncConfig
		});
}
