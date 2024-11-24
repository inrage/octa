// https://tailwindcss.com/docs/configuration
import type { Config } from 'tailwindcss';
import forms from '@tailwindcss/forms';

export default {
  content: [
    './app/**/*.php',
    './resources/**/*.{php,js,ts,tsx,vue}',
    './resources/views/**/*.php',
    './public/content/themes/octa/index.php',
  ],
  theme: {},
  plugins: [
    forms,
  ],
} satisfies Config;
