<script setup>
import { defineProps, ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
// Importez vos icônes (lucide-vue-next)
// --- MICICON RETIRÉ ---
import { SendIcon, ListTodoIcon, Trash2Icon } from 'lucide-vue-next'; 

// ... (PROPS et Formulaire useForm restent inchangés)
// --- 1. PROPS (Données initiales de Laravel) ---
const props = defineProps({
    notes: Array,
});

// --- 2. LOGIQUE DU FORMULAIRE DE CAPTURE (Formulaire Flottant) ---
const form = useForm({
    content: '',
});

// Logique du Bouton Dynamique (Micro ou Envoi)
// --- SIMPLIFIÉ : N'importe quel contenu est prêt à être envoyé. ---
const isTyping = computed(() => form.content.trim().length > 0);
// --- SIMPLIFIÉ : L'icône est TOUJOURS SendIcon ---
const buttonIcon = computed(() => SendIcon); // Supprime la logique conditionnelle

// Gestion de la Soumission de la Note
const submitNote = () => {
    // --- SIMPLIFIÉ : La vérification est suffisante, plus de `else` pour l'alerte vocale ---
    if (isTyping.value) {
        form.post(route('notes.store'), {
            preserveScroll: true, 
            onSuccess: () => {
                form.reset('content'); // Réinitialise le champ
            },
            onError: (errors) => {
                console.error('Erreur lors de l\'envoi:', errors);
            }
        });
    }
    // --- L'ancien 'else' avec l'alerte pour l'enregistrement vocal est RETIRÉ ---
};

// ... (Le reste de la LOGIQUE reste inchangé)
// --- 3. LOGIQUE DE CONVERSION EN TÂCHE (Anciennement NoteList/NoteItem) ---
// ... (convertToTask, processingNoteId, getItemClass, deleteNote restent inchangés)

</script>

<template>
    <AppLayout title="Dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="fixed bottom-0 left-0 right-0 p-4 bg-white border-t shadow-2xl z-10">
                    <form @submit.prevent="submitNote" class="flex items-end space-x-2">
                        <textarea
                            v-model="form.content"
                            style="min-height: 44px; max-height: 200px;" 
                            placeholder="Notez votre idée en marchant..."
                            class="flex-grow rounded-full border border-gray-300 resize-none p-3 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150"
                            @keydown.enter.exact.prevent="submitNote"
                        ></textarea>

                        <button
                            type="submit"
                            class="w-10 h-10 rounded-full flex items-center justify-center transition-colors duration-200"
                            :class="isTyping ? 'bg-blue-500 text-white hover:bg-blue-600' : 'bg-gray-200 text-gray-600 hover:bg-gray-300'"
                            :title="isTyping ? 'Envoyer la note' : 'Envoyer la note'" 
                            :disabled="form.processing || !isTyping" 
                            >
                            <component :is="buttonIcon" class="w-5 h-5" />
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
