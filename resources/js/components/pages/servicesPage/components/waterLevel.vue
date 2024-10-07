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
        <highcharts class="hc w-full" :constructor-type="'stockChart'" :options="chartOptions" ref="chart">
        </highcharts>
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
            chartOptions: {
                chart: {
                    zoomType: 'x',
                    type: "areaspline",
                    scrollablePlotArea: {
                        minWidth: 200,
                        scrollPositionX: 1,
                    },

                },
                credits: {
                    text: '',
                },
                rangeSelector: {
                    buttons: [{
                        type: 'hour',
                        count: 1,
                        text: '1h'
                    }, {
                        type: 'day',
                        count: 1,
                        text: '1d'
                    }, {
                        type: 'week',
                        count: 1,
                        text: '1w'
                    }, {
                        type: 'month',
                        count: 1,
                        text: '1m'
                    }, {
                        type: 'year',
                        count: 1,
                        text: '1y'
                    }, {
                        type: 'all',
                        text: 'All'
                    }],
                    selected: 5 , // Default to 1 hour
                },
                xAxis: {
                    type: "datetime",
                    labels: {
                        overflow: "justify",
                    },
                },
                yAxis: {
                    title: {
                        text: ''
                    },
                },
                series: [
                    {
                        name: "WaterLevel",
                        data: [],  // your data will be filled dynamically
                        tooltip: {
                            valueDecimals: 2
                        },
                        threshold: 0,  // Set the threshold at 0 for negative values handling
                        fillColor: {
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
                        },
                        negativeFillColor: {
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
                        },
                    },
                ],
                title: {
                    text: "",
                },
                subtitle: {
                    text: "",
                },
                // plotOptions: {
                //     series: {
                //         pointStart: Date.UTC(2010, 0, 1),
                //         marker: {
                //             enabled: false,
                //             states: {
                //                 hover: {
                //                     enabled: false
                //                 }
                //             }
                //         }
                //     },
                // },
            },
        };
    },
    watch: {
        id: {
            immediate: true, // Trigger the watcher immediately when the component is created
            handler() {
                this.fetchDataFromApi(); // Call a method to fetch data from the API with the new ID
            }
        }
    },
    methods: {
        async fetchDataFromApi() {
            let existingObj = this;

            existingObj.chartOptions.series[0].data = [];
            try {
                await axios
                    .get(`/api/getWaterLevel/${this.id}`)
                    .then((response) => {
                        console.log('b: ', response);
                        if (response.data.data.length != 0) {
                            for (let i = 0; i < response.data.data.length; i++) {
                                existingObj.chartOptions.series[0].data[i] = [];
                                existingObj.chartOptions.series[0].data[i][0] = Date.UTC(
                                    response.data.data[i].date[0],
                                    response.data.data[i].date[1] - 1,
                                    response.data.data[i].date[2],
                                    response.data.data[i].date[3],
                                    response.data.data[i].date[4],
                                    response.data.data[i].date[5],
                                );
                                if (existingObj.id == 1) {
                                    existingObj.chartOptions.series[0].data[i][1] = Math.round((12.5 - response.data.data[i].level) * 100) / 100;
                                }
                                if (existingObj.id == 2) {
                                    existingObj.chartOptions.series[0].data[i][1] = Math.round((26 - response.data.data[i].level) * 100) / 100;
                                }

                            }
                            existingObj.type = '1';
                            existingObj.data = response.data.data;
                        }
                    })

                    .catch(function (error) {
                        console.error(error);
                    });
                // console.log('wlms:', existingObj.chartOptions);
            } catch (error) {
                console.error('Error fetching data:', error);
                // Handle errors (e.g., display an error message)
            }
        },
        afterSetExtremes(e) {
            const { chart } = e.target;
            chart.showLoading('Loading data from server...');
        },
        onChangeType(e) {
            let existingObj = this;
            if (existingObj.chartOptions.series[0].data.length != 0) {

                switch (existingObj.type) {
                    case '1':
                        for (let i = 0; i < existingObj.data.length; i++) {
                            if (existingObj.id == 1) {
                                existingObj.chartOptions.series[0].data[i][1] = Math.round((13.5 - existingObj.data[i].level) * 100) / 100;
                            }
                            if (existingObj.id == 2) {
                                existingObj.chartOptions.series[0].data[i][1] = Math.round((26 - existingObj.data[i].level) * 100) / 100;
                            }

                            existingObj.chartOptions.series[0].name = 'Water Level'
                            existingObj.chartOptions.subtitle.text = 'Water Level'
                            existingObj.chartOptions.yAxis.title.text = 'Height (Meter)'
                        }
                        break;
                    case '2':
                        for (let i = 0; i < existingObj.data.length; i++) {
                            existingObj.chartOptions.series[0].data[i][1] = Math.round((existingObj.data[i].temperature) * 100) / 100;
                            existingObj.chartOptions.series[0].name = 'Temperature'
                            existingObj.chartOptions.subtitle.text = 'Temperature'
                            existingObj.chartOptions.yAxis.title.text = 'Temperature'
                        }
                        break;
                    case '3':
                        for (let i = 0; i < existingObj.data.length; i++) {
                            existingObj.chartOptions.series[0].data[i][1] = Math.round((existingObj.data[i].humidity) * 100) / 100;
                            existingObj.chartOptions.series[0].name = 'Humidity'
                            existingObj.chartOptions.subtitle.text = 'Humidity'
                            existingObj.chartOptions.yAxis.title.text = 'Humidity'
                        }
                        break;
                }
            }


        }
    },

    async mounted() {

    },
});
</script>
