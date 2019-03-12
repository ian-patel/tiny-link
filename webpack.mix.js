/* eslint import/no-extraneous-dependencies: ["off"] */
const path = require('path');
const mix = require('laravel-mix');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'js')
  // .sass('resources/sass/app.scss', 'css/')
  .less('resources/less/app.less', 'css/', {
    javascriptEnabled: true,
  })
  .extract([
    'vue',
    'vuex',
    'axios',
    'lodash',
    'ant-design-vue',
    // 'element-ui',
    'vue-router',
  ])
  .sourceMaps()
  .setResourceRoot()
  .webpackConfig({
    output: {
      path: path.resolve(Mix.isUsing('hmr') ? '/' : 'public/'),
      filename: '[name].js',
      chunkFilename: 'js/chunks/[name].js?id=[chunkhash]',
      publicPath: Mix.isUsing('hmr') ? ('http://localhost:8080/') : '/',
    },
    resolve: {
      alias: {
        styles: path.resolve(__dirname, 'resources/less'),
        App: path.resolve(__dirname, 'resources/js'),
        svg: path.resolve(__dirname, 'resources/svg'),
      },
    },
    plugins: mix.inProduction() ? [
      new BundleAnalyzerPlugin({ analyzerMode: 'static' }),
    ] : [],
  });

if (mix.inProduction()) {
  mix.version();
}
