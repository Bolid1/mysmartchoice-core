const path = require("path");

module.exports = {
  devServer: {
    host: "0.0.0.0",
  },
  resolve: {
    alias: {
      "@": path.resolve("resources/js"),
    },
  },
};
