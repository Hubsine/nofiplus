var Encore = require('@symfony/webpack-encore');
var webpack = require('webpack');

Encore

        // the project directory where all compiled assets will be stored
        .setOutputPath('web/build/')
        // the public path used by the web server to access the previous directory
        .setPublicPath('/build')

        .createSharedEntry('vendor', [
            'jquery',
            'popper.js',
            './vendor/twbs/bootstrap/dist/js/bootstrap.min.js',
            './assets/js/main.js',
            './assets/js/jquery.collection.js',
            'tinymce',
            'holderjs'
        ])

        .addPlugin(
                new webpack.ProvidePlugin({
                    'Holder': 'holderjs',
                    'holder': 'holderjs',
                    'window.Holder': 'holderjs'
                }), 10)
         
        .addLoader({
            test: /\.(png|svg|jpg|gif)$/,
            use: [{
                loader: 'file-loader',
                options: {
                    name: 'images/[name].[ext]'
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
        ;

module.exports = Encore.getWebpackConfig();