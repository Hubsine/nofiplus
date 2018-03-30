var Encore = require('@symfony/webpack-encore');
var webpack = require('webpack');

Encore

        // the project directory where all compiled assets will be stored
        .setOutputPath('web/build/')
        // the public path used by the web server to access the previous directory
        .setPublicPath('/build')

        .addEntry('functions', './assets/js/functions.js')
        .addEntry('global-js', './assets/js/global.js')
        .addEntry('offre', './assets/js/pages/offre.js')
        .addEntry('front_offre', './assets/js/pages/front_offre.js')
        .addEntry('order', './assets/js/pages/order.js')

        .createSharedEntry('vendor', [
            'jquery',
            'jquery-ui-bundle',
            './node_modules/jquery-ui-bundle/jquery-ui.min.css',
            'popper.js',
            './vendor/twbs/bootstrap/dist/js/bootstrap.min.js',
            './assets/js/main.js',
            './assets/js/jquery.collection.js',
            'holderjs'
        ])

        .addPlugin(
                new webpack.ProvidePlugin({
                    'Holder': 'holderjs',
                    'holder': 'holderjs',
                    'window.Holder': 'holderjs'
                }), 10)
        ////
        // Image Webpack Loader
        /////
        .addLoader({
            test: /\.(png|svg|jpg|gif)$/,
            use: [
                //'file-loader',
                //'url-loader',
                {
                    loader: 'image-webpack-loader',
                    options:
                            {
                                bypassOnDebug: true,
                                //outputPath: 'images/'
//                                mozjpeg: {
//                                    progressive: false,
//                                    quality: 65
//                                },
//                                // optipng.enabled: false will disable optipng
//                                optipng: {
//                                    enabled: false,
//                                },
//                                pngquant: {
//                                    quality: '65-90',
//                                    speed: 4
//                                },
//                                gifsicle: {
//                                    interlaced: false,
//                                },
//                                // the webp option will enable WEBP
//                                webp: {
//                                    enabled: false,
//                                    quality: 75
//                                }
                            }
                }]
        })
        // allow sass/scss files to be processed
        .enableSassLoader()
        //.autoProvidejQuery()

        .cleanupOutputBeforeBuild()
        // show OS notifications when builds finish/fail
        .enableBuildNotifications()

        .autoProvidejQuery()

        .enableSourceMaps(!Encore.isProduction())
        ;

module.exports = Encore.getWebpackConfig();