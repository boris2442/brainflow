<template>
  <div class="p-6 max-w-lg mx-auto bg-white rounded shadow">
    <!-- Titre et état -->
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">{{ task.titre }}</h1>
      <span
        :class="task.est_terminee ? 'text-green-500 font-semibold' : 'text-red-500 font-semibold'"
        class="text-sm"
      >
        {{ task.est_terminee ? 'Terminée ✅' : 'Non terminée ❌' }}
      </span>
    </div>

    <!-- Description -->
    <p class="text-gray-700 mb-4">{{ task.description || 'Aucune description' }}</p>

    <!-- Date et heure de création -->
    <p class="text-sm text-gray-500 mb-6">
      Créée le {{ formatDate(task.created_at) }} à {{ formatTime(task.created_at) }}
    </p>

    <!-- Actions -->
    <div class="flex gap-3">
      <!-- Edit icon -->
      <button @click="editTask" class="flex items-center gap-1 bg-yellow-400 px-4 py-2 rounded text-white hover:bg-yellow-500 transition">
        <i class="lucide-edit"></i> Éditer
      </button>

      <!-- Delete icon -->
      <button @click="deleteTask" class="flex items-center gap-1 bg-red-500 px-4 py-2 rounded text-white hover:bg-red-600 transition">
        <i class="lucide-trash-2"></i> Supprimer
      </button>
    </div>
  </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
// Assure-toi d'avoir installé Lucide Vue : npm install lucide-vue-next
import { Edit, Trash2 } from 'lucide-vue-next';

export default {
  props: {
    task: Object,
  },
  components: {
    'lucide-edit': Edit,
    'lucide-trash-2': Trash2,
  },
  methods: {
    formatDate(date) {
      return new Date(date).toLocaleDateString();
    },
    formatTime(date) {
      return new Date(date).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    },
    editTask() {
      const nouveauTitre = prompt('Modifier le titre', this.task.titre);
      const nouvelleDescription = prompt('Modifier la description', this.task.description);
      if (nouveauTitre !== null) {
        Inertia.patch(`/tasks/${this.task.id}`, { titre: nouveauTitre, description: nouvelleDescription });
      }
    },
    deleteTask() {
      if (confirm('Voulez-vous vraiment supprimer cette tâche ?')) {
        Inertia.delete(`/tasks/${this.task.id}`);
      }
    },
  },
};
</script>

<style scoped>
/* Optionnel : style supplémentaire pour Lucide ou hover effects */
</style>
