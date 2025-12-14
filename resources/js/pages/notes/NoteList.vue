<script setup>
import { defineProps, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
// Icône pour la conversion
import { ListTodoIcon } from 'lucide-vue-next'; 

const props = defineProps({
    notes: Array,
});

// Étant donné que la logique de soumission est unique pour chaque note,
// nous devons créer une fonction qui prend la note en paramètre.

const convertToTask = (note) => {
    // Créer un formulaire Inertia temporaire pour l'envoi
    const convertForm = useForm({
        title: note.content,
        note_id: note.id,
    });
    
    // Soumission du formulaire
    convertForm.post(route('tasks.store'), {
        preserveScroll: true,
        // Après la soumission réussie, Inertia rechargera les props du Dashboard
        // (y compris la liste des notes) qui sera alors mise à jour.
        onSuccess: () => {
            // Optionnel : ajouter un petit message de succès local
        },
        onError: (errors) => {
            console.error("Erreur de conversion en tâche:", errors);
        },
    });
};

// Fonction pour déterminer les classes CSS pour mettre en évidence les notes non traitées
const getItemClass = (note) => {
    return note.is_processed 
        ? 'bg-white border-l-4 border-gray-200' 
        : 'bg-yellow-50 border-l-4 border-yellow-400 shadow-md'; // Mise en évidence
};
</script>

<template>
    <div class="space-y-4">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">Notes à Traiter</h2>
        
        <div v-for="note in notes" :key="note.id">
            <div 
                :class="getItemClass(note)" 
                class="p-4 mb-3 rounded-lg flex justify-between items-start transition-all"
            >
                <div class="flex-grow">
                    <p class="text-sm text-gray-800 whitespace-pre-wrap">{{ note.content }}</p>
                    <div class="text-xs text-gray-500 mt-1">
                        Capturée le : {{ new Date(note.created_at).toLocaleDateString() }}
                    </div>
                </div>

                <button
                    v-if="!note.is_processed"
                    @click="convertToTask(note)"
                    class="ml-4 flex-shrink-0 p-2 text-white rounded-full bg-blue-500 hover:bg-blue-600 transition-colors"
                    title="Convertir en tâche"
                    :disabled="form && form.processing"
                >
                    <ListTodoIcon class="w-5 h-5" />
                </button>
                
                <span v-else class="text-xs text-green-500 ml-4">Traité</span>
            </div>
        </div>
        
        <p v-if="notes.length === 0" class="text-gray-500 italic">
            Aucune idée en attente de traitement.
        </p>
    </div>
</template>
