<template>
  <div>
    <BarChart v-if="type === 'bar'" :chart-data="chartData" :chart-options="chartOptions" />
    <LineChart v-if="type === 'line'" :chart-data="chartData" :chart-options="chartOptions" />
    <PieChart v-if="type === 'pie'" :chart-data="chartData" :chart-options="chartOptions" />
    <DoughnutChart v-if="type === 'doughnut'" :chart-data="chartData" :chart-options="chartOptions" />
  </div>
</template>

<script>
import { defineComponent } from "vue";
import {
  BarChart,
  LineChart,
  PieChart,
  DoughnutChart
} from "vue-chart-3";
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, ArcElement, LineElement, CategoryScale, LinearScale, PointElement } from "chart.js";

// Register Chart.js components globally
ChartJS.register(Title, Tooltip, Legend, BarElement, ArcElement, LineElement, CategoryScale, LinearScale, PointElement);

export default defineComponent({
  components: { BarChart, LineChart, PieChart, DoughnutChart },
  props: {
    type: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      chartData: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [
          {
            label: "Dataset Example",
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: ["red", "blue", "yellow", "green", "purple", "orange"]
          }
        ]
      },
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false
      }
    };
  }
});
</script>
