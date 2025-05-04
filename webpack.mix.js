const mix = require('laravel-mix');
const path = require('path');

mix.js('resources/js/app.js', 'public/js')
    .vue() // Habilita soporte para Vue
    .sass('resources/sass/app.scss', 'public/css') // Opcional, si usas .scss
    .alias({
        '@': path.resolve('resources/js'),
    });
