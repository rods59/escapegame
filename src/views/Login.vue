<template>
    <div class="login">
      <h2>Connexion</h2>
      <form @submit.prevent="login">
        <div>
          <label>Email :</label>
          <input type="email" v-model="email" required />
        </div>
        <div>
          <label>Mot de passe :</label>
          <input type="password" v-model="password" required />
        </div>
        <button type="submit">Se connecter</button>
      </form>
      <p v-if="message">{{ message }}</p>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  export default {
    data() {
      return {
        email: "",
        password: "",
        message: "",
      };
    },
    methods: {
  async login() {
    console.log("Tentative de connexion...");

    try {
      const response = await axios.post("http://127.0.0.1/escape-game/backend/auth/login.php", {
        email: this.email,
        password: this.password,
      });

      console.log("Réponse serveur :", response.data);
      this.message = response.data.message;

      if (response.data.success) {
        console.log("Connexion réussie ! Redirection en cours...");
        
        // Vérifie si Vue Router est bien accessible
        console.log("Vue Router :", this.$router);

        this.$router.push("/dashboard");
      }
    } catch (error) {
      console.error("Erreur Axios :", error);
      this.message = "Erreur de connexion au serveur.";
    }
  },
}
  };
  </script>
  
  <style scoped>
  .login {
    max-width: 300px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    text-align: center;
  }
  </style>
  