module.exports = {
  purge: {
    enabled: true,
    content: [
      "./dist/**/*.php",
      "./dist/*.php",
      "./dist/admin/**/*.php",
      "./dist/admin/*.php",
    ],
  },
};
