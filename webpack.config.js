module.exports = (env, option) => ({
    mode: 'development',
    entry: ['babel-polyfill', './resources/src/index.jsx'],
    output: {
        filename: './public/js/app.js',
        path: __dirname,
    },
    resolve: {
        extensions: ['.js', '.jsx']
    },
    devtool: option.mode === 'development' ? 'source-map' : false,
    module: {
        rules: [
          {
            test: /\.m?js$/,
            exclude: /node_modules/,
            use: {
              loader: 'babel-loader',
              options: {
                presets: ['@babel/preset-env']
              }
            }
          },
          {
            test: /\.jsx$/,
            exclude: /node_modules/,
            use: {
              loader: "babel-loader",
              options: {
                presets: ['@babel/preset-react']
              }
            }
          },
          {
            test: /\.css$/,
            use: ['style-loader', 'css-loader'],
          }
        ]
      },
    // plugins: [new EncodingPlugin({
    //     encoding: 'Windows-1251',
    // })],
})