

## Installing vue js

npm install vue@^3 vue-loader@^17

## Update vite.config.js

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
});


## Edit my resources/js/app.js file

import { createApp } from 'vue';
import App from './App.vue';

createApp(App).mount('#app');


## Create a new App.vue file in resources/js

<template>
  <div id="app">
    <h1>Hello Vue 3!</h1>
  </div>
</template>

<script>
export default {
  name: "App",
};
</script>

<style>
/* Add your styles here */
</style>

## npm install
## npm run dev



