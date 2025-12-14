<template>
  <nav
    :class="[
      'fixed z-50 w-full bg-surface border-t border-border transition-all duration-300',
      isMobile
        ? 'bottom-0 left-0 py-2 px-4 flex justify-around items-center h-16'
        : 'top-0 right-0 py-4 px-6 flex items-center space-x-6 bg-opacity-90 backdrop-blur-sm'
    ]"
    role="navigation"
    aria-label="Navigation principale"
  >
    <!-- Bouton Thème -->
    <button
      @click="toggleTheme"
      class="flex flex-col items-center justify-center text-text-secondary hover:text-text transition"
      :aria-label="`Basculer en mode ${isDark ? 'clair' : 'sombre'}`"
    >
      <component
        :is="isDark ? SunIcon : MoonIcon"
        class="w-5 h-5"
      />
      <span v-if="!isMobile" class="text-xs mt-1">{{ isDark ? 'Clair' : 'Sombre' }}</span>
    </button>

    <!-- Auth : Anonyme -->
    <template v-if="!user">
      <button
        @click="openModal('register')"
        class="flex flex-col items-center justify-center text-text-secondary hover:text-primary transition"
        aria-label="S'inscrire"
      >
        <UserPlusIcon class="w-5 h-5" />
        <span v-if="!isMobile" class="text-xs mt-1">S’inscrire</span>
      </button>

      <button
        @click="openModal('login')"
        class="flex flex-col items-center justify-center text-text-secondary hover:text-primary transition"
        aria-label="Se connecter"
      >
        <LogInIcon class="w-5 h-5" />
        <span v-if="!isMobile" class="text-xs mt-1">Se connecter</span>
      </button>
    </template>

    <!-- Auth : Connecté -->
    <template v-else>
      <button
        @click="toggleProfileMenu"
        class="flex flex-col items-center justify-center relative"
        aria-label="Mon profil"
      >
        <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white text-sm font-medium">
          {{ user.name ? user.name.charAt(0).toUpperCase() : 'A' }}
        </div>
        <span v-if="!isMobile" class="text-xs mt-1">Profil</span>

        <!-- Menu déroulant (desktop uniquement) -->
        <div
          v-if="showProfileMenu && !isMobile"
          class="absolute top-full right-0 mt-2 w-48 bg-surface border border-border rounded-lg shadow-lg py-1 z-10"
        >
          <button
            @click="logout"
            class="block w-full text-left px-4 py-2 text-text-secondary hover:bg-slate-100 dark:hover:bg-slate-700"
          >
            🚪 Déconnexion
          </button>
          <button
            class="block w-full text-left px-4 py-2 text-text-secondary hover:bg-slate-100 dark:hover:bg-slate-700"
          >
            ⚙️ Paramètres
          </button>
        </div>
      </button>
    </template>
  </nav>

  <!-- Overlay pour fermer le menu mobile -->
  <div
    v-if="showProfileMenu && isMobile"
    class="fixed inset-0 z-40 bg-black bg-opacity-20"
    @click="showProfileMenu = false"
  ></div>

  <!-- Menu mobile (slide up) -->
  <div
    v-if="showProfileMenu && isMobile"
    class="fixed bottom-16 left-0 w-full bg-surface border-t border-border z-50 animate-fade-in"
  >
    <div class="py-4 flex flex-col items-center space-y-4">
      <button
        class="flex items-center space-x-3 px-6 py-3 w-full text-left hover:bg-slate-50 dark:hover:bg-slate-700"
      >
        <UserIcon class="w-5 h-5" />
        <span>Mon profil</span>
      </button>
      <button
        class="flex items-center space-x-3 px-6 py-3 w-full text-left hover:bg-slate-50 dark:hover:bg-slate-700"
      >
        <SettingsIcon class="w-5 h-5" />
        <span>Paramètres</span>
      </button>
      <button
        @click="logout"
        class="flex items-center space-x-3 px-6 py-3 w-full text-left text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20"
      >
        <LogOutIcon class="w-5 h-5" />
        <span>Déconnexion</span>
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import {
  SunIcon,
  MoonIcon,
  UserPlusIcon,
  LogInIcon,
  UserIcon,
  SettingsIcon,
  LogOutIcon
} from 'lucide-vue-next';

// État du thème
const isDark = ref(false);
const toggleTheme = () => {
  isDark.value = !isDark.value;
  document.documentElement.classList.toggle('dark', isDark.value);
  localStorage.theme = isDark.value ? 'dark' : 'light';
};

// Appliquer le thème sauvegardé
onMounted(() => {
  const savedTheme = localStorage.theme;
  if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    isDark.value = true;
    document.documentElement.classList.add('dark');
  }
});

// État mobile
const isMobile = computed(() => window.innerWidth <= 768);

// Auth mock (à remplacer par ton store/auth)
const user = ref(null); // ← à remplacer par `usePage().props.auth.user` si Inertia
// Exemple de mock connecté :
// user.value = { id: 1, name: 'Alex', email: 'a@example.com' };

// Gestion modale (mock — à brancher sur ton système)
const openModal = (type) => {
  alert(`Ouvrir modal : ${type}`);
  // → à remplacer par $modal.open(...) ou Inertia modal
};

// Menu profil
const showProfileMenu = ref(false);
const toggleProfileMenu = () => {
  showProfileMenu.value = !showProfileMenu.value;
};

const logout = () => {
  user.value = null;
  showProfileMenu.value = false;
  // → à brancher sur ton endpoint de logout
};

// Fermer menu si resize vers desktop
watch(isMobile, () => {
  if (!isMobile.value) showProfileMenu.value = false;
});
</script>

<style scoped>
/* Animation fade-in pour le menu mobile */
@keyframes fade-in {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fade-in 0.2s ease-out;
}
</style>
