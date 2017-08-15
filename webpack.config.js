const path = require('path')

module.exports = {
    entry : './web/js/app.js',
    output: {
        path: path.resolve('./web/dist'),
        filename: 'bundle.js'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: ['babel-loader']
            }
        ]
    }
}