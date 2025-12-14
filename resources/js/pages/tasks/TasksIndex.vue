<template>
  <div class="p-6 max-w-lg mx-auto bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Mes Tâches</h1>

    <!-- Formulaire rapide -->
    <form @submit.prevent="submitTask" class="mb-6">
      <input
        v-model="nouvelleTache"
        type="text"
        placeholder="Nouvelle tâche..."
        class="border rounded p-2 w-full mb-2"
        required
      />
      <textarea
        v-model="nouvelleDescription"
        placeholder="Description (optionnel)"
        class="border rounded p-2 w-full mb-2"
      ></textarea>
      <button
        type="submit"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
      >
        Ajouter
      </button>
    </form>

    <!-- Liste des tâches -->
    <ul>
      <li
        v-for="task in tasks"
        :key="task.id"
        class="flex justify-between items-center mb-3 p-3 border rounded hover:shadow transition cursor-pointer"
      >
        <div class="flex flex-col" @click="goToDetail(task.id)">
          <span :class="{ 'line-through text-gray-400': task.est_terminee, 'font-medium': !task.est_terminee }">
            {{ task.titre }}
          </span>
          <span class="text-sm text-gray-500">
            {{ task.est_terminee ? '✅ Terminée' : '❌ Non terminée' }}
          </span>
        </div>

        <!-- Actions rapides -->
        <div class="flex gap-2">
          <button @click.stop="editTask(task)" class="text-yellow-500 hover:text-yellow-600">
            <lucide-edit class="w-5 h-5" />
          </button>
          <button @click.stop="deleteTask(task.id)" class="text-red-500 hover:text-red-600">
            <lucide-trash-2 class="w-5 h-5" />
          </button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import { Edit, Trash2 } from 'lucide-vue-next';

export default {
  props: {
    tasks: Array,
  },
  components: {
    'lucide-edit': Edit,
    'lucide-trash-2': Trash2,
  },
  data() {
    return {
      nouvelleTache: '',
      nouvelleDescription: '',
    };
  },
  methods: {
    submitTask() {
      if (!this.nouvelleTache) return;
      Inertia.post('/tasks', {
        titre: this.nouvelleTache,
        description: this.nouvelleDescription,
      }).then(() => {
        this.nouvelleTache = '';
        this.nouvelleDescription = '';
        this.reload();
      });
    },
    reload() {
      Inertia.reload({ only: ['tasks'] });
    },
    goToDetail(taskId) {
      Inertia.visit(`/tasks/${taskId}`);
    },
    editTask(task) {
      const nouveauTitre = prompt('Modifier le titre', task.titre);
      const nouvelleDescription = prompt('Modifier la description', task.description);
      if (nouveauTitre !== null) {
        Inertia.patch(`/tasks/${task.id}`, { titre: nouveauTitre, description: nouvelleDescription });
      }
    },
    deleteTask(taskId) {
      if (confirm('Voulez-vous vraiment supprimer cette tâche ?')) {
        Inertia.delete(`/tasks/${taskId}`).then(() => this.reload());
      }
    },
  },
};
</script>

<style scoped>
/* Hover léger pour la liste */
li:hover {
  background-color: #f9fafb;
}
</style>
