<template>
    <div>
      <h2>Classement des joueurs</h2>
      <table>
        <thead>
          <tr>
            <th>Joueur</th>
            <th>Score</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="player in players" :key="player.id">
            <td>{{ player.username }}</td>
            <td>{{ player.score }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  
  const players = ref([]);
  
  const fetchScores = async () => {
    try {
      const response = await axios.get('http://127.0.0.1/escape-game/backend/game/get_scores.php');
      players.value = response.data.scores;
    } catch (error) {
      console.error("Erreur de chargement des scores", error);
    }
  };
  
  onMounted(fetchScores);
  </script>
  