<template>
    <div class=" flex w-full">
        <div class="w-full sm:w-1/2 drop-shadow-lg p-1">
            <div class="flex w-full justify-between pb-1">
                <div class="flex justify-center text-l items-center font-bold text-blue-700 drop-shadow">
                    Tide Level & Temperature
                </div>
            </div>

            <Skeleton :loading="loading" animated class="p-3 min-h-[400px]">
                <highcharts v-if="!loading" class="hc w-full" :constructor-type="'stockChart'" :options="chartOptions1"
                    ref="chart">
                </highcharts>
            </Skeleton>
        </div>

        <div class="w-full sm:w-1/2 drop-shadow-lg p-1">
            <div class="flex w-full justify-between pb-1">
                <div class="flex justify-center text-l items-center font-bold text-blue-700 drop-shadow">
                    Wave Characteristics
                </div>
            </div>

            <Skeleton :loading="loading" animated class="p-3 min-h-[400px]">
                <highcharts v-if="!loading" class="hc w-full" :constructor-type="'stockChart'" :options="chartOptions2"
                    ref="chart">
                </highcharts>
            </Skeleton>
        </div>
    </div>
</template>
<script>
import { defineComponent, ref } from "vue";
import Highcharts from "highcharts"


export default defineComponent({
    props: ["id"],
    data() {
        return {
            data: [],
            type: '',
            loading: true,
            chartOptions2: {
                chart: {
                    backgroundColor: '#f7f7f7', // Light gray background
                    style: {
                        fontFamily: 'Arial, sans-serif', // Change the font
                    },
                },
                credits: {
                    text: '',
                },
                legend: {
                    enabled: true,      // <--- REQUIRED in stock charts
                    align: 'center',
                    verticalAlign: 'bottom'
                },
                rangeSelector: {
                    buttons: [
                        { type: 'hour', count: 1, text: '1h' },
                        { type: 'day', count: 1, text: '1d' },
                        { type: 'week', count: 1, text: '1w' },
                        { type: 'month', count: 1, text: '1m' },
                        { type: 'year', count: 1, text: '1y' },
                        { type: 'all', text: 'All' }
                    ],
                    selected: 0,
                    inputEnabled: true,
                },
                title: {
                    text: "",
                    style: {
                        color: '#333333', // Dark title text
                        fontSize: '18px',
                    },
                },
                subtitle: {
                    text: "",
                },
                yAxis: [
                    {
                        // LEFT AXIS
                        labels: {
                            format: '{value} cm',
                            x: -5,        // moves closer to left axis
                            padding: 0,   // removes extra space
                            margin: 5     // tighter axis spacing
                        },
                        title: { text: 'Wave Height (cm)' },
                        opposite: false,   // left side
                        lineWidth: 1,
                        lineColor: Highcharts.getOptions().colors[1],
                    },
                    {
                        // RIGHT AXIS
                        labels: {
                            format: '{value} s',
                            x: -5,
                            padding: 0,   // removes extra space
                            margin: 5     // tighter axis spacing
                        },
                        title: { text: 'Wave Period (s)' },
                        opposite: true,    // right side
                        lineWidth: 1,
                        lineColor: Highcharts.getOptions().colors[0],
                    }
                ],
                series: [
                    {
                        name: "Wave Height",
                        data: [],  // your data will be filled dynamically
                        type: 'spline',

                    },
                    {
                        name: "Wave Period",
                        data: [],  // your data will be filled dynamically
                        type: 'column',
                        yAxis: 1,
                    },
                ],
            },
            chartOptions1: {
                chart: {
                    backgroundColor: '#f7f7f7', // Light gray background
                    style: {
                        fontFamily: 'Arial, sans-serif', // Change the font
                    },
                },
                credits: {
                    text: '',
                },
                legend: {
                    enabled: true,      // <--- REQUIRED in stock charts
                    align: 'center',
                    verticalAlign: 'bottom'
                },
                rangeSelector: {
                    buttons: [
                        { type: 'hour', count: 1, text: '1h' },
                        { type: 'day', count: 1, text: '1d' },
                        { type: 'week', count: 1, text: '1w' },
                        { type: 'month', count: 1, text: '1m' },
                        { type: 'year', count: 1, text: '1y' },
                        { type: 'all', text: 'All' }
                    ],
                    selected: 0,
                    inputEnabled: true,
                },
                title: {
                    text: "",
                    style: {
                        color: '#333333', // Dark title text
                        fontSize: '18px',
                    },
                },
                subtitle: {
                    text: "",
                },
                yAxis: [
                    {
                        // LEFT AXIS
                        labels: {
                            format: '{value} cm',
                            x: -5,        // moves closer to left axis
                            padding: 0,   // removes extra space
                            margin: 5     // tighter axis spacing
                        },
                        title: { text: 'Tide (cm)' },
                        opposite: false,   // left side
                        lineWidth: 1,
                        lineColor: Highcharts.getOptions().colors[1],
                    },
                    {
                        // RIGHT AXIS
                        labels: {
                            format: '{value} s',
                            x: -5,
                            padding: 0,   // removes extra space
                            margin: 5     // tighter axis spacing
                        },
                        title: { text: 'Temperature °C' },
                        opposite: true,    // right side
                        lineWidth: 1,
                        lineColor: '#FF0000',
                    }
                ],
                series: [
                    {
                        name: "Tide",
                        data: [],  // your data will be filled dynamically
                        type: 'spline',

                    },
                    {
                        name: "Temperature",
                        data: [],  // your data will be filled dynamically
                        type: 'spline',
                        yAxis: 1,
                        color: '#FF0000'   // <-- spline line becomes red
                    },
                ],
            },
        };
    },
    async mounted() {
        let thiss = this;

        await axios
            .get(`/api/getBouy/${this.id}`)
            .then((response) => {
                thiss.type = '3'
                thiss.data = response.data

                thiss.chartOptions1.series[1].data = thiss.data.tide;
                thiss.chartOptions1.series[0].data = thiss.data.temperature;

                thiss.chartOptions2.series[1].data = thiss.data.waveHeight;
                thiss.chartOptions2.series[0].data = thiss.data.wavePeriod;



                thiss.loading = false
            })
            .catch(function (error) {
                console.error(error);
            });
    },
});
</script>
