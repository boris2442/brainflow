<template>

  <div class="p-6 max-w-lg mx-auto bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Mes Idées</h1>

    <!-- Formulaire création -->
    <form @submit.prevent="submitIdea" class="mb-6">
      <input
        v-model="nouvelleTitre"
        type="text"
        placeholder="Titre de l'idée"
        class="border rounded p-2 w-full mb-2"
        required
      />
      <textarea
        v-model="nouvelleDescription"
        placeholder="Description (optionnelle)"
        class="border rounded p-2 w-full mb-2"
      ></textarea>
      <button
        type="submit"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
      >
        Ajouter
      </button>
    </form>

    <!-- Liste des idées -->
    <ul>
      <li
        v-for="idea in ideas"
        :key="idea.id"
        class="flex justify-between items-center mb-3 p-3 border rounded hover:shadow transition cursor-pointer"
        @click="goToDetail(idea.id)"
      >
        <div>
          <span class="font-medium">{{ idea.titre }}</span>
          <p class="text-gray-500 text-sm">{{ idea.description }}</p>
        </div>
      </li>
    </ul>
  </div>
  
</template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
  props: {
    ideas: Array,
  },
  data() {
    return {
      nouvelleTitre: '',
      nouvelleDescription: '',
    };
  },
  methods: {
    submitIdea() {
      if (!this.nouvelleTitre) return;
      Inertia.post('/ideas', {
        titre: this.nouvelleTitre,
        description: this.nouvelleDescription,
      }).then(() => {
        this.nouvelleTitre = '';
        this.nouvelleDescription = '';
        this.reload();
      });
    },
    goToDetail(id) {
      Inertia.visit(`/ideas/${id}`);
    },
    reload() {
      Inertia.reload({ only: ['ideas'] });
    },
  },
};
</script>
