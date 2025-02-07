<template>
    <div>
      <h2>Bienvenue, {{ username }}</h2>
      <button @click="logout">Déconnexion</button>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        username: "",
      };
    },
    async created() {
      try {
        const response = await axios.get("http://127.0.0.1/escape-game/backend/auth/get_user.php");
        if (response.data.success) {
          this.username = response.data.username;
        } else {
          this.$router.push("/login");
        }
      } catch {
        this.$router.push("/login");
      }
    },
    methods: {
      async logout() {
        await axios.get("http://127.0.0.1/escape-game/backend/auth/logout.php");
        this.$router.push("/login");
      },
    },
  };
  </script>
  