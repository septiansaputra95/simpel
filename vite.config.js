import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/keuangan/honordokter.js',
                'resources/js/bpjs/antrianonline.js',
                'resources/js/bpjs/tasklist.js',
                'resources/js/bpjs/updatetask.js',
                'resources/js/master/masterdokter.js'
            ],
            refresh: true,
        }),
    ],
});
