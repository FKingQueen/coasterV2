<template>
    <div class="w-full flex">
        <div ref="map" class="full-screen-map h-[90vh]">

            <!-- Filter Option -->
            <div class="filter-option">
                <div class=" text-white text-sm rounded-md grid grid-cols-1 bg-white p-5 space-y-3">
                    <div class="text-black text-blue-800">
                        FILTER OPTION

                    </div>
                    <!-- Layer Name -->
                    <div>
                        <span class="text-black block">Layer Name: </span>
                        <div class="flex">
                            <div>
                                <Select v-model="layerName" :disabled="layerNameLoading" style="width:200px"
                                    size="small" placeholder="Select Layer Name" @on-change="handleLayerNameChange()">
                                    <OptionGroup label="Coastal Erosion Hazard Maps">
                                        <Option v-for="item in this.CEHM" :value="item.value" :key="item.value">{{
                                            item.label }}
                                        </Option>
                                    </OptionGroup>
                                    <OptionGroup label="Coastal Flood Hazard Maps">
                                        <Option v-for="item in this.CFHM" :value="item.value" :key="item.value">{{
                                            item.label }}
                                        </Option>
                                    </OptionGroup>
                                </Select>
                            </div>
                            <div class="text-black text-blue-800 pl-5">
                                <LoadingOutlined v-if="layerNameLoading" />
                            </div>
                        </div>
                    </div>
                    <!-- /Layer Name -->
                    <!-- Province Name -->
                    <div v-if="this.provOptions != null">
                        <span class="text-black block">Province: </span>
                        <div class="flex">
                            <div>
                                <Select v-model="provinceName" :disabled="provinceNameLoading" style="width:200px"
                                    size="small" placeholder="Select Province Name"
                                    @on-change="handleProvinceNameChange()">
                                    <Option v-for="item in provOptions" :value="item.value" :key="item.value">{{
                                        item.label
                                        }}</Option>
                                </Select>
                            </div>
                            <div class="text-black text-blue-800 pl-5">
                                <LoadingOutlined v-if="provinceNameLoading" />
                            </div>
                        </div>
                    </div>
                    <!-- /Province Name -->
                    <!-- MuniCities Name -->
                    <div v-if="this.muniOptions != null">
                        <span class="text-black block">Municipalities/Cities: </span>
                        <div class="flex">
                            <div>
                                <Select v-model="muniName" :disabled="muniNameLoading" style="width:200px" size="small"
                                    placeholder="Select Municipality/City Name" @on-change="handleMuniNameChange()">
                                    <Option v-for="item in muniOptions" :value="item.value" :key="item.value">{{
                                        item.label
                                        }}</Option>
                                </Select>
                            </div>
                            <div class="text-black text-blue-800 pl-5">
                                <LoadingOutlined v-if="muniNameLoading" />
                            </div>
                        </div>
                    </div>
                    <!-- /MuniCities Name -->
                    <!-- Barangays Name -->
                    <div v-if="this.brgyOptions != null">
                        <span class="text-black block">Barangays: </span>
                        <div class="flex">
                            <div>
                                <Select v-model="brgyName" :disabled="brgyNameLoading" style="width:200px" size="small"
                                    placeholder="Select Barangay Name" @on-change="handleBrgyNameChange()">
                                    <Option v-for="item in brgyOptions" :value="item.value" :key="item.value">{{
                                        item.label
                                        }}</Option>
                                </Select>
                            </div>
                            <div class="text-black text-blue-800 pl-5">
                                <LoadingOutlined v-if="brgyNameLoading" />
                            </div>
                        </div>
                    </div>
                    <!-- /Barangays Name -->
                </div>
            </div>
            <!-- /Filter Option -->

            <!-- Results -->
            <div class="result">
                <div class=" text-white text-sm rounded-md grid grid-cols-1 bg-white p-5 space-y-3">
                    <div class="text-black text-blue-800">
                        RESULTS
                    </div>
                    <div class="w-96 ">
                        <Alert show-icon class="opacity-75" v-if="resultLoading == null && layerName == null">
                            Disclaimer
                            <template #desc>
                                The data presented here is based on research and analysis conducted by the
                                CoastEr Program. It may not conform to the standards or quality control procedures
                                associated with official government or industry data sources.
                            </template>
                        </Alert>
                        <div class="w-full flex justify-center">
                            <a-spin v-if="resultLoading == true" :indicator="indicator" />
                        </div>
                        <div v-if="resultLoading == false">
                            <highcharts :options="this.chartOptions"></highcharts>
                            <p class="opacity-75 text-blue-800" @click="modalVisibleData = true">more...</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Results -->

            <!-- Legend -->
            <div class="legend-bottom">
                <div class=" text-white text-sm rounded-md grid grid-cols-1 bg-white p-5">
                    <div class="text-black text-blue-800">
                        LEGEND
                    </div>
                    <div class="flex justify-start space-x-2">
                        <div class="items-center flex">
                            <span class="h-3 w-4 border border-black"
                                style="background-color: blue; display: inline-block;"></span>
                        </div>
                        <div class="text-justify w-full text-black">Accreting</div>
                    </div>
                    <div class="flex justify-start space-x-2">
                        <div class="items-center flex">
                            <span class="h-3 w-4 border" style="background-color: red; display: inline-block;"></span>
                        </div>
                        <div class="text-justify w-full text-black">Eroded</div>
                    </div>
                    <div class="flex justify-start space-x-2">
                        <div class="items-center flex">
                            <span class="h-3 w-4 border" style="background-color: green; display: inline-block;"></span>
                        </div>
                        <div class="text-justify w-full text-black">Stable</div>
                    </div>
                </div>
            </div>
            <!-- /Legend -->

            <!-- Modal -->
            <a-modal v-model:open="modalVisibleData" title="Data" width="1000px">
                <template #footer>
                    <a-button key="back" @click="handleClose">Close</a-button>
                </template>
                <a-table v-if="modalVisibleData" :columns="columns" :data-source="this.properties"
                    :pagination="{ pageSize: 50 }" :scroll="{ y: 240 }" />
            </a-modal>
            <!-- /Modal -->

        </div>
    </div>
</template>

<script>
// Vue Libraries
import { defineComponent, ref, nextTick, h } from 'vue';
// OpenLayers Libraries
import {
    HomeOutlined,
    SettingFilled,
    SmileOutlined,
    SyncOutlined,
    LoadingOutlined,
} from '@ant-design/icons-vue';

import "ol/ol.css";
import Map from "ol/Map";
import View from "ol/View";
import TileLayer from "ol/layer/Tile";
import FullScreen from "ol/control/FullScreen";
import { fromLonLat } from 'ol/proj';
import { Fill, Style, Stroke } from "ol/style";
import VectorLayer from "ol/layer/Vector"; // Correct import statement
import VectorSource from "ol/source/Vector"; // Add VectorSource import
import { XYZ } from "ol/source";
import GeoJSON from 'ol/format/GeoJSON';

import * as ol from 'ol'; // Add this line
import { extend as extentExtend } from 'ol/extent';
// Components
export default defineComponent({
    components: {
        LoadingOutlined,
    },
    setup() {
        const indicator = h(LoadingOutlined, {
            style: {
                fontSize: '50px',
            },
            spin: true,
        });

        const columns = [{
            title: 'Province',
            dataIndex: 'NAME_1',
            width: 50,
        }, {
            title: 'Municipality/City',
            dataIndex: 'NAME_2',
            width: 50,
        }, {
            title: 'Barangay',
            dataIndex: 'NAME_3',
            width: 50,
        }, {
            title: 'EPR',
            dataIndex: 'EPR',
            width: 50,
        }, {
            title: 'EPR_UNC',
            dataIndex: 'EPR_unc',
            width: 50,
        }, {
            title: 'EPR_Trend',
            dataIndex: 'EPR_trend',
            width: 50,
        }];

        return {
            indicator,
            columns,
        };
    },
    data() {
        // Options/Select
        const CEHM = [
            {
                value: 'epr',
                label: 'EPR 1977-2022'
            },
            {
                value: 'nsm',
                label: 'NSM 1977-2022'
            }
        ];
        const CFHM = [
            {
                value: 'laoagRiver',
                label: 'Laoag River'
            },
            {
                value: 'abraRiver',
                label: 'Abra River'
            }
        ];


        return {
            modalVisibleData: false,
            properties: [],
            map: null,
            layerName: null,
            provinceName: null,
            muniName: null,
            brgyName: null,

            // LayerName Option
            CEHM,
            CFHM,
            provOptions: null,
            muniOptions: null,
            brgyOptions: null,

            // HighChart
            chartOptions: {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: '',
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        borderWidth: 2,
                        innerSize: '40%',
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b><br>{point.y}%',
                            distance: 50
                        }
                    },
                    series: {
                        animation: true
                    }
                },
                tooltip: {
                    headerFormat: '',
                    pointFormat: ''
                },
                series: [
                    {
                        name: 'Percentage',
                        colorByPoint: true,
                        data: []
                    }
                ]
            },

            // lazy loading
            brgyNameLoading: false,
            muniNameLoading: false,
            provinceNameLoading: false,
            layerNameLoading: false,

            resultLoading: null,

        }
    },
    async mounted() {
        this.initializeMap();
    },
    methods: {
        initializeMap() {
            this.map = new Map({
                target: this.$refs.map,
                layers: [
                    new TileLayer({
                        source: new XYZ({
                            url: "https://api.mapbox.com/styles/v1/pcborja/clt6utkbc00g801raamfl71ab/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoicGNib3JqYSIsImEiOiJjbG5sZm9weGIxYzg4MmxtbmpqYjd2YXIxIn0.LmH0x1Rn3NDzJdzq3J6Ayg",
                            // url: "https://api.mapbox.com/styles/v1/pcborja/clp6yp9ex00e201rcgbj618ge/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoicGNib3JqYSIsImEiOiJjbG5sZm9weGIxYzg4MmxtbmpqYjd2YXIxIn0.LmH0x1Rn3NDzJdzq3J6Ayg",
                            // url: "http://10.40.2.79/eyy/{z}/{x}_{y}.png",
                        }),
                    }),
                ],
                view: new View({
                    center: fromLonLat([121.007046, 17.156009]),
                    zoom: 8,
                }),
                controls: [new FullScreen()],
            });


        },
        handleClose() {
            this.modalVisibleData = false;
        },

        async handleLayerNameChange() {

            const thiss = this;
            thiss.layerNameLoading = true;
            thiss.resultLoading = true;
            thiss.provOptions = null;
            this.muniOptions = null;
            this.brgyOptions = null;
            thiss.provinceName = null;

            const form = {
                layerName: this.layerName
            }

            await axios.post(`/api/getLayerData`, form)
                .then(function (response) {
                    var layers = thiss.map.getLayers();

                    thiss.properties = response.data.properties;

                    // Remove layers starting from index 1
                    for (var i = layers.getLength() - 1; i > 0; i--) {
                        var layer = layers.item(i);
                        thiss.map.removeLayer(layer);
                    }
                    // Create a new VectorLayer with GeoJSON features and style
                    const Region1_Boundaries = new VectorLayer({
                        source: new VectorSource({
                            format: new GeoJSON(),
                            features: new GeoJSON().readFeatures(response.data.Region1_Province, {
                                featureProjection: 'EPSG:3857' // Projection of your map
                            }),
                            crossOrigin: 'anonymous', // Add this line
                        }),
                    });
                    thiss.map.addLayer(Region1_Boundaries);

                    const dataGeojson = new VectorLayer({
                        source: new VectorSource({
                            format: new GeoJSON(),
                            features: new GeoJSON().readFeatures(response.data.data, {
                                featureProjection: 'EPSG:3857' // Projection of your map
                            }),
                            crossOrigin: 'anonymous', // Add this line
                        }),
                        style: (feature) => {
                            const validation = thiss.layerName === 'epr' ? 'EPR_trend' : 'NSM_trend'
                            const propertyValue = feature.get(validation);
                            const fillColor = propertyValue === 'stable' ? 'green'
                                : (propertyValue === 'erosion' ? 'red' : 'blue');
                            const strokeColor = propertyValue === 'stable' ? 'green'
                                : (propertyValue === 'erosion' ? 'red' : 'blue');
                            return new Style({
                                fill: new Fill({
                                    color: fillColor,
                                }),
                                stroke: new Stroke({
                                    color: strokeColor,
                                    width: 1.5,
                                }),
                            });
                        },
                    });
                    thiss.map.addLayer(dataGeojson);
                    thiss.chartOptions.series[0].data = response.data.chartData

                    if (thiss.layerName == 'epr') {
                        thiss.chartOptions.title.text = 'End Point Rate (m/yr)'
                    }
                    if (thiss.layerName == 'nsm') {
                        thiss.chartOptions.title.text = 'Net Shoreline Movement (m)'
                    }
                    thiss.chartOptions.subtitle.text = 'Provinces'
                    thiss.provOptions = response.data.Options
                    thiss.chartOptions.tooltip.pointFormat = '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
                        'Accreting: <b>{point.x}%</b><br/>' +
                        'Eroded: <b>{point.z}%</b><br/>' +
                        'Stable: <b>{point.t}%</b><br/>'

                    const extent = Region1_Boundaries.getSource().getExtent();

                    // Fit the map view to the extent with padding
                    thiss.map.getView().fit(extent, thiss.map.getSize());

                    thiss.layerNameLoading = false;
                    thiss.resultLoading = false;


                })
                .catch(function (error) {
                    console.error(error);
                });

        },
        async handleProvinceNameChange() {
            const thiss = this;
            thiss.provinceNameLoading = true;
            thiss.resultLoading = true;
            this.muniOptions = null;
            this.brgyOptions = null;
            thiss.muniName = null;

            const form = {
                layerName: thiss.layerName,
                provinceName: thiss.provinceName
            }

            await axios.post(`/api/getProvinceData`, form)
                .then(function (response) {

                    thiss.properties = response.data.properties

                    var layers = thiss.map.getLayers();

                    // Remove layers starting from index 1
                    for (var i = layers.getLength() - 1; i > 0; i--) {
                        var layer = layers.item(i);
                        thiss.map.removeLayer(layer);
                    }

                    // Create a new VectorLayer with GeoJSON features and style
                    const Province_Boundary = new VectorLayer({
                        source: new VectorSource({
                            format: new GeoJSON(),
                            features: new GeoJSON().readFeatures(response.data.Region1_Province_GeojsonData, {
                                featureProjection: 'EPSG:3857' // Projection of your map
                            }),
                            crossOrigin: 'anonymous', // Add this line
                        }),
                    });
                    thiss.map.addLayer(Province_Boundary);

                    // Create a new VectorLayer with GeoJSON features and style
                    const MuniCities_Boundary = new VectorLayer({
                        source: new VectorSource({
                            format: new GeoJSON(),
                            features: new GeoJSON().readFeatures(response.data.Region1_MuniCities_GeojsonData, {
                                featureProjection: 'EPSG:3857' // Projection of your map
                            }),
                            crossOrigin: 'anonymous', // Add this line
                        }),
                    });
                    thiss.map.addLayer(MuniCities_Boundary);

                    const dataGeojson = new VectorLayer({
                        source: new VectorSource({
                            format: new GeoJSON(),
                            features: new GeoJSON().readFeatures(response.data.data, {
                                featureProjection: 'EPSG:3857' // Projection of your map
                            }),
                            crossOrigin: 'anonymous', // Add this line
                        }),
                        style: (feature) => {
                            const validation = thiss.layerName === 'epr' ? 'EPR_trend' : 'NSM_trend'
                            const propertyValue = feature.get(validation);
                            const fillColor = propertyValue === 'stable' ? 'green'
                                : (propertyValue === 'erosion' ? 'red' : 'blue');
                            const strokeColor = propertyValue === 'stable' ? 'green'
                                : (propertyValue === 'erosion' ? 'red' : 'blue');
                            return new Style({
                                fill: new Fill({
                                    color: fillColor,
                                }),
                                stroke: new Stroke({
                                    color: strokeColor,
                                    width: 1.5,
                                }),
                            });
                        },
                    });
                    thiss.map.addLayer(dataGeojson);

                    thiss.chartOptions.series[0].data = response.data.chartData
                    thiss.chartOptions.subtitle.text = 'Municipalities/Cities'
                    thiss.chartOptions.tooltip.pointFormat = '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
                        'Accreting: <b>{point.x}%</b><br/>' +
                        'Eroded: <b>{point.z}%</b><br/>' +
                        'Stable: <b>{point.t}%</b><br/>'
                    thiss.muniOptions = response.data.Options

                    const extent = Province_Boundary.getSource().getExtent();

                    // Fit the map view to the extent with padding
                    thiss.map.getView().fit(extent, thiss.map.getSize());

                    thiss.provinceNameLoading = false;
                    thiss.resultLoading = false;

                })
                .catch(function (error) {
                    console.error(error);
                });
        },
        async handleMuniNameChange() {
            const thiss = this;
            thiss.muniNameLoading = true;
            thiss.resultLoading = true;
            this.brgyOptions = null;
            thiss.brgyName = null;

            const form = {
                layerName: thiss.layerName,
                provinceName: thiss.provinceName,
                muniName: thiss.muniName
            }

            await axios.post(`/api/getMunicipalitiesData`, form)
                .then(function (response) {

                    thiss.properties = response.data.properties
                    var layers = thiss.map.getLayers();

                    // Remove layers starting from index 1
                    for (var i = layers.getLength() - 1; i > 0; i--) {
                        var layer = layers.item(i);
                        thiss.map.removeLayer(layer);
                    }

                    // Create a new VectorLayer with GeoJSON features and style
                    const MuniCities_Boundary = new VectorLayer({
                        source: new VectorSource({
                            format: new GeoJSON(),
                            features: new GeoJSON().readFeatures(response.data.Region1_MuniCities_GeojsonData, {
                                featureProjection: 'EPSG:3857' // Projection of your map
                            }),
                            crossOrigin: 'anonymous', // Add this line
                        }),
                    });
                    thiss.map.addLayer(MuniCities_Boundary);

                    // Create a new VectorLayer with GeoJSON features and style
                    const Barangays_Boundary = new VectorLayer({
                        source: new VectorSource({
                            format: new GeoJSON(),
                            features: new GeoJSON().readFeatures(response.data.Region1_Barangays_GeojsonData, {
                                featureProjection: 'EPSG:3857' // Projection of your map
                            }),
                            crossOrigin: 'anonymous', // Add this line
                        }),
                    });
                    thiss.map.addLayer(Barangays_Boundary);

                    // Display the Data (EPR/NSM)
                    const dataGeojson = new VectorLayer({
                        source: new VectorSource({
                            format: new GeoJSON(),
                            features: new GeoJSON().readFeatures(response.data.data, {
                                featureProjection: 'EPSG:3857' // Projection of your map
                            }),
                            crossOrigin: 'anonymous', // Add this line
                        }),
                        style: (feature) => {
                            const validation = thiss.layerName === 'epr' ? 'EPR_trend' : 'NSM_trend'
                            const propertyValue = feature.get(validation);
                            const fillColor = propertyValue === 'stable' ? 'green'
                                : (propertyValue === 'erosion' ? 'red' : 'blue');
                            const strokeColor = propertyValue === 'stable' ? 'green'
                                : (propertyValue === 'erosion' ? 'red' : 'blue');
                            return new Style({
                                fill: new Fill({
                                    color: fillColor,
                                }),
                                stroke: new Stroke({
                                    color: strokeColor,
                                    width: 1.5,
                                }),
                            });
                        },
                    });
                    thiss.map.addLayer(dataGeojson);

                    thiss.chartOptions.series[0].data = response.data.chartData
                    thiss.chartOptions.subtitle.text = 'Barangays'
                    thiss.brgyOptions = response.data.Options
                    thiss.chartOptions.tooltip.pointFormat = '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
                        'Accreting: <b>{point.x}%</b><br/>' +
                        'Eroded: <b>{point.z}%</b><br/>' +
                        'Stable: <b>{point.t}%</b><br/>'

                    const extent = MuniCities_Boundary.getSource().getExtent();

                    // Fit the map view to the extent with padding
                    thiss.map.getView().fit(extent, thiss.map.getSize());

                    thiss.muniNameLoading = false;
                    thiss.resultLoading = false;
                })
                .catch(function (error) {
                    console.error(error);
                });
        },
        async handleBrgyNameChange() {
            const thiss = this;
            thiss.brgyNameLoading = true;
            thiss.resultLoading = true;

            const form = {
                layerName: thiss.layerName,
                provinceName: thiss.provinceName,
                muniName: thiss.muniName,
                brgyName: thiss.brgyName,
            }

            await axios.post(`/api/getBarangaysData`, form)
                .then(function (response) {

                    thiss.properties = response.data.properties

                    var layers = thiss.map.getLayers();

                    // Remove layers starting from index 1
                    for (var i = layers.getLength() - 1; i > 0; i--) {
                        var layer = layers.item(i);
                        thiss.map.removeLayer(layer);
                    }

                    // Create a new VectorLayer with GeoJSON features and style
                    const Barangays_Boundary = new VectorLayer({
                        source: new VectorSource({
                            format: new GeoJSON(),
                            features: new GeoJSON().readFeatures(response.data.Region1_Barangays_GeojsonData, {
                                featureProjection: 'EPSG:3857' // Projection of your map
                            }),
                            crossOrigin: 'anonymous', // Add this line
                        }),
                    });
                    thiss.map.addLayer(Barangays_Boundary);

                    // Display the Data (EPR/NSM)
                    const dataGeojson = new VectorLayer({
                        source: new VectorSource({
                            format: new GeoJSON(),
                            features: new GeoJSON().readFeatures(response.data.data, {
                                featureProjection: 'EPSG:3857' // Projection of your map
                            }),
                            crossOrigin: 'anonymous', // Add this line
                        }),
                        style: (feature) => {
                            const validation = thiss.layerName === 'epr' ? 'EPR_trend' : 'NSM_trend'
                            const propertyValue = feature.get(validation);
                            const fillColor = propertyValue === 'stable' ? 'green'
                                : (propertyValue === 'erosion' ? 'red' : 'blue');
                            const strokeColor = propertyValue === 'stable' ? 'green'
                                : (propertyValue === 'erosion' ? 'red' : 'blue');
                            return new Style({
                                fill: new Fill({
                                    color: fillColor,
                                }),
                                stroke: new Stroke({
                                    color: strokeColor,
                                    width: 1.5,
                                }),
                            });
                        },
                    });
                    thiss.map.addLayer(dataGeojson);

                    thiss.chartOptions.series[0].data = response.data.chartData
                    thiss.chartOptions.subtitle.text = ''
                    thiss.chartOptions.tooltip.pointFormat = '<span style="color:{point.color}">\u25CF</span> Accreting: <b>{point.y}%</b><br/><br/>'
                    const extent = Barangays_Boundary.getSource().getExtent();

                    // Fit the map view to the extent with padding
                    thiss.map.getView().fit(extent, thiss.map.getSize());

                    thiss.brgyNameLoading = false;
                    thiss.resultLoading = false;
                })
                .catch(function (error) {
                    console.error(error);
                });
        }
    }
});
</script>

<style>
/* Add any component-specific styles here */
.full-screen-map {
    position: relative;
    width: 100%;
}

.ol-popup {
    position: absolute;
    background-color: white;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
    padding: 15px;
    border-radius: 10px;
    border: 1px solid #cccccc;
    bottom: 12px;
    left: -280px;
    min-width: 580px;

}

.ol-popup:after,
.ol-popup:before {
    top: 100%;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
}

.ol-popup:after {
    border-top-color: white;
    border-width: 10px;
    left: 280px;
    margin-left: -10px;
}

.ol-popup:before {
    border-top-color: #cccccc;
    border-width: 11px;
    left: 280px;
    margin-left: -11px;
}

.ol-popup-closer {
    text-decoration: none;
    position: absolute;
    top: 2px;
    right: 8px;
}

.ol-popup-closer:after {
    content: "✖";
}


.legend-bottom {
    z-index: 10;
    position: absolute;
    bottom: 20px;
    left: 20px;
}

.filter-option {
    z-index: 10;
    position: absolute;
    top: 20px;
    left: 20px;
}

.result {
    z-index: 10;
    position: absolute;
    top: 30px;
    right: 20px;
}
</style>

<style scoped>
.active {
    /* color: rgb(31 41 55); */
    background-color: #cee53a;
    color: white;
}
</style>