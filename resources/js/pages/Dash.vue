<template>
  <div class="p-6 max-w-4xl mx-auto space-y-8">
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

    <!-- KPI Tâches -->
    <div class="p-4 bg-white rounded shadow">
      <h2 class="text-xl font-bold mb-2">Tâches</h2>
      <DoughnutChart :chart-data="tasksChartData" />
      <p class="mt-2">Progression : {{ kpi.tasks.completionRate }}%</p>
    </div>

    <!-- Graphique Idées -->
    <div class="p-4 bg-white rounded shadow">
      <h2 class="text-xl font-bold mb-2">Idées (7 derniers jours)</h2>
      <LineChart :chart-data="ideasChartData" />
      <p>Total idées : {{ kpi.ideas.total }}</p>
    </div>

    <!-- Graphique Notes -->
    <div class="p-4 bg-white rounded shadow">
      <h2 class="text-xl font-bold mb-2">Notes (7 derniers jours)</h2>
      <LineChart :chart-data="notesChartData" />
      <p>Total notes : {{ kpi.notes.total }}</p>
    </div>
  </div>
</template>

<script>
import { Doughnut, Line } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement
} from 'chart.js';

ChartJS.register(
  Title, Tooltip, Legend, ArcElement,
  CategoryScale, LinearScale, PointElement, LineElement
);

export default {
  props: ['kpi'],
  components: {
    DoughnutChart: Doughnut,
    LineChart: Line
  },
  computed: {
    tasksChartData() {
      return {
        labels: ['Terminées', 'Non terminées'],
        datasets: [{
          label: 'Tâches',
          data: [this.kpi.tasks.completed, this.kpi.tasks.pending],
          backgroundColor: ['#3b82f6', '#f87171'],
        }]
      }
    },
    ideasChartData() {
      return {
        labels: Object.keys(this.kpi.ideas.perDay),
        datasets: [{
          label: 'Idées',
          data: Object.values(this.kpi.ideas.perDay),
          borderColor: '#fbbf24',
          backgroundColor: 'rgba(251,191,36,0.2)',
          fill: true,
          tension: 0.4,
        }]
      }
    },
    notesChartData() {
      return {
        labels: Object.keys(this.kpi.notes.perDay),
        datasets: [{
          label: 'Notes',
          data: Object.values(this.kpi.notes.perDay),
          borderColor: '#3b82f6',
          backgroundColor: 'rgba(59,130,246,0.2)',
          fill: true,
          tension: 0.4,
        }]
      }
    },
  }
};
</script>
