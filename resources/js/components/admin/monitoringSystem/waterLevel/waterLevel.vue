<template>
    <div class="w-full h-full">
        <div class="flex w-full justify-around">
            <div class="w-2/4 text-center">
                <p v-if="this.id == 1" class="text-lg font-medium">Ilocos Norte</p>
                <p v-if="this.id == 2" class="text-lg font-medium">Ilocos Sur</p>
            </div>
            <div class="w-2/4 flex justify-center items-center">
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
                    type: "spline",
                    scrollablePlotArea: {
                        minWidth: 200,
                        scrollPositionX: 1,
                    },
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
                    selected: 0 // all
                                
                },
                xAxis: {
                    type: "datetime",
                    labels: {
                        overflow: "justify",
                    },
                    title: {
                        text: 'DateTime'
                    },
                    ordeals: true,
                },
                yAxis: {
                    title: {
                        text: ''
                    },
                },
                series: [
                    {
                        name: "WaterLevel",
                        data: [],
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
            let thiss = this;
            thiss.chartOptions.series[0].data = [];
            const headers = {
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            try {
                await axios
                    .get(`/api/admin/getWaterLevel/${this.id}`, { headers })
                    .then((response) => {
                        if (response.data.data.length != 0) {
                            for (let i = 0; i < response.data.data.length; i++) {

                                thiss.chartOptions.series[0].data[i] = [];
                                thiss.chartOptions.series[0].data[i][0] = Date.UTC(
                                    response.data.data[i].date[0],
                                    response.data.data[i].date[1] - 1,
                                    response.data.data[i].date[2],
                                    response.data.data[i].date[3],
                                    response.data.data[i].date[4],
                                    response.data.data[i].date[5],
                                );
                            }
                            thiss.type = '1';
                            thiss.data = response.data.data;
                            // console.log(thiss.chartOptions.rangeSelector.selected = 0);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            } catch (error) {
                console.error('Error fetching data:', error);
                // Handle errors (e.g., display an error message)
            }
        },
        onChangeType(e) {
            let thiss = this;
            if (thiss.chartOptions.series[0].data.length != 0) {

                switch (thiss.type) {
                    case '1':
                        for (let i = 0; i < thiss.data.length; i++) {
                            if (thiss.id == 1) {
                                thiss.chartOptions.series[0].data[i][1] = Math.round((13.5 - thiss.data[i].level) * 100) / 100;
                            }
                            if (thiss.id == 2) {
                                thiss.chartOptions.series[0].data[i][1] = Math.round((26 - thiss.data[i].level) * 100) / 100;
                            }
                            // Ensure xAxis is an object and update properties reactively
                            // thiss.xAxisMax = 1741083120000
                            // thiss.xAxisMin = 1741083120000 - 1 * 60 * 60 * 1000

                           
                            thiss.chartOptions.series[0].name = 'Water Level'
                            thiss.chartOptions.subtitle.text = 'Water Level'
                            thiss.chartOptions.yAxis.title.text = 'Height (Meter)'
                        }
                        break;
                    case '2':
                        for (let i = 0; i < thiss.data.length; i++) {
                            thiss.chartOptions.series[0].data[i][1] = Math.round((thiss.data[i].temperature) * 100) / 100;
                            thiss.chartOptions.series[0].name = 'Temperature'
                            thiss.chartOptions.subtitle.text = 'Temperature'
                            thiss.chartOptions.yAxis.title.text = 'Temperature'
                        }
                        break;
                    case '3':
                        for (let i = 0; i < thiss.data.length; i++) {
                            thiss.chartOptions.series[0].data[i][1] = Math.round((thiss.data[i].humidity) * 100) / 100;
                            thiss.chartOptions.series[0].name = 'Humidity'
                            thiss.chartOptions.subtitle.text = 'Humidity'
                            thiss.chartOptions.yAxis.title.text = 'Humidity'
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
