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
        index:   resolve(__dirname, 'src/index.html'),
      contact: resolve(__dirname, 'src/contact/index.html'),
      confirm: resolve(__dirname, 'src/contact/confirm/index.html'),
      thanks:  resolve(__dirname, 'src/contact/thanks/index.html'),
      about:   resolve(__dirname, 'src/about/index.html'),
      works:   resolve(__dirname, 'src/works/index.html'),
      single:  resolve(__dirname, 'src/single/index.html'),
      },
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