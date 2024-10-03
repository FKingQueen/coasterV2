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
        <highcharts v-if="type == '1'" class="hc w-full" :constructor-type="'stockChart'" :options="chartOptions1"
            ref="chart">
        </highcharts>
        <highcharts v-if="type == '2'" class="hc w-full" :constructor-type="'stockChart'" :options="chartOptions2"
            ref="chart">
        </highcharts>
        <highcharts v-if="type == '3'" class="hc w-full" :constructor-type="'stockChart'" :options="chartOptions3"
            ref="chart">
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
            chartOptions1: {
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
                    inputEnabled: true, // it supports only days
                    selected: 5 // all
                },
                xAxis: {
                    type: "datetime",
                    labels: {
                        overflow: "justify",
                    },
                },
                yAxis: {
                    title: {
                        text: 'Tide Height (Meter)'
                    },
                },
                series: [
                    {
                        name: "Tide Height (meter)",
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
            chartOptions2: {
                chart: {
                    zoomType: 'x',
                    type: 'spline',
                    scrollablePlotArea: {
                        minWidth: 200,
                        scrollPositionX: 1
                    }
                },
                credits: {
                    text: ''
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
                    inputEnabled: true,
                    selected: 5 // Default selection (All)
                },
                xAxis: {
                    type: 'datetime',
                    labels: {
                        overflow: 'justify'
                    }
                },
                yAxis: [{
                    // Left Y-Axis for Tide Height in meters
                    title: {
                        text: ''
                    },
                    labels: {
                        format: ''
                    },
                }, {
                    // Right Y-Axis for Temperature in °C
                    title: {
                        text: 'Temperature (°C)'
                    },
                    labels: {
                        format: '{value}°C'
                    },
                    opposite: true // Right side
                }],
                series: [{
                    name: 'Air Temperature',
                    data: [], // Data to be dynamically loaded
                    tooltip: {
                        valueDecimals: 2,
                        valueSuffix: '°C'
                    },
                    color: '#FF774F',
                    yAxis: 1 // Right axis (Temperature)
                }, {
                    name: 'Water Temperature',
                    data: [], // Data to be dynamically loaded
                    tooltip: {
                        valueDecimals: 2,
                        valueSuffix: '°C'
                    },
                    color: '#FF0000',
                    yAxis: 1 // Right axis (Temperature)
                }],
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
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
                    }
                }
            },
            chartOptions3: {
                chart: {
                    zooming: { type: 'xy' },
                    // type: "spline", // Keep 'spline' if necessary
                    scrollablePlotArea: { minWidth: 200, scrollPositionX: 1 },
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
                    inputEnabled: true,
                    selected: 5 // Default selection (All)
                },
                yAxis: [{ // Primary yAxis
                    labels: {
                        format: '{value} s',
                        style: { color: Highcharts.getOptions().colors[1] }
                    },
                    title: {
                        text: 'Wave Period',
                        style: { color: Highcharts.getOptions().colors[1] }
                    },
                    opposite: false // This keeps the primary axis on the left (default)
                }, { // Secondary yAxis
                    title: {
                        text: 'Significant Wave Height',
                        style: { color: Highcharts.getOptions().colors[0] }
                    },
                    labels: {
                        format: '{value} m',
                        style: { color: Highcharts.getOptions().colors[0] }
                    },
                    opposite: true
                }],
                tooltip: { shared: true },
                legend: {
                    align: 'left',
                    verticalAlign: 'top',
                    backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'rgba(255,255,255,0.25)',
                },
                series: [{
                    name: 'Significant Wave Height',
                    type: 'column',
                    yAxis: 1,
                    data: [],
                    tooltip: { valueSuffix: 'm', valueDecimals: 2 },
                    dataLabels: {
                        enabled: true,
                        useHTML: true,
                        formatter: function () {
                            // Custom HTML content for each data label (icon)
                            return '<img src="https://www.smashingmagazine.com/2016/05/easy-steps-to-better-logo-design/" width="20" height="20"/>';
                        },
                        align: 'center',  // Center-align the icon above the bar
                        verticalAlign: 'top',  // Position the icon at the top of the bar
                        y: -300  // Adjust the vertical position to place the icon above the top
                    }
                }, {
                    name: 'Wave Period',
                    type: 'spline',
                    data: [],
                    tooltip: { valueSuffix: 's', valueDecimals: 2 }
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
                    }
                }
            },
        };
    },
    methods: {
        afterSetExtremes(e) {
            const { chart } = e.target;
            chart.showLoading('Loading data from server...');
        },
        onChangeType(e) {
            let existingObj = this;
            console.log(existingObj.type);
            switch (existingObj.type) {
                case '1':
                    break;
                case '2':
                    break;
            }


        }
    },
    async mounted() {
        let existingObj = this;
        existingObj.type = '1';
        await axios
            .get(`/api/getBouy/${this.id}`)
            .then((response) => {
                console.log('buoy: ', response.data);
                for (let i = 0; i < response.data.data.length; i++) {
                    // Tide Chart
                    existingObj.chartOptions1.series[0].data[i] = [];

                    let lastD = response.data.data[i].date[4] % 10; 
                    if(lastD === 3 || lastD === 4 || lastD === 6 || lastD === 7){
                        response.data.data[i].date[4] = response.data.data[i].date[4] - lastD;
                        response.data.data[i].date[4] = response.data.data[i].date[4] - 5;
                    } 
                    if(lastD === 1 || lastD === 2 || lastD === 8 || lastD === 9){
                        response.data.data[i].date[4] = response.data.data[i].date[4] - lastD;
                    } 

                    existingObj.chartOptions1.series[0].data[i][0] = Date.UTC(
                        response.data.data[i].date[0],
                        response.data.data[i].date[1] - 1,
                        response.data.data[i].date[2],
                        response.data.data[i].date[3],
                        response.data.data[i].date[4],
                        response.data.data[i].date[5],
                    );

                    // pressure = 100046.05 * (1 - altitude / 44330) ^ (1 / 0.1903)
                    // new altitude =(44330 * (1 - (pressure / 101325) ^ 0.1903)) / 100
                    // new altitude - the average data from the last data of 24 hours = 288, 5 mins interval in 24 hours
                    let pressure = 100046.05 * Math.pow(1 - response.data.data[i].altitude_pressure / 44330, 1 / 0.1903);
                    // let newAltitude = (44330 * (1 - Math.pow(pressure / 101325, 0.1903))) / 100;
                    let tide = -(pressure - 101325) / (1025 * 9.81);
                    // let sum = 0;
                    // let count = 0;

                    // for (let j = Math.max(i - 288 + 1, 0); j <= i; j++) {
                    //     let getAvetide = 100046.05 * Math.pow(1 - response.data.data[j].altitude_pressure / 44330, 1 / 0.1903);
                    //     sum += (44330 * (1 - Math.pow(getAvetide / 101325, 0.1903))) / 100;
                    //     count++;
                    // }

                    // let averageRecentData = sum / count;

                    // existingObj.chartOptions1.series[0].data[i][1] = tide - averageRecentData;
                    existingObj.chartOptions1.series[0].data[i][1] = tide;
                    // Tide Chart END

                    // Temp Chart
                    existingObj.chartOptions2.series[0].data[i] = [];
                    existingObj.chartOptions2.series[1].data[i] = [];
                    existingObj.chartOptions2.series[0].data[i][0] = existingObj.chartOptions1.series[0].data[i][0]
                    existingObj.chartOptions2.series[0].data[i][1] = response.data.data[i].air_temperature;
                    existingObj.chartOptions2.series[1].data[i][0] = existingObj.chartOptions1.series[0].data[i][0]
                    existingObj.chartOptions2.series[1].data[i][1] = response.data.data[i].water_temperature;
                    // Temp Chart END

                    // Wave Chart
                    existingObj.chartOptions3.series[0].data[i] = [];
                    existingObj.chartOptions3.series[1].data[i] = [];
                    existingObj.chartOptions3.series[0].data[i][0] = existingObj.chartOptions1.series[0].data[i][0]
                    existingObj.chartOptions3.series[0].data[i][1] = response.data.data[i].significant_wave_height;
                    existingObj.chartOptions3.series[1].data[i][0] = existingObj.chartOptions1.series[0].data[i][0]
                    existingObj.chartOptions3.series[1].data[i][1] = response.data.data[i].wave_period;
                    // Wave Chart END
                }
                // existingObj.type = '1';
                existingObj.data = response.data.data;

            })


            .catch(function (error) {
                console.error(error);
            });


    },
});
</script>
