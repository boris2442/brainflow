<template>
  <div class="p-6 max-w-lg mx-auto bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Mes Notes</h1>

    <!-- Formulaire création -->
    <form @submit.prevent="submitNote" class="mb-6">
      <input
        v-model="nouveauTitre"
        type="text"
        placeholder="Titre de la note"
        class="border rounded p-2 w-full mb-2"
        required
      />
      <textarea
        v-model="nouveauContenu"
        placeholder="Contenu (optionnel)"
        class="border rounded p-2 w-full mb-2"
      ></textarea>
      <button
        type="submit"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
      >
        Ajouter
      </button>
    </form>

    <!-- Liste des notes -->
    <ul>
      <li
        v-for="note in notes"
        :key="note.id"
        class="flex flex-col mb-3 p-3 border rounded hover:shadow transition cursor-pointer"
        @click="goToDetail(note.id)"
      >
        <span class="font-medium">{{ note.titre }}</span>
        <p class="text-gray-500 text-sm line-clamp-2">{{ note.contenu }}</p>
      </li>
    </ul>
  </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
  props: {
    notes: Array,
  },
  data() {
    return {
      nouveauTitre: '',
      nouveauContenu: '',
    };
  },
  methods: {
    submitNote() {
      if (!this.nouveauTitre) return;
      Inertia.post('/notes', {
        titre: this.nouveauTitre,
        contenu: this.nouveauContenu,
      }).then(() => {
        this.nouveauTitre = '';
        this.nouveauContenu = '';
        this.reload();
      });
    },
    goToDetail(id) {
      Inertia.visit(`/notes/${id}`);
    },
    reload() {
      Inertia.reload({ only: ['notes'] });
    },
  },
};
</script>
