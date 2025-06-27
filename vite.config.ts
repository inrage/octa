import { defineConfig } from "vite";
import tailwindcss from "@tailwindcss/vite";
import laravel from "laravel-vite-plugin";
import { wordpressPlugin, wordpressThemeJson } from "@roots/vite-plugin";

export default defineConfig({
  base: "/build/",
  plugins: [
    tailwindcss(),
    laravel({
      input: [
        "resources/css/app.css",
        "resources/js/app.ts",
        "resources/css/editor.css",
        "resources/js/editor.ts",
      ],
      refresh: true,
    }),

    wordpressPlugin(),

    // Generate the theme.json file in the public/build/assets directory
    // based on the Tailwind config and the theme.json file from base theme folder
    wordpressThemeJson({
      disableTailwindColors: false,
      disableTailwindFonts: false,
      disableTailwindFontSizes: false,
      baseThemeJsonPath: './theme.json',
    }),
  ],
  resolve: {
    alias: {
      "@scripts": "/resources/js",
      "@styles": "/resources/css",
      "@fonts": "/resources/fonts",
      "@images": "/resources/images",
    },
  },
});
