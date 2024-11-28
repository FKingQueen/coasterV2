<template>
    <div id="windbarb-container" ref="chart"></div>
  </template>
  
  <script>
  import Highcharts from 'highcharts';
  import WindBarbModule from 'highcharts/modules/windbarb';
  
  // Initialize the WindBarb module
  WindBarbModule(Highcharts);
  
  export default {
    name: 'WindBarbChart',
    mounted() {
      this.renderChart();
    },
    methods: {
      renderChart() {
        const chartOptions1 = {
          chart: {
            renderTo: this.$refs.chart,
            backgroundColor: '#f7f7f7', // Light gray background
            style: {
              fontFamily: 'Arial, sans-serif', // Change the font
            },
          },
          credits: {
            text: '',
          },
          rangeSelector: {
            buttons: [
              { type: 'hour', count: 1, text: '1h' },
              { type: 'day', count: 1, text: '1d' },
              { type: 'week', count: 1, text: '1w' },
              { type: 'month', count: 1, text: '1m' },
              { type: 'year', count: 1, text: '1y' },
              { type: 'all', text: 'All' },
            ],
            selected: 1,
            inputEnabled: true,
          },
          title: {
            text: '',
            style: {
              color: '#333333', // Dark title text
              fontSize: '18px',
            },
          },
          subtitle: {
            text: '',
          },
          yAxis: {
            title: {
              text: '',
            },
          },
          series: [
            {
              type: 'windbarb',
              name: 'Wind Direction',
              data: [
                [Date.UTC(2024, 10, 28, 0, 0), 5, 90],
                [Date.UTC(2024, 10, 28, 1, 0), 7, 120],
                [Date.UTC(2024, 10, 28, 2, 0), 6, 180],
                [Date.UTC(2024, 10, 28, 3, 0), 4, 270],
              ], // Example data: [timestamp, speed, direction]
              color: 'white',
              lineWidth: 1.5,
              vectorLength: 15,
              tooltip: {
                valueSuffix: ' Knots',
              },
            },
          ],
        };
  
        Highcharts.chart(chartOptions1);
      },
    },
  };
  </script>
  
  <style scoped>
  #windbarb-container {
    width: 100%;
    height: 400px;
  }
  </style>
  