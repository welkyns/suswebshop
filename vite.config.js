import { defineConfig } from 'vite';
import { copy } from 'fs-extra';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            /* busca archivo app.js y compila en public/backend/js con el mismo nombre*/
            input: 'resources/js/app.js', // Ruta de entrada
            output: 'public/backend/js',   // Ruta de salida
        }),
    ],

    plugins: [
        {
          name: 'custom-copy-plugin',
          buildStart() {
            copy('resources/js/app.js', 'public/backend/js/app.js', (err) => {
              if (err) {
                console.error('Error al copiar el archivo app.js:', err);
              } else {
                console.log('Archivo app.js copiado con éxito.');
              }
            });
            /*copy('resources/frontend', 'public/frontend', (err) => {
              if (err) {
                console.error('Error al copiar la carpeta:', err);
              } else {
                console.log('Carpeta copiada con éxito.');
              }
            });
            copy('resources/backend', 'public/backend', (err) => {
                if (err) {
                  console.error('Error al copiar la carpeta:', err);
                } else {
                  console.log('Carpeta copiada con éxito.');
                }
              });*/
          },
        },
    ],
});
