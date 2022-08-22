const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  theme: {
    extend: {
      colors: {
        green: {
          50: "#f1f9f0",
          100: "#e4f3e1",
          200: "#c9e7c4",
          300: "#a5d79c",
          400: "#67bb58",
          500: "#4b983e",
          600: "#3c7a32",
          700: "#356b2b",
          800: "#2a5422",
          900: "#22451c",
          main: "#57B148"
        },
        "fa-primary": "#57B148",
        "fa-secondary": "#FACC14",
        "input-bg": "#EDEDED",
        card: "#F1F1F1"
      },
      fontFamily: {
        sans: ["Lato", ...defaultTheme.fontFamily.sans],
      },
      letterSpacing: {
        "most-widest": "0.15em",
      },
      lineHeight: {
        15: "60px",
      },
    },
  },
  plugins: [],
};
