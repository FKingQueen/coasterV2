<template>
    <div class="w-full h-full">
        <div class="flex w-full justify-between pb-1">
            <div class="text-center">
                <p v-if="this.id == 1" class="font-medium">Ilocos Norte</p>
                <p v-if="this.id == 2" class="font-medium">Ilocos Sur</p>
            </div>
            <div class="flex justify-center items-center">
                <!-- <Select :change="onChangeType()" size="small" v-model="type" style="width:200px">
                    <Option v-for="item in typeList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                </Select> -->
                <a-select ref="select" v-model:value="type" style="width: 120px" @change="onChangeType()">
                    <a-select-option value="1">Tide</a-select-option>
                    <a-select-option value="2">Temperature</a-select-option>
                    <a-select-option value="3">Wave Characteristics</a-select-option>
                </a-select>
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


export default defineComponent({
    props: ["id"],
    data() {
        return {
            sampleSeries: {
                type: 'windbarb',
                name: 'Wind Direction',
                color: 'white',
                lineWidth: 1.5,
                vectorLength: 15,
                tooltip: {
                    valueSuffix: 'Knots'
                }
            },
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
                    events: {
                        load: function () {
                            const thiss = this
                            const series = thiss.series[0];
                            setInterval(function () {
                                const id = thiss.userOptions.custom.id;
                                const type = thiss.userOptions.custom.type;
                                axios
                                    .get(`/api/getBuoyLatest/${id}`)
                                    .then((response) => {
                                        switch (type) {
                                            case '1':
                                                series.addPoint(response.data.tide, true, true);
                                                break;
                                            case '2':
                                                series.addPoint(response.data.temperature, true, true);
                                                break;
                                        }
                                    })
                                    .catch(function (error) {
                                        console.error(error);
                                    });
                            }, 60000);
                        }
                    },
                },
                // Store component reference and id in custom options
                custom: {
                    id: null,
                    type: null
                },
                credits: {
                    text: '',
                },
                // rangeSelector: {
                //     buttons: [
                //         { type: 'hour', count: 1, text: '1h' },
                //         { type: 'day', count: 1, text: '1d' },
                //         { type: 'week', count: 1, text: '1w' },
                //         { type: 'month', count: 1, text: '1m' },
                //         { type: 'year', count: 1, text: '1y' },
                //         { type: 'all', text: 'All' }
                //     ],
                //     selected: 0,
                //     inputEnabled: false,
                // },
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
                ],
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
    methods: {
        onChangeType(e) {

            
            let thiss = this;
            // inside onChangeType
            const chart = thiss.$refs.chart && thiss.$refs.chart.chart;
            if (chart && chart.xAxis && chart.xAxis[0]) {
                chart.xAxis[0].setExtremes(null, null);
            }
            thiss.chartOptions1.custom.type = thiss.type
            if (thiss.chartOptions1.series[0].data.length != 0) {
                switch (thiss.type) {
                    case '1':
                        thiss.setChartStyleTide();
                        thiss.fetched();
                        // thiss.chartOptions1.series[0].data = thiss.data.tide
                        console.log('series: ', thiss.chartOptions1.series);
                        break;
                    case '2':
                        thiss.setChartStyleTemp();
                        thiss.fetched();
                        // thiss.chartOptions1.series[0].data = thiss.data.temperature
                        console.log('series: ', thiss.chartOptions1.series);
                        break;
                    case '3':
                        console.log('data: ', thiss.data);
                
                        thiss.setChartStyleWave();
                        // thiss.chartOptions1.series[0].data = thiss.data.waveHeight
                        // thiss.chartOptions1.series[1].data = thiss.data.wavePeriod
                        console.log('series: ', thiss.chartOptions1.series);
                        // thiss.chartOptions1.series[2].data = thiss.data.compass
                        break;
                }
            }
        },
        // onChangeType(e) {
        //     let thiss = this;
        //     thiss.chartOptions1.custom.type = thiss.type
        //     if (thiss.chartOptions1.series[0].data.length != 0) {
        //         switch (thiss.type) {
        //             case '1':
        //                 thiss.setChartStyleTide();
        //                 thiss.fetched();

        //                 break;
        //             case '2':
        //                 thiss.setChartStyleTemp();
        //                 thiss.fetched();
        //                 break;
        //             case '3':
        //                 thiss.setChartStyleWave();
        //                 thiss.chartOptions1.series[0].data = thiss.data.waveHeight
        //                 thiss.chartOptions1.series[1].data = thiss.data.wavePeriod
        //                 // thiss.chartOptions1.series[2].data = thiss.data.compass
        //                 break;
        //         }
        //     }
        // },
        setChartStyleTide() {
            let thiss = this;

            // Remove
            // thiss.chartOptions1.series = Array.from({ length: 2 }, () => ({ name: '', data: [], type: '' }));
            // thiss.chartOptions1.series[0] = [];
            // thiss.chartOptions1.series[1] = [];

            

            // thiss.chartOptions1.rangeSelector.selected = 0
            console.log('range selector: ', thiss.chartOptions1.rangeSelector);
            thiss.chartOptions1.subtitle.text = 'Tide'
            thiss.chartOptions1.yAxis.title.text = 'Tide (Meter)'

            thiss.chartOptions1.series[0].type = 'areaspline'
            thiss.chartOptions1.series[0].name = 'Tide'
            thiss.chartOptions1.series[0].tooltip = {
                valueDecimals: 2,
                valueSuffix: ' cm'
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

            // data
            console.log('tide data: ', thiss.data);
            // thiss.chartOptions1.series[0].data = thiss.data.tide

            thiss.chartOptions1.series[0].setData(thiss.data.tide);
            console.log(thiss.chartOptions1.series);
        },
        setChartStyleTemp() {
            const thiss = this

            // thiss.chartOptions1.series = Array.from({ length: 3 }, () => ({ name: '', data: [], type: '' }));

            // Remove
            delete thiss.chartOptions1.series[0].fillColor;
            delete this.chartOptions1.series[0].negativeFillColor;

            // Both
            thiss.chartOptions1.subtitle.text = 'Temperature'
            thiss.chartOptions1.yAxis.title.text = 'Temperature °C'
            // thiss.chartOptions1.rangeSelector.selected = 0


            // Air Temperature
            thiss.chartOptions1.series[0].type = 'spline'
            thiss.chartOptions1.series[0].name = 'Air Temperature'
            thiss.chartOptions1.series[0].tooltip = {
                valueDecimals: 2,
                valueSuffix: '°C'
            }
            thiss.chartOptions1.series[0].color = '#FF0000'

            thiss.chartOptions1.series[0].setData(thiss.data.temperature);

        },
        setChartStyleWave() {
            const thiss = this;

            // thiss.chartOptions1.series = Array.from({ length: 3 }, () => ({ name: '', data: [], type: '' }));

            // thiss.chartOptions1.rangeSelector.selected = 3;
            console.log('range selector: ', thiss.chartOptions1.rangeSelector);

            // Significant Wave Height

            // thiss.chartOptions1.series[0].type = 'column'
            // thiss.chartOptions1.series[0].name = 'Significant Wave Height'
            // thiss.chartOptions1.series[0].color = Highcharts.getOptions().colors[0]
            // thiss.chartOptions1.series[0].tooltip = {
            //     valueDecimals: 2,
            //     valueSuffix: ' cm'
            // }

            // thiss.chartOptions1.series[0].data = thiss.data.waveHeight

            // thiss.chartOptions1.series[0] = {
            //     color: Highcharts.getOptions().colors[0],
            //     type: 'column',
            //     name: 'Significant Wave Height',
            //     data: thiss.data.waveHeight,
            //     tooltip: {
            //         valueDecimals: 2,
            //         valueSuffix: 'cm'
            //     }
            // };

            // Wave Period 
            
            thiss.chartOptions1.series[0].type = 'spline'
            thiss.chartOptions1.series[0].name = 'Wave Period'
            thiss.chartOptions1.series[0].color = Highcharts.getOptions().colors[0]
            thiss.chartOptions1.series[0].tooltip = {
                valueDecimals: 2,
                valueSuffix: 's'
            }

            thiss.chartOptions1.series[0].setData(thiss.data.wavePeriod);
            // thiss.chartOptions1.series[0].data = thiss.data.wavePeriod
            // thiss.chartOptions1.series[1] = {
            //     color: Highcharts.getOptions().colors[0],
            //     type: 'spline',
            //     name: 'Wave Period',
            //     data: thiss.data.wavePeriod,
            //     tooltip: {
            //         valueSuffix: 's',
            //         valueDecimals: 2
            //     }
            // };

            // compass
            // thiss.chartOptions1.series[2] = {
            //     type: 'windbarb',
            //     name: 'Wind Direction',
            //     id: 'windbarbs',
            //     color: 'black',
            //     lineWidth: 1.5,
            //     vectorLength: 15,
            //     data: thiss.data.compass,
            //     tooltip: {
            //         valueDecimals: 2,
            //         valueSuffix: 'Knots'
            //     }
            // };

            // Update chart subtitle and y-axis title
            thiss.chartOptions1.subtitle.text = 'Wave Characteristics';
            thiss.chartOptions1.yAxis.title.text = 'Wave Parameters';
        },
        async fetched() {
            let thiss = this;
            await axios
                .get(`/api/getBouy/${this.id}`)
                .then((response) => {
                    
                    thiss.data = response.data

                    thiss.loading = false
                })
                .catch(function (error) {
                    console.error(error);
                });
        },
    },
    async mounted() {
        let thiss = this;

        // this.chartOptions1.custom.component = this;
        this.chartOptions1.custom.id = this.id;

        await axios
            .get(`/api/getBouy/${this.id}`)
            .then((response) => {
                thiss.type = '3'
                thiss.data = response.data
                thiss.chartOptions1.custom.type = '3'

                thiss.setChartStyleWave();

                // Setting the Style of the Chart
                
                thiss.loading = false
            })
            .catch(function (error) {
                console.error(error);
            });
    }
});
</script>
