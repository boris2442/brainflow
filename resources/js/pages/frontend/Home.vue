<template>
    <section class="bg-gradient-to-br from-indigo-50 to-emerald-50 dark:from-slate-900 dark:to-slate-800 py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-3xl mx-auto text-center">
    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-slate-900 dark:text-white mb-4">
      Vos idées méritent mieux qu’un bloc-notes oublié dans un tiroir.
    </h1>
    <p class="text-lg text-slate-600 dark:text-slate-300 mb-8 leading-relaxed">
      Capturez-les en marchant. Transformez-les en actions. Retenez-les pour toujours.<br />
      <span class="font-medium text-indigo-600 dark:text-indigo-400">Sans friction. Sans oubli.</span>
    </p>
    <div class="flex flex-col sm:flex-row justify-center gap-4">
      <button class="btn btn-primary px-6 py-3 text-lg">
        🎯 Essayer gratuitement
      </button>
      <button class="btn btn-outline px-6 py-3 text-lg">
        📹 Voir en 60s
      </button>
    </div>
    <div class="mt-10">
      <!-- Mockup mobile animé (léger) -->
      <div class="bg-slate-100 dark:bg-slate-700 rounded-3xl w-64 h-96 mx-auto shadow-xl relative overflow-hidden">
        <div class="absolute inset-0 flex flex-col">
          <div class="bg-white dark:bg-slate-800 flex-1 p-4">
            <div class="flex items-center justify-between mb-4">
              <div class="w-8 h-8 rounded-full bg-indigo-500"></div>
              <div class="flex space-x-2">
                <div class="w-10 h-6 bg-emerald-500 rounded"></div>
                <div class="w-10 h-6 bg-amber-500 rounded"></div>
              </div>
            </div>
            <div class="space-y-3">
              <div class="bg-white dark:bg-slate-700 rounded-xl p-3 border border-slate-200 dark:border-slate-600">
                <div class="h-4 bg-slate-200 dark:bg-slate-600 rounded w-3/4 mb-2"></div>
                <div class="h-3 bg-slate-100 dark:bg-slate-500 rounded w-1/2"></div>
              </div>
              <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-xl p-3 border border-emerald-200 dark:border-emerald-800">
                <div class="h-4 bg-emerald-500 rounded w-1/2 mb-2"></div>
                <div class="h-3 bg-emerald-400 rounded w-3/4"></div>
              </div>
            </div>
          </div>
          <div class="h-16 bg-white dark:bg-slate-800 flex justify-around items-center">
            <div class="text-indigo-600 dark:text-indigo-400">💡</div>
            <div class="bg-indigo-600 text-white w-12 h-12 rounded-full flex items-center justify-center text-xl">+</div>
            <div>🧠</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</template>
