import path from 'path'

import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'
import { defineConfig } from 'vite'

export default defineConfig({
  plugins: [
    laravel({
      input: 'resources/js/app.ts',
      ssr: 'resources/js/ssr.ts',
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
  ],
  preview: {
    host: true,
    port: 3000,
  },
  server: {
    host: true,
    port: 3000,
  },
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources/js'),
      '@Styles': path.resolve(__dirname, 'resources/css'),
      'ziggy-js': path.resolve(__dirname, 'vendor/tightenco/ziggy'),
    },
  },
})
