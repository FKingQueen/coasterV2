module.exports = {
    devServer: {
        proxy: {
            '/geoserver': {
                target: 'http://localhost:3655',
                changeOrigin: true,
                pathRewrite: { '^/geoserver': '' }
            }
        }
    }
};
