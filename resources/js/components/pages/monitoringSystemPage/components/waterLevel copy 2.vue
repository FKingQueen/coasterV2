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
        <div v-if="loading" class="loading-spinner">
            Loading...
        </div>
        <highcharts v-else class="hc w-full" :constructor-type="'stockChart'" :options="chartOptions">
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
            loading: true,
            chartOptions: {
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
                // xAxis: {
                //     events: {
                //         afterSetExtremes: (e) => {
                //             console.log('Range Selector Event:', e);
                //             console.log(e.rangeSelectorButton.type);
                //             if(e.rangeSelectorButton.type == 'year'){
                //                 console.log(e.rangeSelectorButton.type);
                //             }
                //             if(e.rangeSelectorButton.type == 'all'){
                //                 console.log(e.rangeSelectorButton.type);
                //             }
                //         }
                //     }
                // },
                title: {
                    text: "",
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
                    name: 'AAPL Stock Price',
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
            }

        };
    },
    async mounted() {
        let thiss = this;
        await axios
            .get(`/api/getWaterLevel/${this.id}`)
            .then((response) => {
                console.log(response);
                thiss.type = '1'
                thiss.data = response.data
                
                // Setting the Style of the Chart
                thiss.setChartStyle();
                thiss.loading = false
            })
            .catch(function (error) {
                console.error(error);
                this.loading = false
            });
    },
    methods: {
        setChartStyle() {
            let thiss = this; 

            thiss.chartOptions.series[0].type = "areaspline"
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
            this.chartOptions.series[0].name = "WaterLevel";
        },
        onChangeType(e) {
            let thiss = this;
            console.log(e);
            if (thiss.chartOptions.series[0].data.length != 0) {
                switch (thiss.type) {
                    case '1':
                        for (let i = 0; i < thiss.data.length; i++) {
                            thiss.chartOptions.series[0].data = data.level
                            thiss.chartOptions.series[0].name = 'Water Level'
                            thiss.chartOptions.subtitle.text = 'Water Level'
                            thiss.chartOptions.yAxis.title.text = 'Height (Meter)'
                        }
                        break;
                    case '2':
                        for (let i = 0; i < thiss.data.length; i++) {
                            thiss.chartOptions.series[0].data = data.temperature
                            thiss.chartOptions.series[0].name = 'Temperature'
                            thiss.chartOptions.subtitle.text = 'Temperature'
                            thiss.chartOptions.yAxis.title.text = 'Temperature'
                        }
                        break;
                    case '3':
                        for (let i = 0; i < thiss.data.length; i++) {
                            thiss.chartOptions.series[0].data = data.humidity
                            thiss.chartOptions.series[0].name = 'Humidity'
                            thiss.chartOptions.subtitle.text = 'Humidity'
                            thiss.chartOptions.yAxis.title.text = 'Humidity'
                        }
                        break;
                }
            }
        }
    }
});
</script>
