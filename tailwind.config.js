module.exports = {
  content: [
    "./app/Views/**/*.php", // Semua view CodeIgniter
    "./resources/**/*.{php,html,js}", // Kalau ada folder resources
    "./*.php", // File PHP di root project
    "./**/*.html", // Jika ada file HTML
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};
