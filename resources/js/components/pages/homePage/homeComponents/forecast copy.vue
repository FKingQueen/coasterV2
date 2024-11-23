// Meteogram.vue
<template>
    <div>
        <div id="loading" v-if="loading">Loading data...</div>
        <highcharts :options="chart" :callback="onChartInit" v-else class="hc w-full">
        </highcharts>
    </div>
</template>

<script>
import Highcharts from 'highcharts'
import windbarb from 'highcharts/modules/windbarb'
import { nextTick } from 'vue'
windbarb(Highcharts)

// Weather code mapping for Open-Meteo
const WEATHER_CODES = {
    0: { symbol: '01', text: 'Clear sky' },
    1: { symbol: '02', text: 'Mainly clear' },
    2: { symbol: '03', text: 'Partly cloudy' },
    3: { symbol: '04', text: 'Overcast' },
    45: { symbol: '45', text: 'Fog' },  // Changed to 'Fog' for clarity
    48: { symbol: '45', text: 'Depositing rime fog' },
    51: { symbol: '06', text: 'Light drizzle' },  // Adjusted to fit Yr
    53: { symbol: '07', text: 'Moderate drizzle' }, // Adjusted to fit Yr
    55: { symbol: '08', text: 'Heavy drizzle' }, // Adjusted to fit Yr
    56: { symbol: '06', text: 'Light freezing drizzle' }, // Adjusted to fit Yr
    57: { symbol: '08', text: 'Heavy freezing drizzle' }, // Adjusted to fit Yr
    61: { symbol: '09', text: 'Slight rain' },  // Adjusted to fit Yr
    63: { symbol: '10', text: 'Moderate rain' },
    65: { symbol: '11', text: 'Heavy rain' },
    66: { symbol: '09', text: 'Light freezing rain' }, // Adjusted to fit Yr
    67: { symbol: '11', text: 'Heavy freezing rain' }, // Adjusted to fit Yr
    71: { symbol: '12', text: 'Slight snow fall' },
    73: { symbol: '13', text: 'Moderate snow fall' },
    75: { symbol: '14', text: 'Heavy snow fall' },
    77: { symbol: '12', text: 'Snow grains' },
    80: { symbol: '15', text: 'Slight rain showers' },
    81: { symbol: '16', text: 'Moderate rain showers' },
    82: { symbol: '17', text: 'Heavy rain showers' },
    85: { symbol: '18', text: 'Slight snow showers' },
    86: { symbol: '19', text: 'Heavy snow showers' },
    95: { symbol: '20', text: 'Thunderstorm' },
    96: { symbol: '21', text: 'Thunderstorm with slight hail' },
    99: { symbol: '22', text: 'Thunderstorm with heavy hail' }
};

export default {
    data() {

        return {
            chartInstance: null,
            chartReady: false,
            latitude: 18.1960,
            longitude: 120.5927,
            timezone: "Asia/Singapore",
            loading: true,
            // temperatures
            chart: {
                title: {
                    text: `Weather Forecast for`,
                    align: 'left',
                    style: {
                        whiteSpace: 'nowrap',
                        textOverflow: 'ellipsis'
                    }
                },

                credits: {
                    text: 'Forecast from Open-Meteo.com',
                    href: 'https://open-meteo.com/',
                    position: {
                        x: -40
                    }
                },

                tooltip: {
                    shared: true,
                    useHTML: true,
                    headerFormat: '<small>{point.x:%A, %b %e, %H:%M}</small><br><b>{point.point.symbolName}</b><br>'
                },

                xAxis: [{
                    type: 'datetime',
                    tickInterval: 2 * 36e5, // two hours
                    minorTickInterval: 36e5, // one hour
                    tickLength: 0,
                    gridLineWidth: 1,
                    gridLineColor: 'rgba(128, 128, 128, 0.1)',
                    startOnTick: false,
                    endOnTick: false,
                    minPadding: 0,
                    maxPadding: 0,
                    offset: 30,
                    showLastLabel: true,
                    labels: {
                        format: '{value:%H}'
                    },
                    crosshair: true
                }, {
                    linkedTo: 0,
                    type: 'datetime',
                    tickInterval: 24 * 3600 * 1000,
                    labels: {
                        format: '{value:<span style="font-size: 12px; font-weight: bold">%a</span> %b %e}',
                        align: 'left',
                        x: 3,
                        y: 8
                    },
                    opposite: true,
                    tickLength: 20,
                    gridLineWidth: 1
                }],

                yAxis: [{
                    title: {
                        text: null
                    },
                    labels: {
                        format: '{value}°',
                        style: {
                            fontSize: '10px'
                        },
                        x: -3
                    },
                    plotLines: [{
                        value: 0,
                        color: '#BBBBBB',
                        width: 1,
                        zIndex: 2
                    }],
                    maxPadding: 0.3,
                    minRange: 8,
                    tickInterval: 1,
                    gridLineColor: 'rgba(128, 128, 128, 0.1)'
                }, {
                    title: {
                        text: null
                    },
                    labels: {
                        enabled: false
                    },
                    gridLineWidth: 0,
                    tickLength: 0,
                    minRange: 10,
                    min: 0
                }, {
                    allowDecimals: false,
                    title: {
                        text: 'hPa',
                        offset: 0,
                        align: 'high',
                        rotation: 0,
                        style: {
                            fontSize: '10px',
                            color: Highcharts.getOptions().colors[2]
                        },
                        textAlign: 'left',
                        x: 3
                    },
                    labels: {
                        style: {
                            fontSize: '8px',
                            color: Highcharts.getOptions().colors[2]
                        },
                        y: 2,
                        x: 3
                    },
                    gridLineWidth: 0,
                    opposite: true,
                    showLastLabel: false
                }],

                legend: {
                    enabled: false
                },

                plotOptions: {
                    series: {
                        pointPlacement: 'between'
                    }
                },
                series: [{
                    name: 'Temperature',
                    data: [],
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
                }, {
                    name: 'Rain',
                    data: [],
                    type: 'column',
                    color: '#68CFE8',
                    yAxis: 1,
                    groupPadding: 0,
                    pointPadding: 0,
                    grouping: false,
                    dataLabels: {
                        enabled: true,
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
                }, {
                    name: 'Air pressure',
                    color: Highcharts.getOptions().colors[2],
                    data: [],
                    marker: {
                        enabled: false
                    },
                    shadow: false,
                    tooltip: {
                        valueSuffix: ' hPa'
                    },
                    dashStyle: 'shortdot',
                    yAxis: 2
                }, {
                    name: 'Wind',
                    type: 'windbarb',
                    id: 'windbarbs',
                    color: Highcharts.getOptions().colors[1],
                    lineWidth: 1.5,
                    data: [],
                    vectorLength: 18,
                    yOffset: -15,
                    tooltip: {
                        valueSuffix: ' m/s'
                    }
                }]
            },
            symbols: [],
            resolution: 36e5,
        }
    },

    mounted() {
        this.fetchData()
    },

    beforeUnmount() {
        if (this.chartInstance) {
            this.chartInstance.destroy()
        }
    },

    methods: {
        onChartInit(chart) {
            this.chartInstance = chart
            this.chartReady = true

            // If we already have data loaded, create the chart elements
            if (!this.loading && this.symbols.length > 0) {
                this.createChart()
            }
        },
        async fetchData() {
            try {
                // const url1 = `https://api.open-meteo.com/v1/forecast?latitude=${this.latitude}&longitude=${this.longitude}&start_date=2024-10-30&end_date=2024-11-07&hourly=temperature_2m,precipitation,pressure_msl,weathercode,windspeed_10m,winddirection_10m&timezone=${this.timezone}`
                // const url2 = `https://api.open-meteo.com/v1/forecast?latitude=18.196&longitude=120.5927&hourly=temperature_2m,relative_humidity_2m,rain,weather_code,wind_speed_10m,pressure_msl,wind_direction_10m&wind_speed_unit=kn&timezone=Asia%2FSingapore&start_date=2024-10-30&end_date=2024-10-30`
                const url2 = `https://api.open-meteo.com/v1/forecast?latitude=18.196&longitude=120.5927&hourly=temperature_2m,relative_humidity_2m,rain,weather_code,wind_speed_10m,pressure_msl,wind_direction_10m&wind_speed_unit=kn&timezone=auto&start_date=2024-10-31&end_date=2024-10-31&models=jma_seamless`
                // const response1 = await fetch(url1)
                // const data1 = await response1.json()
                // console.log('Data1: ', data1)

                const response2 = await fetch(url2)
                const data2 = await response2.json()
                console.log('Data2: ', data2)

                await this.parseMeteoData(data2)
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

        async parseMeteoData(data) {
            const thiss = this;
            if (!data || !data.hourly) {

                return this.handleError()
            }

            // Reset arrays
            thiss.symbols = [] //Symbols
            thiss.chart.series[0].data = [] //Temperatures
            thiss.chart.series[1].data = [] //Rain
            thiss.chart.series[2].data = [] //Air Pressure
            thiss.chart.series[3].data = [] //Wind

            // Get the next 48 hours of data
            const hoursToShow = 24
            const hourly = data.hourly

            for (let i = 0; i < hoursToShow; i++) {
                const timestamp = new Date(hourly.time[i]).getTime() + (8 * 60 * 60 * 1000);
                const weatherCode = hourly.weather_code[i]
                console.log('weatherCode: ', weatherCode);
                // const weatherInfo = WEATHER_CODES[weatherCode] || WEATHER_CODES[0]
                const weatherInfo = WEATHER_CODES[weatherCode]

                // Add weather symbol
                this.symbols.push(weatherInfo.symbol)

                // Add temperature
                thiss.chart.series[0].data.push({
                    x: timestamp,
                    y: hourly.temperature_2m[i],
                    to: timestamp,
                    symbolName: weatherInfo.text
                })

                // Add precipitation
                thiss.chart.series[1].data.push({
                    x: timestamp,
                    y: hourly.rain[i]
                })

                // Add wind data (every 2 hours to avoid crowding)
                if (i % 2 === 0) {
                    thiss.chart.series[3].data.push({
                        x: timestamp,
                        value: hourly.wind_speed_10m[i],
                        direction: hourly.wind_direction_10m[i]
                    })
                }

                // Add pressure
                thiss.chart.series[2].data.push({
                    x: timestamp,
                    y: hourly.pressure_msl[i]
                })
            }
            await nextTick()
            this.loading = false

            // Only create chart if it's ready
            if (this.chartReady && this.chartInstance) {
                this.createChart()
            }
        },

        drawWeatherSymbols(chart) {
            if (!chart || !chart.renderer) {
                console.error('Chart or renderer not available')
                return
            }
            chart.series[0].data.forEach((point, i) => {
                // if (this.resolution > 36e5 || i % 2 === 0) {
                const symbol = this.symbols[i]
                const timeOfDay = new Date(point.x).getUTCHours();
                const isDayTime = timeOfDay >= 6 && timeOfDay <= 18
                // Array of symbols that do not have 'd' and 'n'
                const noDayNightSymbols = [
                    '04', '09', '10', '11', '12', '13', '14', '15',
                    '22', '23', '30', '31', '32', '33', '34', '46',
                    '47', '48', '49', '50'
                ];

                // Determine the icon
                const icon = noDayNightSymbols.includes(symbol)
                    ? symbol // Use the symbol as is
                    : symbol + (isDayTime ? 'd' : 'n');


                chart.renderer
                    .image(
                        `https://nrkno.github.io/yr-weather-symbols/symbols/shadows/${icon}.svg`,
                        point.plotX + chart.plotLeft - 8,
                        point.plotY + chart.plotTop - 30,
                        30,
                        30
                    )
                    .attr({
                        zIndex: 5
                    })
                    .add()
                // }
            })
        },

        // Keep the existing drawBlocksForWindArrows method unchanged
        drawBlocksForWindArrows(chart) {
            const xAxis = chart.xAxis[0]
            console.log(xAxis);
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


        createChart() {
            if (!this.chartInstance) {
                console.error('Chart instance not available')
                return
            }

            try {
                this.drawWeatherSymbols(this.chartInstance)
                this.drawBlocksForWindArrows(this.chartInstance)
            } catch (error) {
                console.error('Error creating chart:', error)
            }

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