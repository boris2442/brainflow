<script setup>
import { defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue'; 
import { PlusIcon } from 'lucide-vue-next'; 

const props = defineProps({
    learnings: Array,
});

// Formulaire de saisie pour une nouvelle connaissance
const form = useForm({
    title: '',
    content: '',
    source_url: '',
    topic: '',
});

const submitLearning = () => {
    form.post(route('learnings.store'), {
        onSuccess: () => {
            form.reset(); // Réinitialise le formulaire après succès
        },
        onError: (errors) => {
            console.error("Erreur lors de l'enregistrement de l'apprentissage:", errors);
        }
    });
};
</script>

<template>
    <AppLayout title="Connaissances">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold mb-6 text-gray-800">Votre Base de Connaissances</h1>
                
                <div class="bg-white p-6 shadow-xl sm:rounded-lg mb-8">
                    <form @submit.prevent="submitLearning" class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <PlusIcon class="w-5 h-5 text-blue-500" />
                            <h3 class="text-xl font-semibold">Ajouter une nouvelle connaissance</h3>
                        </div>

                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Titre/Concept</label>
                            <input type="text" v-model="form.title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="topic" class="block text-sm font-medium text-gray-700">Sujet/Thème</label>
                                <input type="text" v-model="form.topic" id="topic" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="source_url" class="block text-sm font-medium text-gray-700">Source (URL)</label>
                                <input type="url" v-model="form.source_url" id="source_url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <div v-if="form.errors.source_url" class="text-red-500 text-sm mt-1">{{ form.errors.source_url }}</div>
                            </div>
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700">Ce que j'ai appris/Résumé</label>
                            <textarea v-model="form.content" id="content" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                            <div v-if="form.errors.content" class="text-red-500 text-sm mt-1">{{ form.errors.content }}</div>
                        </div>

                        <button type="submit" :disabled="form.processing" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                            Enregistrer la Connaissance
                        </button>
                    </form>
                </div>

                <div class="bg-white p-6 shadow-xl sm:rounded-lg">
                    <h3 class="text-2xl font-semibold mb-4 border-b pb-2">Connaissances à Réviser</h3>
                    
                    <div v-if="learnings.length > 0" class="space-y-4">
                        <div v-for="learning in learnings" :key="learning.id" class="p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex justify-between items-center">
                                <h4 class="text-lg font-bold text-blue-700">{{ learning.title }}</h4>
                                <span class="text-xs px-2 py-0.5 rounded-full" :class="{'bg-red-100 text-red-800': new Date(learning.next_review_at) <= new Date(), 'bg-green-100 text-green-800': new Date(learning.next_review_at) > new Date()}">
                                    Révision : {{ new Date(learning.next_review_at).toLocaleDateString() }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ learning.content.substring(0, 150) }}...</p>
                            <a v-if="learning.source_url" :href="learning.source_url" target="_blank" class="text-xs text-blue-500 hover:underline mt-1 block">
                                Source
                            </a>
                        </div>
                    </div>
                    <p v-else class="text-gray-500 italic">Aucune connaissance enregistrée. Commencez par en ajouter une !</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
