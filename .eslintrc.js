const path = require("path");

module.exports = {
  root: true,
  parser: "babel-eslint",
  extends: "eslint-config-airbnb",
  env: {
    browser: true
  },
  rules: {
    // Allow vuex mutations to change state props directly
    "no-param-reassign": [
      "error",
      { props: true, ignorePropertyModificationsFor: ["state"] }
    ]
  },
  parserOptions: {
    // Allow async and await
    ecmaVersion: 7,
  },
  settings: {
    "import/resolver": {
      webpack: {
        config: {
          resolve: {
            alias: {
              app: path.resolve(__dirname, 'resources/js'),
            }
          }
        }
      }
    }
  }
};
