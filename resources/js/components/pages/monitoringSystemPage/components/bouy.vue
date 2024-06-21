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
                    label: 'Wave Height'
                },
                {
                    value: '2',
                    label: 'Tide Height'
                },
                {
                    value: '3',
                    label: 'Wave Period'
                },
                {
                    value: '4',
                    label: 'Wave Power'
                },
                {
                    value: '5',
                    label: 'Wave Temperature'
                },
                {
                    value: '6',
                    label: 'Air Temperature'
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
                    selected: 5 // all
                },
                xAxis: {
                    type: "datetime",
                    labels: {
                        overflow: "justify",
                    },
                    title: {
                        text: 'DateTime'
                    },
                },
                yAxis: {
                    title: {
                        text: ''
                    },
                },
                series: [
                    {
                        name: null,
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
    methods: {
        afterSetExtremes(e) {
            const { chart } = e.target;
            chart.showLoading('Loading data from server...');
        },
        onChangeType(e){
            let existingObj = this;
            switch(existingObj.type) {
            case '1':
                for (let i = 0; i < existingObj.data.length; i++) {
                    existingObj.chartOptions.series[0].data[i][1] = Math.round(existingObj.data[i].wave_height);
                    existingObj.chartOptions.series[0].name = 'Wave Height'
                    existingObj.chartOptions.subtitle.text = 'Wave Height'
                    existingObj.chartOptions.yAxis.title.text = 'Wave Height'
                }
                break;
            case '2':
                for (let i = 0; i < existingObj.data.length; i++) {
                    existingObj.chartOptions.series[0].data[i][1] = Math.round(existingObj.data[i].tide_height);
                    existingObj.chartOptions.series[0].name = 'Wave Height'
                    existingObj.chartOptions.subtitle.text = 'Wave Height'
                    existingObj.chartOptions.yAxis.title.text = 'Wave Height'
                }
                break;
            case '3':
                for (let i = 0; i < existingObj.data.length; i++) {
                    existingObj.chartOptions.series[0].data[i][1] = Math.round(existingObj.data[i].wave_period);
                    existingObj.chartOptions.series[0].name = 'Wave Period'
                    existingObj.chartOptions.subtitle.text = 'Wave Period'
                    existingObj.chartOptions.yAxis.title.text = 'Wave Period'
                }
                break;
            case '4':
                for (let i = 0; i < existingObj.data.length; i++) {
                    existingObj.chartOptions.series[0].data[i][1] = Math.round(existingObj.data[i].wave_power);
                    existingObj.chartOptions.series[0].name = 'Wave Power'
                    existingObj.chartOptions.subtitle.text = 'Wave Power'
                    existingObj.chartOptions.yAxis.title.text = 'Wave Power'
                }
                break;
            case '5':
                for (let i = 0; i < existingObj.data.length; i++) {
                    existingObj.chartOptions.series[0].data[i][1] = Math.round(existingObj.data[i].wave_temperature);
                    existingObj.chartOptions.series[0].name = 'Wave Temperature'
                    existingObj.chartOptions.subtitle.text = 'Wave Temperature'
                    existingObj.chartOptions.yAxis.title.text = 'Wave Temperature'
                }
                break;
            case '6':
                for (let i = 0; i < existingObj.data.length; i++) {
                    existingObj.chartOptions.series[0].data[i][1] = Math.round(existingObj.data[i].air_temperature);
                    existingObj.chartOptions.series[0].name = 'Air Temperature'
                    existingObj.chartOptions.subtitle.text = 'Air Temperature'
                    existingObj.chartOptions.yAxis.title.text = 'Air Temperature'
                }
                break;
            }
            

        }
    },
    async mounted() {
        let existingObj = this;
        await axios
            .get(`/api/getBouy/${this.id}`)
            .then((response) => {
                for (let i = 0; i < response.data.data.length; i++) {
                    existingObj.chartOptions.series[0].data[i] = [];
                    existingObj.chartOptions.series[0].data[i][0] = Date.UTC(
                        response.data.data[i].date[0],
                        response.data.data[i].date[1]-1,
                        response.data.data[i].date[2],
                        response.data.data[i].date[3],
                        response.data.data[i].date[4],
                        response.data.data[i].date[5],
                    );

                    existingObj.chartOptions.series[0].data[i][1] =  Math.round(response.data.data[i].wave_height);
                }
                existingObj.type = '1';
                existingObj.data = response.data.data;
                
            })
            
            .catch(function (error) {
                console.error(error);
            });
    },
});
</script>
