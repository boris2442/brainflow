<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
//import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];



</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
           
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
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
  
            </div>
        </div>
    </AppLayout>
</template>
