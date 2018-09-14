var path = require('path');
module.exports = {
  entry: ['react-jsonschema-form', './json_schema_field.js'],
  output: {
    path: __dirname,
    filename: 'json_schema_field.bundle.js'
  },
  module: {
    rules: [
      {
        test: /\.js?$/,
        loader: "babel-loader",
        exclude: '/node_modules/'
      },
      {
        test: /\.css$/,
        loader: "style!css",
      }
    ]
  }
};
