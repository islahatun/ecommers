<template>
  <v-container>
    <v-row>
        <v-chart :options="chartOptions" :data="chartData"/>
    </v-row>
  </v-container>
</template>

<script>
import { Pie, mixins } from 'vue-chartjs';
const { reactiveProp } = mixins;

export default {
  extends: Pie,
  mixins: [reactiveProp],
  data() {
    return {
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
      },
    };
  },
  mounted() {
    this.renderChart(this.chartData, this.chartOptions);
  },
};
</script>

