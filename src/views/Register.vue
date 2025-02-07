<template>
    <div>
      <h2>Inscription</h2>
      <form @submit.prevent="register">
        <input type="text" v-model="username" placeholder="Nom d'utilisateur" required />
        <input type="email" v-model="email" placeholder="Email" required />
        <input type="password" v-model="password" placeholder="Mot de passe" required />
        <button type="submit">S'inscrire</button>
      </form>
      <p v-if="message">{{ message }}</p>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        username: "",
        email: "",
        password: "",
        message: "",
      };
    },
    methods: {
      async register() {
        try {
          const response = await axios.post("http://127.0.0.1/escape-game/backend/auth/register.php", {
            username: this.username,
            email: this.email,
            password: this.password,
          });
  
          this.message = response.data.message;
          if (response.data.success) {
            this.$router.push("/login");
          }
        } catch (error) {
          this.message = "Erreur de connexion au serveur.";
        }
      },
    },
  };
  </script>
  