import { defineConfig } from 'vite';
import { resolve } from 'path';
import handlebars from 'vite-plugin-handlebars';

export default defineConfig({
  root: 'src',
  base: '/portfolio/',
  build: {
    outDir: '../dist',
    emptyOutDir: true,
    rollupOptions: {
      input: {
        index:   resolve(__dirname, "index.html"),
        contact: resolve(__dirname, "contact/index.html"),   // ← (1)で移した場合
        confirm: resolve(__dirname, "contact/confirm/index.html"),
        thanks:  resolve(__dirname, "contact/thanks/index.html"),
        about: resolve(__dirname, "about/index.html"),
        works: resolve(__dirname, "works/index.html"),
    },
  },
  server: {
    open: true,
  },
  publicDir: '../public',
  plugins: [
    handlebars({
      partialDirectory: resolve(__dirname, 'src/partials'),
      context(pagePath) {
        return {
          isTop: pagePath === '/index.html',
        };
      },
    }),
  ],
});