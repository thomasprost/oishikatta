const path = require('path')
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const dev = process.env.NODE_ENV === "dev";

let cssLoaders = [
            {loader: 'css-loader', options: { importLoaders: 1, minimize: !dev}}
        ]

if(!dev){
    cssLoaders.push({
            loader: 'postcss-loader',
            options: {
                plugins: (loader) => [
                    require('autoprefixer')({
                        browsers: ['last 2 versions', 'ie > 8']
                    }),
                    require('cssnano')
                ]
            }
        })
}

let config = {
    entry : ['./web/scss/main.scss', './web/js/app.js'],
    watch: dev,
    output: {
        path: path.resolve('./web/dist'),
        filename: 'bundle.js'
    },
    devtool: dev ? "cheap-module-eval-source-map" : false,
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: ['babel-loader']
            },
            {
                test: /\.css$/,
                use: ExtractTextPlugin.extract({
                    fallback: "style-loader",
                    use: cssLoaders
                })
            },
            {
                test: /\.scss$/,
                use: ExtractTextPlugin.extract({
                    fallback: "style-loader",
                    use: [...cssLoaders, 'sass-loader']
                })
            },
            {
                test: /\.(png|jpg|gif|svg)$/,
                use: [
                    {
                        loader: 'url-loader',
                        options: {
                            limit: 8192,
                            name: 'images/[name].[hash:7].[ext]'
                        }
                    }
                ]
            }
        ]
    },
    plugins: [
        new ExtractTextPlugin({
            filename: '[name].css',
            disable: false
        }),
    ]
}

if(!dev){
    config.plugins.push(new UglifyJSPlugin({
        sourceMap: false
    }))
}

module.exports = config;