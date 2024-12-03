<template>
    <ion-header>
      <ion-toolbar>
        <ion-title>Login</ion-title>
      </ion-toolbar>
    </ion-header>
  
    <ion-content>
      <form @submit.prevent="login">
        <ion-item>
          <ion-label position="floating">Username</ion-label>
          <ion-input v-model="username" type="text" required></ion-input>
        </ion-item>
        <ion-item>
          <ion-label position="floating">Password</ion-label>
          <ion-input v-model="password" type="password" required></ion-input>
        </ion-item>
        <ion-button expand="full" type="submit">Login</ion-button>
      </form>
    </ion-content>
  </template>
  
  <script>
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  import axios from 'axios';
  
  export default {
    setup() {
      const username = ref('');
      const password = ref('');
      const router = useRouter();
  
      const login = async () => {
        try {
          const response = await axios.post('http://your-laravel-api-url/api/login', {
            username: username.value,
            password: password.value,
          });
  
          console.log(response.data);
          // Simpan token atau informasi pengguna jika diperlukan
          router.push('/home'); // Ganti dengan halaman tujuan setelah login
        } catch (error) {
          console.error('Login failed', error);
          alert('Login failed: ' + error.response.data.message);
        }
      };
  
      return {
        username,
        password,
        login,
      };
    },
  };
  </script>
  
  <style scoped>
  /* Tambahkan gaya jika diperlukan */
  </style>