<template>
  <div>
    <h2>Escape Game</h2>
    <p>Résolvez les énigmes pour gagner !</p>

    <div v-if="!gameOver">
      <p>⏳ Temps restant : {{ timeLeft }}s</p>
      <p>Énigme : {{ currentQuestion.text }}</p>

      <div>
        <button 
          v-for="option in currentQuestion.options" 
          :key="option" 
          @click="checkAnswer(option)">
          {{ option }}
        </button>
      </div>

      <p v-if="feedback">{{ feedback }}</p>
    </div>

    <div v-else>
      <h3>Bravo ! 🎉</h3>
      <p>Votre score : {{ score }}</p>
      <button @click="saveScore">Sauvegarder le score</button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';

const questionsData = [
  { text: "Quelle est la capitale de la France ?", answer: "Paris", options: ["Berlin", "Madrid", "Paris", "Londres"] },
  { text: "Combien font 2 + 2 ?", answer: "4", options: ["3", "4", "5", "6"] },
  { text: "Quelle couleur obtient-on en mélangeant bleu et jaune ?", answer: "Vert", options: ["Rouge", "Orange", "Vert", "Marron"] },
  { text: "Quel est le plus grand océan du monde ?", answer: "Pacifique", options: ["Atlantique", "Pacifique", "Indien", "Arctique"] },
  { text: "Quel est le nom de la plus grande montagne du monde ?", answer: "Everest", options: ["Mont Blanc", "Kilimandjaro", "Everest", "Mont Fuji"] },
  { text: "Qui a peint la Mona Lisa ?", answer: "Leonard de Vinci", options: ["Picasso", "Leonard de Vinci", "Van Gogh", "Monet"] },
  { text: "Quel est le plus grand pays du monde ?", answer: "Russie", options: ["Canada", "Chine", "Russie", "États-Unis"] },
  { text: "Quel animal est le plus grand mammifère terrestre ?", answer: "Éléphant", options: ["Girafe", "Éléphant", "Rhinocéros", "Bison"] },
  { text: "Combien de continents y a-t-il ?", answer: "7", options: ["5", "6", "7", "8"] },
  { text: "Qui a écrit 'Les Misérables' ?", answer: "Victor Hugo", options: ["Émile Zola", "Victor Hugo", "Marcel Proust", "Gustave Flaubert"] },
  { text: "Quelle est la devise de la France ?", answer: "Liberté, égalité, fraternité", options: ["Liberté, égalité, fraternité", "Unité et travail", "La liberté ou la mort", "Vive la république"] },
  { text: "Combien de joueurs y a-t-il dans une équipe de football ?", answer: "11", options: ["9", "10", "11", "12"] },
  { text: "Dans quel pays se trouve la pyramide de Gizeh ?", answer: "Égypte", options: ["Égypte", "Mexique", "Grèce", "Soudan"] },
  { text: "Quel est l'élément chimique dont le symbole est O ?", answer: "Oxygène", options: ["Oxygène", "Or", "Ozone", "Oxyde"] },
  { text: "Quel est l'organe principal du système circulatoire ?", answer: "Cœur", options: ["Poumon", "Cœur", "Rein", "Estomac"] },
  { text: "Quel est le plus grand fleuve d'Afrique ?", answer: "Nil", options: ["Nil", "Amazonie", "Mississippi", "Yangtsé"] },
  { text: "Quel est le premier président des États-Unis ?", answer: "George Washington", options: ["Abraham Lincoln", "Thomas Jefferson", "George Washington", "John Adams"] },
  { text: "Quelle est la langue officielle du Brésil ?", answer: "Portugais", options: ["Espagnol", "Portugais", "Français", "Anglais"] },
  { text: "Quel est l'instrument qui a 88 touches ?", answer: "Piano", options: ["Guitare", "Piano", "Violon", "Flûte"] },
  { text: "Dans quelle ville se trouve la Tour Eiffel ?", answer: "Paris", options: ["Paris", "Londres", "Rome", "Berlin"] },
  { text: "Quel est le pays d'origine du sushi ?", answer: "Japon", options: ["Chine", "Japon", "Corée", "Thaïlande"] }
];

const questions = ref([...questionsData.sort(() => 0.5 - Math.random())]); // Mélange des questions
const currentQuestionIndex = ref(0);
const currentQuestion = ref(questions.value[currentQuestionIndex.value]);
const feedback = ref('');
const score = ref(0);
const gameOver = ref(false);
const timeLeft = ref(15); // Temps en secondes
let timer = null;

const startTimer = () => {
  timeLeft.value = 15; // Réinitialise le timer à 15 secondes
  clearInterval(timer);
  timer = setInterval(() => {
    if (timeLeft.value > 0) {
      timeLeft.value--;
    } else {
      nextQuestion(); // Passe automatiquement à la question suivante
    }
  }, 1000);
};

const checkAnswer = (selectedAnswer) => {
  clearInterval(timer); // Arrête le timer lorsque l'utilisateur répond

  if (selectedAnswer === currentQuestion.value.answer) {
    score.value += 10;
    feedback.value = "Bonne réponse ! 🎉";
  } else {
    feedback.value = "Mauvaise réponse... 😕";
  }

  setTimeout(nextQuestion, 1000); // Passe à la question suivante après un court délai
};

const nextQuestion = () => {
  feedback.value = '';
  
  if (currentQuestionIndex.value < questions.value.length - 1) {
    currentQuestionIndex.value++;
    currentQuestion.value = questions.value[currentQuestionIndex.value];
    startTimer(); // Relance le timer pour la nouvelle question
  } else {
    gameOver.value = true;
    clearInterval(timer);
  }
};

const saveScore = async () => {
  try {
    const userData = JSON.parse(localStorage.getItem('user'));
    if (!userData) return alert("Veuillez vous connecter.");

    const response = await axios.post('http://127.0.0.1/escape-game/backend/game/save_score.php', {
      user_id: userData.user_id,
      score: score.value
    });

    if (response.data.success) {
      alert("Score sauvegardé !");
    } else {
      alert("Erreur lors de la sauvegarde.");
    }
  } catch (error) {
    alert("Erreur de connexion au serveur.");
  }
};

onMounted(() => {
  startTimer();
});
</script>
