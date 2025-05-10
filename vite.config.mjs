// import { defineConfig } from 'vite';
// import symfonyPlugin from 'vite-plugin-symfony';
// import tailwindcssVite from '@tailwindcss/vite';
// import path from 'path';

// export default defineConfig({
//   plugins: [
//     symfonyPlugin(),
//     tailwindcssVite()
//   ],
//   build: {
//     manifest: true,
//     outDir: 'public/build',
//     rollupOptions: {
//       input: {
//         app: path.resolve(__dirname, 'assets/app.js'),
//       }
//     }
//   }
// });
import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'
export default defineConfig({
  plugins: [
    tailwindcss(),
  ],
})