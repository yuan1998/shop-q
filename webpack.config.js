const path = require('path')

module.exports = {
    resolve: {
        extensions: ['.js', '.json', '.vue'],
        alias: {
            '@': path.join(__dirname, './resources/js'),
            '@site1': path.join(__dirname, './resources/js/site1'),
            '@site2': path.join(__dirname, './resources/js/site2')
        }
    },
}
