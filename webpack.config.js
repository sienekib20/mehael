// webpack.config.js
const path = require('path');

module.exports = {
  mode: 'development', // ou 'production'
  entry: './resources/js/app.js',  // Entry point of your application
  output: {
    filename: 'app.js',  // Output bundle file
    path: path.resolve(__dirname, 'public/assets/js'),  // Output directory
  },
};