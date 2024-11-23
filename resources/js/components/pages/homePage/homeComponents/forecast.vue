<template>
    <div class="">
        <div class="w-full pb-2">
            <p class="text-base font-Roboto drop-shadow-lg">7-Day Weather Forecast</p>
        </div>
        <div class="flex items-center w-full justify-center justify-center pb-3">
            <a-row class="w-full flex justify-center" :gutter="5">
                <a-col :span="3" v-for="(dailyData, index) in this.dailyWeatherData.month" class="">
                    <div class="bg-sky-950 py-1 px-2 text-white">
                        <!-- <p class="text-sm ">
                            {{ dailyData }} {{ this.dailyWeatherData.dayOfMonth[index] }}
                        </p> -->
                        <div v-if="index == 0" class="flex justify-between">
                            <p class="text-xs">
                                Today
                            </p>
                            <p class="text-xs">
                                {{ dailyData }}/{{ this.dailyWeatherData.dayOfMonth[index] }}
                            </p>
                        </div>
                        <div v-else class="flex justify-between">
                            <p class="text-xs">
                                {{ this.dailyWeatherData.dayOfWeek[index] }}
                            </p>
                            <p class="text-xs">
                                {{ dailyData }}/{{ this.dailyWeatherData.dayOfMonth[index] }}
                            </p>
                        </div>
                        <!-- <p v-if="index == 0" class="text-xs text-between">
                            Today 
                        </p>
                        <p v-else class="text-xs">
                            {{ this.dailyWeatherData.dayOfWeek[index] }} {{ dailyData }}/{{ this.dailyWeatherData.dayOfMonth[index] }}
                        </p> -->
                        <div class="flex justify-center items-center">
                            <div>
                                <img class="h-16" :src="this.dailyWeatherData.dailyWeatherImgURL[index]">
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <p class="text-xs">
                                <span class="text-sm text-bold text-red-400">{{
                                    this.dailyWeatherData.temperature_2m_max[index] }}</span>/{{
                                        this.dailyWeatherData.temperature_2m_min[index] }} °C
                            </p>
                        </div>
                        <div class="flex justify-center">
                            <p class="text-xs">
                                {{ this.dailyWeatherData.rain_sum[index] }} mm
                            </p>
                        </div>
                    </div>
                </a-col>
            </a-row>

        </div>
        <div class="w-full ">
            <div class="border-b flex w-full px-3 py-2 justify-between ">
                <div class="flex space-x-2 ">
                    <div class="flex items-center">
                        <p class="text-sm">
                            Current Weather at
                        </p>
                    </div>
                    <div>
                        <a-select v-model:value="selectedModel" :options="options" size="small" style="width: 200px"
                            @change="selectedArea()"></a-select>
                    </div>
                </div>
                <div>
                    <p class="">As of {{ currentWeatherData.currentWeatherTime }}</p>
                </div>
            </div>
            <Skeleton :loading="currentWeatherLoading" animated class="p-3">
                <div class="p-3 bg-white text-zinc-700">
                    <div class="flex w-full">
                        <div class="w-2/4 flex items-center">
                            <div>
                                <img :src="currentWeatherData.currentWeatherImgURL">
                            </div>
                            <div class="items-center flex">
                                <div>
                                    <p>{{ currentWeatherData.currentWeatherCodeText }}</p>
                                    <p class="text-4xl">{{ currentWeatherData.currentWeatherTemperature }} °C</p>
                                    <p>Rainfall: <span>{{ currentWeatherData.currentWeatherRainfall }} mm</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="w-2/4 flex items-center">
                            <table class="w-full border-none">
                                <tbody>
                                    <tr class="border-b">
                                        <td class="py-1">Wind</td>
                                        <td class="py-1">
                                            {{ currentWeatherData.currentWeatherWindDirection }}
                                            {{ currentWeatherData.currentWeatherWind }} km/h
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-1">Cloud Cover</td>
                                        <td class="py-1">{{ currentWeatherData.currentWeatherCloudCover }} %</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-1">Relative Humidity</td>
                                        <td class="py-1">{{ currentWeatherData.currentWeatherHumidity }} %</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-1">Surface Pressure</td>
                                        <td class="py-1">{{ currentWeatherData.currentWeatherSurfacePressure }} hPa</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </Skeleton>
        </div>

        <div id="loading" v-if="loading">Loading data...</div>
        <highcharts :options="chartOptions" ref="highchartsRef" v-else class="hc w-full pt-2 drop-shadow-lg">
        </highcharts>
    </div>
</template>

<script>
import Highcharts from "highcharts"
import windbarb from 'highcharts/modules/windbarb'
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

import { nextTick, defineComponent, ref } from 'vue';
export default defineComponent({
    setup() {
        const options = ref([
            {
                label: 'Ilocos Norte',
                options: [
                    {
                        value: "Laoag City",
                        label: "Laoag City",
                        latitude: 18.1978,
                        longitude: 120.5954
                    },
                    {
                        value: "Batac City",
                        label: "Batac City",
                        latitude: 18.0460,
                        longitude: 120.5941
                    },
                ],
            },
            {
                label: 'Ilocos Sur',
                options: [
                    {
                        label: "Vigan City",
                        value: "Vigan City",
                        latitude: 17.5744,
                        longitude: 120.3869
                    },
                    {
                        label: "Candon City",
                        value: "Candon City",
                        latitude: 17.1981,
                        longitude: 120.4495
                    }
                ],
            },
            {
                label: 'La Union',
                options: [
                    {
                        label: "San Fernando City",
                        value: "San Fernando City",
                        latitude: 16.6192,
                        longitude: 120.3199
                    }
                ],
            },
            {
                label: 'Pangasinan',
                options: [
                    {
                        name: "Dagupan City",
                        value: "Dagupan City",
                        latitude: 16.0431,
                        longitude: 120.3337
                    },
                    {
                        name: "San Carlos City",
                        value: "San Carlos City",
                        latitude: 15.9284,
                        longitude: 120.3483
                    },
                    {
                        name: "Urdaneta City",
                        value: "Urdaneta City",
                        latitude: 15.9761,
                        longitude: 120.5713
                    },
                    {
                        name: "Alaminos City",
                        value: "Alaminos City",
                        latitude: 16.1551,
                        longitude: 119.9806
                    }
                ],
            },
        ]);
        const selectedModel = ref(['Batac City']);
        return {
            options,
            selectedModel,
        }
    },
    data() {
        return {
            dailyWeatherData: '',
            currentWeatherLoading: true,
            currentWeatherData: {
                currentWeatherImgURL: '',
                currentWeatherTime: '',
                currentWeatherCodeText: '',
                currentWeatherTemperature: '',
                currentWeatherRainfall: '',
                currentWeatherWind: '',
                currentWeatherWindDirection: '',
                currentWeatherCloudCover: '',
                currentWeatherHumidity: '',
                currentWeatherSurfacePressure: '',
            },
            forecastLatitude: 18.0460,
            forecastLongitude: 120.5941,
            loading: true,
            // temperatures
            chartOptions: {
                chart: {
                    events: {
                        render() {
                        },
                    },
                },
                title: {
                    text: `Weather Forecast for ${this.selectedModel}`,
                    align: 'center',
                    style: {
                        whiteSpace: 'nowrap',
                        textOverflow: 'ellipsis'
                    }
                },

                subtitle: {
                    text: 'Source: JMA Japan',
                    align: 'center'
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
                legend: {
                    align: 'center',
                    // verticalAlign: 'buttom', 
                    borderWidth: 0
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
                        valueSuffix: 'Knots'
                    }
                }]
            },
            symbols: [],
            weatherIcons: [],
            resolution: 36e5,
        }
    },
    created() {
        this.fetchData()
    },
    methods: {
        selectedArea() {
            const thiss = this
            thiss.chartOptions.title.text = `Weather Forecast for ${thiss.selectedModel}`
            for (const province of thiss.options) {
                for (const city of province.options) {
                    if (city.value === this.selectedModel) {
                        thiss.forecastLatitude = city.latitude
                        thiss.forecastLongitude = city.longitude
                        thiss.fetchData();
                    }
                }
            }

        },
        async fetchData() {
            const thiss = this;
            try {
                thiss.currentWeatherLoading = true;
                const url2 = `https://api.open-meteo.com/v1/forecast?latitude=${this.forecastLatitude}&longitude=${this.forecastLongitude}&current=temperature_2m,relative_humidity_2m,rain,surface_pressure,wind_speed_10m,wind_direction_10m,weather_code,cloud_cover&hourly=temperature_2m,relative_humidity_2m,rain,weather_code,wind_speed_10m,pressure_msl,wind_direction_10m&wind_speed_unit=kn&daily=weather_code,temperature_2m_max,temperature_2m_min,rain_sum&timezone=auto&models=jma_seamless`
                const response2 = await fetch(url2)
                const data2 = await response2.json()

                // 7-Day Weather Forecast
                this.daysWeather(data2);
                // Current Weather
                this.currentWeather(data2)
                // ParseData
                await this.parseMeteoData(data2)
            } catch (error) {
                console.error('Failed to load weather data:', error)
                this.handleError()
            }
        },
        currentWeather(data) {

            const thiss = this;
            // console.log(data);
            const weatherInfo = WEATHER_CODES[data.current.weather_code]

            // Add weather symbol
            const symbol = weatherInfo.symbol

            const dateString = data.current.time;
            const date = new Date(dateString);
            const timeOfDay = date.getHours();

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

            thiss.currentWeatherData.currentWeatherCodeText = weatherInfo.text
            thiss.currentWeatherData.currentWeatherImgURL = `https://nrkno.github.io/yr-weather-symbols/symbols/darkmode/${icon}.svg`
            const dateTime = new Date(data.current.time)
            thiss.currentWeatherData.currentWeatherTime = dateTime.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            })
            thiss.currentWeatherData.currentWeatherTemperature = data.current.temperature_2m
            thiss.currentWeatherData.currentWeatherRainfall = data.current.rain
            thiss.currentWeatherData.currentWeatherWind = data.current.wind_speed_10m


            const directions = ['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE',
                'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW']

            const index = Math.round(data.current.wind_direction_10m / 22.5) % 16

            thiss.currentWeatherData.currentWeatherWindDirection = directions[index]
            thiss.currentWeatherData.currentWeatherCloudCover = data.current.cloud_cover
            thiss.currentWeatherData.currentWeatherHumidity = data.current.relative_humidity_2m
            thiss.currentWeatherData.currentWeatherSurfacePressure = data.current.surface_pressure

            thiss.currentWeatherLoading = false;
            // console.log(thiss.currentWeatherData);
        },
        daysWeather(data) {
            const thiss = this
            const months = [
                "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
            ];
            const days = [
                "SUN", "MON", "TUE", "WED",
                "THU", "FRI", "SAT"
            ];

            data.daily.month = [];
            data.daily.dayOfMonth = [];
            data.daily.dayOfWeek = [];
            data.daily.dailyWeatherImgURL = [];

            for (let i = 0; i < data.daily.time.length; i++) {
                const date2 = new Date(data.daily.time[i]);
                data.daily.month.push(date2.getMonth());
                data.daily.dayOfMonth.push(date2.getDate())
                data.daily.dayOfWeek.push(days[date2.getDay()])

                const weatherInfo = WEATHER_CODES[data.daily.weather_code[i]]

                // Add weather symbol
                const symbol = weatherInfo.symbol

                const dateString = data.current.time;
                const date = new Date(dateString);
                const timeOfDay = date.getHours();

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

                thiss.currentWeatherData.currentWeatherCodeText = weatherInfo.text
                data.daily.dailyWeatherImgURL.push(`https://nrkno.github.io/yr-weather-symbols/symbols/darkmode/${icon}.svg`);
            }
            thiss.dailyWeatherData = data.daily
            // console.log(thiss.dailyWeatherData); // "November, 5 Tuesday"

        },
        async parseMeteoData(data) {
            const thiss = this;
            // Reset arrays
            thiss.symbols = [] //Symbols
            thiss.chartOptions.series[0].data = [] //Temperatures
            thiss.chartOptions.series[1].data = [] //Rain
            thiss.chartOptions.series[2].data = [] //Air Pressure
            thiss.chartOptions.series[3].data = [] //Wind

            // Get the next 48 hours of data
            const hoursToShow = 24
            const hourly = data.hourly

            for (let i = 0; i < hoursToShow; i++) {
                const timestamp = new Date(hourly.time[i]).getTime() + (8 * 60 * 60 * 1000);
                const weatherCode = hourly.weather_code[i]
                // const weatherInfo = WEATHER_CODES[weatherCode] || WEATHER_CODES[0]
                const weatherInfo = WEATHER_CODES[weatherCode]

                // Add weather symbol
                this.symbols.push(weatherInfo.symbol)

                // Add temperature
                thiss.chartOptions.series[0].data.push({
                    x: timestamp,
                    y: hourly.temperature_2m[i],
                    to: timestamp,
                    symbolName: weatherInfo.text
                })

                // Add precipitation
                thiss.chartOptions.series[1].data.push({
                    x: timestamp,
                    y: hourly.rain[i]
                })

                // Add wind data (every 2 hours to avoid crowding)
                if (i % 2 === 0) {
                    thiss.chartOptions.series[3].data.push({
                        x: timestamp,
                        value: hourly.wind_speed_10m[i],
                        direction: hourly.wind_direction_10m[i]
                    })
                }

                // Add pressure
                thiss.chartOptions.series[2].data.push({
                    x: timestamp,
                    y: hourly.pressure_msl[i]
                })
            }
            await nextTick()
            this.loading = false

            this.$nextTick(() => {
                const chart = this.$refs.highchartsRef.chart;
                this.createChart(chart)
                // chart.redraw();  // Trigger a re-render if needed

            });

        },

        drawWeatherSymbols(chart) {
            this.clearWeatherSymbols();

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
                const iconRef = chart.renderer
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
                this.weatherIcons.push(iconRef);
            })
        },
        clearWeatherSymbols() {
            // Remove all previously drawn icons
            this.weatherIcons.forEach(icon => icon.destroy());
            this.weatherIcons = []; // Clear the array after removing icons
        },
        createChart(chartInstance) {
            try {
                this.drawWeatherSymbols(chartInstance)
            } catch (error) {
                console.error('Error creating chart:', error)
            }

        }
    }
})
</script>

<style scoped>
#loading {
    padding: 1rem;
    text-align: center;
}

.gutter-box {
    background: #0092ff;
    padding: 8px 0;
}
</style>