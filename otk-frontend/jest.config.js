module.exports = {
  preset: '@vue/cli-plugin-unit-jest/presets/typescript-and-babel',
  verbose: true,
  moduleFileExtensions: ["js","ts", "json", "vue"],
  transform: {
    '^.+\\.[tj]sx?$': 'ts-jest',
    '^.+.vue$': '@vue/vue3-jest',
  },
  //transformIgnorePatterns: [`/node_modules/(?!${esModules})/(.*)`],
  transformIgnorePatterns: [`/node_modules/node_modules/vue-spinner/src/ClipLoader.vue`],
  allowJs: true 
}
