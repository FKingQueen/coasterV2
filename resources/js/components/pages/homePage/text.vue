// Meteogram.vue
<template>
  <div>
    <div id="loading" v-if="loading">Loading data...</div>
    <div :id="containerId" v-else></div>
  </div>
</template>

<script>
import Highcharts from 'highcharts'
import windbarb from 'highcharts/modules/windbarb'
// Initialize windbarb module
windbarb(Highcharts)

// Dictionary for weather symbols
const WEATHER_DICTIONARY = {
    clearsky: {
        symbol: '01',
        text: 'Clear sky'
    },
    fair: {
        symbol: '02',
        text: 'Fair'
    },
    // ... (keep all the dictionary entries from original code)
    fog: {
        symbol: '15',
        text: 'Fog'
    }
}

export default {
  name: 'Meteogram',
  props: {
    containerId: {
      type: String,
      default: 'meteogram-container'
    },
    latitude: {
      type: Number,
      required: true
    },
    longitude: {
      type: Number,
      required: true
    },
    altitude: {
      type: Number,
      default: 25
    }
  },
  
  data() {
    return {
      loading: true,
      chart: null,
      symbols: [],
      precipitations: [],
      precipitationsError: [],
      winds: [],
      temperatures: [],
      pressures: [],
      resolution: 36e5,
      hasPrecipitationError: false
    }
  },

  mounted() {
    this.fetchData()
  },

  beforeUnmount() {
    if (this.chart) {
      this.chart.destroy()
    }
  },

  methods: {
    async fetchData() {
      try {
        const url = `https://api.met.no/weatherapi/locationforecast/2.0/compact?lat=${this.latitude}&lon=${this.longitude}&altitude=${this.altitude}`
        const response = await fetch(url, {
          headers: {
            'Content-Type': 'text/plain'
          }
        })
        const json = await response.json()
        this.parseYrData(json)
      } catch (error) {
        console.error('Failed to load weather data:', error)
        this.handleError()
      }
    },

    handleError() {
      const loadingEl = document.getElementById('loading')
      if (loadingEl) {
        loadingEl.innerHTML = '<i class="fa fa-frown-o"></i> Failed loading data, please try again later'
      }
    },

    parseYrData(json) {
      if (!json) {
        return this.handleError()
      }

      let pointStart

      // Reset arrays
      this.symbols = []
      this.temperatures = []
      this.precipitations = []
      this.winds = []
      this.pressures = []

      // Parse data
      json.properties.timeseries.forEach((node, i) => {
        const x = Date.parse(node.time)
        const nextHours = node.data.next_1_hours || node.data.next_6_hours
        const symbolCode = nextHours && nextHours.summary.symbol_code
        const to = node.data.next_1_hours ? x + 36e5 : x + 6 * 36e5

        if (pointStart && to > pointStart + 48 * 36e5) {
          return
        }

        this.symbols.push(nextHours.summary.symbol_code)

        this.temperatures.push({
          x,
          y: node.data.instant.details.air_temperature,
          to,
          symbolName: WEATHER_DICTIONARY[symbolCode.replace(/_(day|night)$/, '')].text
        })

        this.precipitations.push({
          x,
          y: nextHours.details.precipitation_amount
        })

        if (i % 2 === 0) {
          this.winds.push({
            x,
            value: node.data.instant.details.wind_speed,
            direction: node.data.instant.details.wind_from_direction
          })
        }

        this.pressures.push({
          x,
          y: node.data.instant.details.air_pressure_at_sea_level
        })

        if (i === 0) {
          pointStart = (x + to) / 2
        }
      })

      this.createChart()
    },

    drawWeatherSymbols(chart) {
      chart.series[0].data.forEach((point, i) => {
        if (this.resolution > 36e5 || i % 2 === 0) {
          const [symbol, specifier] = this.symbols[i].split('_')
          const icon = WEATHER_DICTIONARY[symbol].symbol +
            ({ day: 'd', night: 'n' }[specifier] || '')

          if (WEATHER_DICTIONARY[symbol]) {
            chart.renderer
              .image(
                `https://cdn.jsdelivr.net/gh/nrkno/yr-weather-symbols@8.0.1/dist/svg/${icon}.svg`,
                point.plotX + chart.plotLeft - 8,
                point.plotY + chart.plotTop - 30,
                30,
                30
              )
              .attr({
                zIndex: 5
              })
              .add()
          }
        }
      })
    },

    drawBlocksForWindArrows(chart) {
      const xAxis = chart.xAxis[0]

      for (
        let pos = xAxis.min, max = xAxis.max, i = 0;
        pos <= max + 36e5;
        pos += 36e5, i += 1
      ) {
        const isLast = pos === max + 36e5
        const x = Math.round(xAxis.toPixels(pos)) + (isLast ? 0.5 : -0.5)
        const isLong = this.resolution > 36e5 ? pos % this.resolution === 0 : i % 2 === 0

        chart.renderer
          .path([
            'M', x, chart.plotTop + chart.plotHeight + (isLong ? 0 : 28),
            'L', x, chart.plotTop + chart.plotHeight + 32,
            'Z'
          ])
          .attr({
            stroke: chart.options.chart.plotBorderColor,
            'stroke-width': 1
          })
          .add()
      }

      chart.get('windbarbs').markerGroup.attr({
        translateX: chart.get('windbarbs').markerGroup.translateX + 8
      })
    },

    getChartOptions() {
      return {
        chart: {
          renderTo: this.containerId,
          marginBottom: 70,
          marginRight: 40,
          marginTop: 50,
          plotBorderWidth: 1,
          height: 310,
          alignTicks: false,
          scrollablePlotArea: {
            minWidth: 720
          }
        },
        // ... (keep all the chart options from original code)
        series: [{
          name: 'Temperature',
          data: this.temperatures,
          type: 'spline',
          marker: {
            enabled: false,
            states: {
              hover: {
                enabled: true
              }
            }
          },
          tooltip: {
            pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.y}°C</b><br/>'
          },
          zIndex: 1,
          color: '#FF3333',
          negativeColor: '#48AFE8'
        },
        {
          name: 'Precipitation',
          data: this.precipitationsError,
          type: 'column',
          color: 'url(#precipitation-error)',
          yAxis: 1,
          groupPadding: 0,
          pointPadding: 0,
          tooltip: {
            valueSuffix: ' mm',
            pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.minvalue} mm - {point.maxvalue} mm</b><br/>'
          },
          grouping: false,
          dataLabels: {
            enabled: this.hasPrecipitationError,
            filter: {
              operator: '>',
              property: 'maxValue',
              value: 0
            },
            style: {
              fontSize: '8px',
              color: 'gray'
            }
          }
        },
        {
          name: 'Precipitation',
          data: this.precipitations,
          type: 'column',
          color: '#68CFE8',
          yAxis: 1,
          groupPadding: 0,
          pointPadding: 0,
          grouping: false,
          dataLabels: {
            enabled: !this.hasPrecipitationError,
            filter: {
              operator: '>',
              property: 'y',
              value: 0
            },
            style: {
              fontSize: '8px',
              color: '#666'
            }
          },
          tooltip: {
            valueSuffix: ' mm'
          }
        },
        {
          name: 'Air pressure',
          color: Highcharts.getOptions().colors[2],
          data: this.pressures,
          marker: {
            enabled: false
          },
          shadow: false,
          tooltip: {
            valueSuffix: ' hPa'
          },
          dashStyle: 'shortdot',
          yAxis: 2
        },
        {
          name: 'Wind',
          type: 'windbarb',
          id: 'windbarbs',
          color: Highcharts.getOptions().colors[1],
          lineWidth: 1.5,
          data: this.winds,
          vectorLength: 18,
          yOffset: -15,
          tooltip: {
            valueSuffix: ' m/s'
          }
        }]
      }
    },

    createChart() {
      this.chart = new Highcharts.Chart(this.getChartOptions())
      this.drawWeatherSymbols(this.chart)
      this.drawBlocksForWindArrows(this.chart)
      this.loading = false
    }
  }
}
</script>

<style scoped>
#loading {
  padding: 1rem;
  text-align: center;
}
</style>