import { defineConfig } from 'vite';
import { resolve } from 'path';
import handlebars from 'vite-plugin-handlebars';

export default defineConfig({
  root: 'src',
  base: '/portfolio/',
  build: {
    outDir: '../dist',
    emptyOutDir: true,
  },
  server: {
    open: true,
  },
  publicDir: '../public',
  plugins: [
    handlebars({
      partialDirectory: resolve(__dirname, 'src/partials'),
    }),
  ],
});