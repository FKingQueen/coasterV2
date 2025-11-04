<template>
    <div class="w-full h-full">
        <div class="flex w-full justify-between pb-1">
            <div class=" text-center">
                <p v-if="this.id == 1" class=" font-medium">Ilocos Norte</p>
                <p v-if="this.id == 2" class=" font-medium">Ilocos Sur</p>
            </div>
            <div class=" flex justify-center items-center">
                <Select :change="onChangeType()" size="small" v-model="type" style="width:200px">
                    <Option v-for="item in typeList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                </Select>
            </div>
        </div>
        <!-- <div v-if="loading" class="loading-spinner">
            Loading...
        </div> -->
        <Skeleton :loading="loading" animated class="p-3 min-h-[400px]">
            <highcharts v-if="!loading" class="hc w-full" :constructor-type="'stockChart'" :options="chartOptions">
            </highcharts>
        </Skeleton>

    </div>
</template>
<script>
import { defineComponent, ref } from "vue";
export default defineComponent({
    props: ["id"],
    data() {
        return {
            data: [],
            typeList: [
                {
                    value: '1',
                    label: 'Water Level'
                },
                {
                    value: '2',
                    label: 'Temperature'
                },
                {
                    value: '3',
                    label: 'Humidity'
                }
            ],
            type: '',
            loading: true,

            chartOptions: {
                chart: {
                    backgroundColor: '#f7f7f7', // Light gray background
                    style: {
                        fontFamily: 'Arial, sans-serif', // Change the font
                    },
                    events: {
                        load: function () {
                            const thiss = this
                            const series = thiss.series[0];
                            setInterval(function () {
                                const id = thiss.userOptions.custom.id;
                                const type = thiss.userOptions.custom.type;
                                axios
                                    .get(`/api/getWaterLevelLatest/${id}`)
                                    .then((response) => {
                                        switch (type) {
                                            case '1':
                                                series.addPoint(response.data.level, true, true);
                                                console.log("wlms: ", response.data.level);
                                                break;
                                            case '2':
                                                series.addPoint(response.data.temperature, true, true);
                                                console.log("wlms: ", response.data.temperature);
                                                break;
                                            case '3':
                                                series.addPoint(response.data.humidity, true, true);
                                                console.log("wlms: ", response.data.humidity);
                                                break;
                                        }
                                    })
                                    .catch(function (error) {
                                        console.error(error);
                                    });
                            }, 60000);
                        }
                    }
                },
                // Store component reference and id in custom options
                custom: {
                    id: null,
                    type: null
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
                    selected: 2,
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
                credits: {
                    text: '',
                },
                series: [{
                    name: '',
                    data: [],
                    type: 'areaspline',
                }],
                plotOptions: {
                    series: {
                        pointStart: Date.UTC(2010, 0, 1),
                        marker: {
                            enabled: false,
                            states: {
                                hover: {
                                    enabled: false
                                }
                            }
                        }
                    },
                },
            },

            // intervalId: null,

        };
    },
    async mounted() {
        let thiss = this;

        // this.chartOptions.custom.component = this;
        this.chartOptions.custom.id = this.id;

        await axios
            .get(`/api/getWaterLevel/${this.id}`)
            .then((response) => {
                console.log(response);
                thiss.type = '1'
                thiss.chartOptions.custom.type = '1'
                thiss.data = response.data
                thiss.chartOptions.series[0].data = thiss.data.level
                thiss.chartOptions.series[0].data = thiss.data.level

                // Setting the Style of the Chart
                thiss.setChartStyle();
                thiss.loading = false
            })
            .catch(function (error) {
                console.error(error);
                thiss.loading = false
            });

        // this.intervalId = setInterval(this.fetchData, 300000); // Fetch data every 5 seconds
    },
    // beforeUnmount() {
    //     clearInterval(this.intervalId); // Clean up interval when component unmounts
    // },
    methods: {
        setChartStyle() {
            let thiss = this;

            thiss.chartOptions.series[0].color = Highcharts.getOptions().colors[0]

            thiss.chartOptions.series[0].fillColor = {
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

            this.chartOptions.series[0].negativeFillColor = {
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

            this.chartOptions.series[0].tooltip = {
                valueDecimals: 2
            }
        },
        onChangeType() {
            const thiss = this;
            thiss.chartOptions.custom.type = thiss.type
            if (thiss.chartOptions.series[0].data.length != 0) {
                switch (thiss.type) {
                    case '1':
                        thiss.setChartStyle();
                        thiss.chartOptions.series[0].data = thiss.data.level
                        thiss.chartOptions.series[0].name = 'Water Level'
                        thiss.chartOptions.subtitle.text = 'Water Level'
                        thiss.chartOptions.yAxis.title.text = 'Height (Meter)'
                        thiss.chartOptions.series[0].tooltip = {
                            valueDecimals: 2,
                            valueSuffix: ' m'
                        }
                        break;
                    case '2':
                        thiss.chartOptions.series[0].data = thiss.data.temperature
                        thiss.chartOptions.series[0].name = 'Temperature'
                        thiss.chartOptions.series[0].name = 'Temperature'
                        thiss.chartOptions.subtitle.text = 'Temperature'
                        thiss.chartOptions.yAxis.title.text = 'Temperature °C'
                        thiss.chartOptions.series[0].color = 'red'
                        thiss.chartOptions.series[0].tooltip = {
                            valueDecimals: 2,
                            valueSuffix: ' °C'
                        }
                        thiss.chartOptions.series[0].fillColor = {
                            linearGradient: {
                                x1: 0,
                                y1: 0,
                                x2: 0,
                                y2: 1
                            },
                            stops: [
                                [0, 'red'], // Color at the top (positive values)
                                [
                                    1,
                                    Highcharts.color(Highcharts.getOptions().colors[0])
                                        .setOpacity(0)
                                        .get('rgba') // Transparent at the bottom (negative values)
                                ]
                            ]
                        }

                        this.chartOptions.series[0].negativeFillColor = {
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
                        break;
                    case '3':
                        thiss.setChartStyle();
                        thiss.chartOptions.series[0].data = thiss.data.humidity
                        thiss.chartOptions.series[0].name = 'Humidity'
                        thiss.chartOptions.subtitle.text = 'Humidity'
                        thiss.chartOptions.yAxis.title.text = 'Humidity °C'
                        thiss.chartOptions.series[0].tooltip = {
                            valueDecimals: 2,
                            valueSuffix: ' rh'
                        }
                        break;
                }
            }
        },
        // async fetchData() {
        //     const thiss = this
        //     try {
        //         await axios
        //             .get(`/api/getWaterLevelLatest/${this.id}`)
        //             .then((response) => {
        //                 console.log('latest: ', response);
        //                 switch (thiss.type) {
        //                     case '1':
        //                         thiss.data.level.push(response.data.level);
        //                         thiss.chartOptions.series[0].data.push(response.data.level);
        //                         console.log('type: ',thiss.type);
        //                         break;
        //                     case '2':
        //                         thiss.data.temperature.push(response.data.temperature);
        //                         thiss.chartOptions.series[0].data.push(response.data.temperature);
        //                         console.log('type: ',thiss.type);
        //                         break;
        //                     case '3':
        //                         thiss.data.humidity.push(response.data.humidity);
        //                         thiss.chartOptions.series[0].data.push(response.data.humidity);
        //                         console.log('type: ',thiss.type);
        //                         break;
        //                 }
        //                 console.log('chart: ',thiss.chartOptions.series[0].data);
        //             })
        //             .catch(function (error) {
        //                 console.error(error);
        //             });
        //     } catch (error) {
        //         console.error("Error fetching data:", error);
        //     }
        // },
    }
});
</script>
