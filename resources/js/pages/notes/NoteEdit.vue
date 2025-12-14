<template>
  <div class="p-6 max-w-lg mx-auto bg-white rounded shadow">
    <!-- Titre -->
    <h1 class="text-2xl font-bold mb-2">{{ note.titre }}</h1>

    <!-- Contenu -->
    <p class="text-gray-700 mb-4">{{ note.contenu || 'Aucun contenu' }}</p>

    <!-- Date et heure de création -->
    <p class="text-sm text-gray-500 mb-6">
      Créée le {{ formatDate(note.created_at) }} à {{ formatTime(note.created_at) }}
    </p>

    <!-- Action : Éditer -->
    <button @click="editNote"
            class="flex items-center gap-1 bg-yellow-400 px-4 py-2 rounded text-white hover:bg-yellow-500 transition">
      <lucide-edit class="w-5 h-5" /> Éditer
    </button>
  </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import { Edit } from 'lucide-vue-next';

export default {
  props: {
    note: Object,
  },
  components: {
    'lucide-edit': Edit,
  },
  methods: {
    formatDate(date) {
      return new Date(date).toLocaleDateString();
    },
    formatTime(date) {
      return new Date(date).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    },
    editNote() {
      const nouveauTitre = prompt('Modifier le titre', this.note.titre);
      const nouveauContenu = prompt('Modifier le contenu', this.note.contenu);
      if (nouveauTitre !== null) {
        Inertia.patch(`/notes/${this.note.id}`, {
          titre: nouveauTitre,
          contenu: nouveauContenu,
        });
      }
    },
  },
};
</script>

<style scoped>
/* Optionnel : hover léger ou transitions pour le bouton */
</style>
