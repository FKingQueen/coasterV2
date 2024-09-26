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
                    label: 'Tide Data'
                },
                {
                    value: '2',
                    label: 'Wave Characteristics'
                },

            ],
            type: '',
            chartOptions: {
                chart: {
                    zooming: { type: 'xy' },
                    // type: "spline", // Keep 'spline' if necessary
                    scrollablePlotArea: { minWidth: 200, scrollPositionX: 1 },
                },
                credits: {
                    text: '',

                },
                xAxis: [{
                    categories: [
                        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                    ],
                    crosshair: true,
                }],
                yAxis: [{ // Primary yAxis
                    labels: {
                        format: '{value}°C',
                        style: { color: Highcharts.getOptions().colors[1] }
                    },
                    title: {
                        text: 'Temperature',
                        style: { color: Highcharts.getOptions().colors[1] }
                    },
                    opposite: false // This keeps the primary axis on the left (default)
                }, { // Secondary yAxis
                    title: {
                        text: 'Precipitation',
                        style: { color: Highcharts.getOptions().colors[0] }
                    },
                    labels: {
                        format: '{value} mm',
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
                    name: 'Precipitation',
                    type: 'column',
                    yAxis: 1,
                    data: [45.7, 37.0, 28.9, 17.1, 39.2, 18.9, 90.2, 78.5, 74.6, 18.7, 17.1, 16.0],
                    tooltip: { valueSuffix: ' mm' },
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
                    name: 'Temperature',
                    type: 'spline',
                    data: [-11.4, -9.5, -14.2, 0.2, 7.0, 12.1, 13.5, 13.6, 8.2, -2.8, -12.0, -15.5],
                    tooltip: { valueSuffix: '°C' }
                }],
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
            switch (existingObj.type) {
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
                console.log(response);
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

                    existingObj.chartOptions.series[0].data[i][1] = Math.round(response.data.data[i].wave_height);
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
