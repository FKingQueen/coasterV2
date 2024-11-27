<template>
    <div class="w-full h-full">
        <div class="flex w-full justify-between pb-1">
            <div class="text-center">
                <p v-if="this.id == 1" class="font-medium">Ilocos Norte</p>
                <p v-if="this.id == 2" class="font-medium">Ilocos Sur</p>
            </div>
            <div class="flex justify-center items-center">
                <Select :change="onChangeType()" size="small" v-model="type" style="width:200px">
                    <Option v-for="item in typeList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                </Select>
            </div>
        </div>

        <Skeleton :loading="loading" animated class="p-3 min-h-[400px]">
            <highcharts v-if="!loading" class="hc w-full" :constructor-type="'stockChart'" :options="chartOptions1"
                ref="chart">
            </highcharts>
        </Skeleton>
    </div>
</template>
<script>
import { defineComponent, ref } from "vue";
import Highcharts from "highcharts"
// import windbarb from 'highcharts/modules/windbarb'
// windbarb(Highcharts)

export default defineComponent({
    props: ["id"],
    data() {
        return {
            data: [],
            typeList: [
                {
                    value: '1',
                    label: 'Tide'
                },
                {
                    value: '2',
                    label: 'Temperature'
                },
                {
                    value: '3',
                    label: 'Wave Characteristics'
                },

            ],
            type: '',
            loading: true,
            series: [
                    {
                        name: "",
                        data: [],  // your data will be filled dynamically
                        type: '',
                    }
                ],
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
                rangeSelector: {
                    buttons: [
                        { type: 'hour', count: 1, text: '1h' },
                        { type: 'day', count: 1, text: '1d' },
                        { type: 'week', count: 1, text: '1w' },
                        { type: 'month', count: 1, text: '1m' },
                        { type: 'year', count: 1, text: '1y' },
                        { type: 'all', text: 'All' }
                    ],
                    selected: 1,
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
                yAxis: {
                    title: {
                        text: ''
                    },
                },
                series: [
                    {
                        name: "",
                        data: [],  // your data will be filled dynamically
                        type: '',
                    },
                    {
                        name: "",
                        data: [],  // your data will be filled dynamically
                        type: '',
                    },
                    {
                        name: "",
                        data: [],  // your data will be filled dynamically
                        type: '',
                    },
                ],
            },
        };
    },
    methods: {
        onChangeType(e) {
            let thiss = this;

            if (thiss.chartOptions1.series[0].data.length != 0) {
                switch (thiss.type) {
                    case '1':
                        thiss.setChartStyleTide();
                        thiss.chartOptions1.series[0].data = thiss.data.tide

                        break;
                    case '2':
                        thiss.setChartStyleTemp();
                        thiss.chartOptions1.series[0].data = thiss.data.airTemp
                        thiss.chartOptions1.series[1].data = thiss.data.waterTemp
                        break;
                    case '3':
                        thiss.$nextTick(() => {
                            thiss.setChartStyleWave();
                            thiss.chartOptions1.series[0].data = thiss.data.waveHeight
                            thiss.chartOptions1.series[1].data = thiss.data.wavePeriod
                            thiss.chartOptions1.series[2].data = thiss.data.compass

                        });

                        break;
                }
            }
        },
        setChartStyleTide() {
            let thiss = this;

            // Remove
            thiss.chartOptions1.series[1].data = [];

            thiss.chartOptions1.series[0].type = 'areaspline'
            thiss.chartOptions1.rangeSelector.selected = 1
            thiss.chartOptions1.series[0].name = 'Tide'
            thiss.chartOptions1.subtitle.text = 'Tide'
            thiss.chartOptions1.yAxis.title.text = 'Tide (Meter)'
            thiss.chartOptions1.series[0].tooltip = {
                valueSuffix: ' m'
            }

            thiss.chartOptions1.series[0].color = Highcharts.getOptions().colors[0]

            thiss.chartOptions1.series[0].fillColor = {
                linearGradient: {
                    x1: 0,
                    y1: 0,
                    x2: 0,
                    y2: 1
                },
                stops: [
                    [0, Highcharts.getOptions().colors[0]], // Color at the top (positive values)
                    [
                        1,
                        Highcharts.color(Highcharts.getOptions().colors[0])
                            .setOpacity(0)
                            .get('rgba') // Transparent at the bottom (negative values)
                    ]
                ]
            }

            this.chartOptions1.series[0].negativeFillColor = {
                linearGradient: {
                    x1: 0,
                    y1: 0,
                    x2: 0,
                    y2: 1
                },
                stops: [
                    [0, Highcharts.getOptions().colors[1]], // Color at the top for negative values
                    [
                        1,
                        Highcharts.color(Highcharts.getOptions().colors[1])
                            .setOpacity(0)
                            .get('rgba') // Transparent at the bottom for negative values
                    ]
                ]
            }

            this.chartOptions1.series[0].tooltip = {
                valueDecimals: 2
            }
        },
        setChartStyleTemp() {
            const thiss = this

            // Remove
            delete thiss.chartOptions1.series[0].fillColor;
            delete this.chartOptions1.series[0].negativeFillColor;

            // Both
            thiss.chartOptions1.subtitle.text = 'Temperature'
            thiss.chartOptions1.yAxis.title.text = 'Temperature °C'
            thiss.chartOptions1.rangeSelector.selected = 0


            // Air Temperature
            thiss.chartOptions1.series[0].type = 'spline'
            thiss.chartOptions1.series[0].name = 'Air Temperature'
            thiss.chartOptions1.series[0].tooltip = {
                valueDecimals: 2,
                valueSuffix: '°C'
            }
            thiss.chartOptions1.series[0].color = '#FF0000'

            // Water Temperature
            thiss.chartOptions1.series[1].type = 'spline'
            thiss.chartOptions1.series[1].name = 'Water Temperature'
            thiss.chartOptions1.series[1].tooltip = {
                valueDecimals: 2,
                valueSuffix: '°C'
            }
            thiss.chartOptions1.series[1].color = '#FF774F'
            console.log(thiss.chartOptions1);
        },
        setChartStyleWave() {
            const thiss = this
            thiss.chartOptions1.rangeSelector.selected = 0

            // Significant Wave Height
            thiss.chartOptions1.series[0].type = 'column'
            thiss.chartOptions1.series[0].name = 'Significant Wave Height'
            thiss.chartOptions1.series[0].tooltip = {
                valueDecimals: 2,
                valueSuffix: 'm'
            }

            // Wave Period 
            thiss.chartOptions1.series[1].type = 'spline'
            thiss.chartOptions1.series[1].name = 'Wave Period'
            thiss.chartOptions1.series[1].tooltip = { valueSuffix: 's', valueDecimals: 2 }

            // compass
            thiss.chartOptions1.series[2].type = 'windbarb'
            thiss.chartOptions1.series[2].name = 'Wind Direction'
            thiss.chartOptions1.series[2].id = 'windbarbs'
            thiss.chartOptions1.series[2].color = 'white'
            thiss.chartOptions1.series[2].lineWidth = 1.5
            thiss.chartOptions1.series[2].vectorLength = 15
            thiss.chartOptions1.series[2].yOffset = -15
            thiss.chartOptions1.series[2].tooltip = {
                valueSuffix: 'Knots'
            }

            //     name: 'Wind',
            //     type: 'windbarb',
            //     id: 'windbarbs',
            //     color: Highcharts.getOptions().colors[1],
            //     lineWidth: 1.5,
            //     data: [],
            //     vectorLength: 15,
            //     yOffset: -15,
            //     tooltip: {
            //         valueSuffix: 'Knots'
            //     }
            // }]
        }
    },
    async mounted() {
        let thiss = this;

        await axios
            .get(`/api/getBouy/${this.id}`)
            .then((response) => {
                console.log('buoy1: ', response);
                thiss.type = '1'
                thiss.data = response.data
                thiss.chartOptions1.series[0].data = thiss.data.tide
                // Setting the Style of the Chart
                thiss.setChartStyleTide();
                thiss.loading = false
            })
            .catch(function (error) {
                console.error(error);
            });
    },
});
</script>
