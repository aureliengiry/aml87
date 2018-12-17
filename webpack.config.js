// webpack.config.js
var Encore = require('@symfony/webpack-encore');

Encore
    // directory where all compiled assets will be stored
    .setOutputPath('public/build/')

    // what's the public path to this directory (relative to your project's document root dir)
    .setPublicPath('/build')

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // will output as web/build/app.js
    .addEntry('app', './assets/js/app.js')
    .addEntry('members-area', './assets/js/members-area.js')

    // will output as web/build/main.css
    //.addStyleEntry('main-css', './assets/css/app.sass')
    .addStyleEntry('membersarea', './assets/css/members-area.sass')

    // allow sass/scss files to be processed
    // .enableSassLoader(function(sassOptions) {}, {
    //     resolve_url_loader: false
    // })
    .enableSassLoader()

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    .enableSourceMaps(!Encore.isProduction())

// create hashed filenames (e.g. app.abc123.css)
// .enableVersioning()
;

// export the final configuration
module.exports = Encore.getWebpackConfig();
