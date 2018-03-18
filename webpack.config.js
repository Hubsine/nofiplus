var Encore = require('@symfony/webpack-encore');
var webpack = require('webpack');

Encore

        // the project directory where all compiled assets will be stored
        .setOutputPath('web/build/')
        // the public path used by the web server to access the previous directory
        .setPublicPath('/build')
        
        .addEntry('functions',  './assets/js/functions.js')
        .addEntry('global-js',  './assets/js/global.js')
        .addEntry('offre',      './assets/js/pages/offre.js')
        .addEntry('order',      './assets/js/pages/order.js')

//        .configureBabel(function(babelConfig) {
//            
//            // add additional presets
//            babelConfig.presets.push('es2015');
//
//        })
    
        .createSharedEntry('vendor', [
            'jquery',
            'jquery-ui-bundle',
            './node_modules/jquery-ui-bundle/jquery-ui.min.css',
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
//        .addLoader(
//        {
//            test: require.resolve('tinymce/tinymce'),
//            use: [{
//                loader: 'imports?this=>window'
//                    //'exports?window.tinymce'
//            }]
//        }
//        )
//        .addLoader({
//            test: /tinymce\/(themes|plugins)\//,
//            use: [{
//                loader: 'imports?this=>window'
//            }]
//        }  )
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