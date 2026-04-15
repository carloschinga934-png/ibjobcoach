import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  
  resolve: {
    alias: {
      '@': '/resources',
      '@img': '/resources/images',
    },
  },

  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/css/auth/dashboard/material-dashboard.css',
        'resources/scss/dashboard/material-dashboard.scss',
        'resources/js/app.js',           
        'resources/js/demo/demo.js',
      ],
      refresh: true,
    }),
    tailwindcss(),
  ],
});
