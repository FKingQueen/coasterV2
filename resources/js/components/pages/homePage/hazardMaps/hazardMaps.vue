<template>
    <div class="w-full flex">
        <div ref="map" class="full-screen-map w-full">
            <div class="filter-option w-[320px] flex ">
                <div v-if="isTabVisible" class="w-full" :style="{ minHeight: minHeightStyle + 'px' }">
                    <div class="bg-[#201E43] h-full border-b-4 border-blue-900">
                        <!-- Layer Name -->
                        <div class="border-b h-fit border-blue-900 tracking-wide blur-none leading-loose">
                            <p class=" py-1 px-2 text-[#EEEEEE] text-[13px]">
                                Layer Selection
                            </p>
                        </div>
                        <div :style="{ height: minHeightStyle / 2.3 + 'px' }"
                            class="border-b border-blue-900 overflow-auto  space-y-2 space-y-1">
                            <div class="flex items-center space-x-1 cursor-pointer hover:bg-gray-500 py-1"
                                v-for="option in optionLayers" @click="addToLayer(option)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>

                                <div class="flex items-center">
                                    <p class="hover:underline w-full text-[#EEEEEE] text-[12px]">
                                        {{ option.title }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="border-b border-blue-900 tracking-wide blur-none leading-loose">
                            <p class=" py-1 px-2 text-[#EEEEEE] text-[13px] ">
                                Layers
                            </p>
                        </div>
                        <div :style="{ height: minHeightStyle / 2.3 + 'px' }"
                            class=" h-3/6 overflow-auto space-y-2 space-y-1">

                            <div class="w-full py-1 hover:bg-gray-500 " v-for="addedLayer in addedLayers">
                                <div class="w-full flex items-center justify-evenly">
                                    <div class="w-3/6">
                                        <a-checkbox class="text-[#EEEEEE] text-[12px] "
                                            @change="(value) => onChangeCheckBox(addedLayer.visibility, addedLayer.title)"
                                            v-model:checked="addedLayer.visibility">{{ addedLayer.title }}</a-checkbox>

                                    </div>
                                    <div class="w-2/6">
                                        <a-slider v-model:value="addedLayer.opacity"
                                            @change="(value) => onChangeOpacity(value, addedLayer.title)" :step="10"
                                            :tip-formatter="formatter" class="w-5/6" />
                                    </div>

                                    <div class="flex items-center w-1/6 justify-evenly">
                                        <span class="text-[#EEEEEE] cursor-pointer"
                                            @click="showResultChart(addedLayer)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                                            </svg>

                                        </span>
                                        <span class="text-[#EEEEEE] cursor-pointer"
                                            @click="removeLayer(addedLayer.id, addedLayer.title)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div @click="isTabVisible = !this.isTabVisible"
                        class="bg-[#EEEEEE] rounded-r-lg py-4 cursor-pointer text-blue-900">
                        <svg v-if="isTabVisible" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                        </svg>
                        <svg v-if="!isTabVisible" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                        </svg>
                    </div>
                </div>
                <div class="pt-32 space-y-0.5 text-blue-900 ">
                    <a-tooltip placement="right" :mouseEnterDelay=".8">
                        <template #title>
                            <span>Zoom In</span>
                        </template>
                        <div
                            class="rounded-t-lg bg-[#EEEEEE] p-1 cursor-pointer opacity-85 hover:opacity-50 text-center">
                            <svg @click="zoomLevel(1)" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6" />
                            </svg>
                        </div>
                    </a-tooltip>
                    <a-tooltip placement="right" :mouseEnterDelay=".8">
                        <template #title>
                            <span>Full Extent</span>
                        </template>
                        <div class="bg-[#EEEEEE] p-1 cursor-pointer opacity-85 hover:opacity-50 text-center">
                            <svg @click="zoomLevel(2)" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                            </svg>

                        </div>
                    </a-tooltip>
                    <a-tooltip placement="right" :mouseEnterDelay=".8">
                        <template #title>
                            <span>Zoom Out</span>
                        </template>
                        <div
                            class="rounded-b-lg bg-[#EEEEEE] p-1 cursor-pointer opacity-85 hover:opacity-50 text-center">
                            <svg @click="zoomLevel(3)" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM13.5 10.5h-6" />
                            </svg>
                        </div>
                    </a-tooltip>

                </div>
            </div>
            <!-- /Filter Option -->

            <!-- Navigation buttons right side -->
            <div class="navButtons space-y-1 text-blue-900">
                <a-tooltip placement="left" :mouseEnterDelay=".8">
                    <template #title>
                        <span>Reset</span>
                    </template>
                    <div @click="resetAll()" class="bg-[#EEEEEE] p-1 cursor-pointer opacity-85 hover:opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </div>
                </a-tooltip>
                <a-tooltip placement="left" :mouseEnterDelay=".8">
                    <template #title>
                        <span>Basemap</span>
                    </template>
                    <div @click="isbasemapOptionVisible = !isbasemapOptionVisible, isGotoLocationVisible = false"
                        class="bg-[#EEEEEE] p-1 cursor-pointer opacity-85 hover:opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 0 1-1.161.886l-.143.048a1.107 1.107 0 0 0-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 0 1-1.652.928l-.679-.906a1.125 1.125 0 0 0-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 0 0-8.862 12.872M12.75 3.031a9 9 0 0 1 6.69 14.036m0 0-.177-.529A2.25 2.25 0 0 0 17.128 15H16.5l-.324-.324a1.453 1.453 0 0 0-2.328.377l-.036.073a1.586 1.586 0 0 1-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643m5.276-3.67a9.012 9.012 0 0 1-5.276 3.67m0 0a9 9 0 0 1-10.275-4.835M15.75 9c0 .896-.393 1.7-1.016 2.25" />
                        </svg>
                    </div>
                </a-tooltip>
                <a-tooltip placement="left" :mouseEnterDelay=".8">
                    <template #title>
                        <span>XY Location</span>
                    </template>
                    <div @click="isGotoLocationVisible = !isGotoLocationVisible, isbasemapOptionVisible = false"
                        class="bg-[#EEEEEE] p-1 cursor-pointer opacity-85 hover:opacity-50 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </div>
                </a-tooltip>
            </div>

            <!-- Change Base map -->
            <div v-if="isbasemapOptionVisible" class="basemap-option bg-gray-800 w-[200px]">
                <div class="text-[#EEEEEE]/70 text-[13px] space-y-2">
                    <div class="text-[#EEEEEE]/50 text-[13px] w-full justify-between flex px-1">
                        <div class="pt-1 pl-2">
                            <p>
                                Select Base Map
                            </p>
                        </div>
                        <svg @click="isbasemapOptionVisible = false" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="px-3 pb-2">
                        <a-select ref="select" v-model:value="selectedBaseMap" style="width: 100%"
                            @change="onSelectBaseMap">
                            <a-select-option value="baseMap_OSM">Open Street Map (OSM)</a-select-option>
                            <a-select-option value="baseMap_Basic">Basic</a-select-option>
                        </a-select>
                        <div class="text-justify">
                            <p>
                                <span class="font-bold">Note: </span>
                                Please be advised that there may be discrepancies in the basemaps provided. Users are
                                encouraged to exercise caution when using them, especially for applications requiring
                                precise spatial accuracy.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Change Base map -->

            <!-- Goto Location -->
            <div v-if="isGotoLocationVisible" class="goto-location bg-gray-800 w-[200px] ">
                <div class="text-[#EEEEEE]/70 text-[13px] space-y-2">
                    <div class="text-[#EEEEEE]/50 text-[13px] w-full justify-between flex">
                        <div class="pt-1 pl-2">
                            <p>
                                Go to Location
                            </p>
                        </div>
                        <svg @click="isGotoLocationVisible = false" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="px-3 pb-2">
                        <div class="text-justify space-y-3">
                            <p>
                                <span class="font-bold">Enter Coordinates:</span>
                            </p>
                            <Space direction="vertical" size="small">
                                <Space>
                                    <p style="width: 60px">
                                        Latitude：
                                    </p>

                                    <Input v-model="goLocationLat" size="small" placeholder="Latitude" />
                                </Space>
                                <Space>
                                    <p style="width: 60px">
                                        Longitude：
                                    </p>

                                    <Input v-model="goLocationLon" size="small" placeholder="Longitude" />
                                </Space>
                            </Space>
                            <div class="w-full flex justify-center">
                                <div @click="goToLocation()"
                                    class="w-2/4 bg-[#EEEEEE] text-blue-900 text-center cursor-pointer hover:bg-gray-500">
                                    Enter
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Goto Location -->

            <!-- Details and Instructions -->
            <div v-if="isDetailsInstructions"
                class="details-instruction text-blue-900 text-[13px] w-[400px] bg-[#EEEEEE]/40 rounded-sm">
                <div class="p-5 space-y-3">
                    <p class="text-justify">
                        <span class=" text-blue-900 text-[13px] tracking-wide">Details:</span> The data presented
                        here is
                        based on
                        research and analysis conducted by the CoastEr Program.
                        It may not conform to the standards or quality control procedures associated with official
                        government or industry data sources.
                    </p>
                    <p class="text-justify">
                        <span class=" text-blue-900 text-[13px] tracking-wide">Instruction:</span> You can select
                        different
                        layers
                        to display them on the map. Clicking on a layer will
                        allow you to visualize its raw data. Once a layer is added, you can navigate by adjusting
                        its
                        opacity, displaying its graph, and exploring other visualization options. Additionally, you
                        can
                        change the basemap using the Basemap icon and navigate to specific coordinates using the XY
                        icon. <span @click="isDetailsInstructions = false"
                            class="text-blue-900 text-[13px] tracking-wide underline cursor-pointer">
                            Close
                        </span>
                    </p>
                </div>
            </div>
            <!-- Details and Instructions -->

            <!-- Result -->
            <div v-if="isResultChartVisible" class="result bg-gray-800 w-[300px]"
                style="background: rgba(31, 41, 55, 0.50); backdrop-filter: blur(5px);">
                <div @click="isResultChartVisible = false" class="text-[#EEEEEE] w-full justify-end flex">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5 cursor-pointer">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </div>

                <div class="text-[#EEEEEE] px-3">
                    <highcharts :options="resultChartOptions"></highcharts>
                </div>

            </div>
            <!-- Result -->
        </div>
        <div class="overlay-container p-1" id="popup">
            <span id="feature-additional-info"></span>
            <div class="flex justify-between w-full items-center">
                <p class="capitalize" id="layerTitle"></p>
                <button @click="closePopup()" class="capitalize"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg></button>
            </div>
            <div class="w-full">
                <!-- <Table height="250" :columns="columns" :data="tableData" class="w-full"></Table>
                <img class="object-cover w-full" :src="`${this.data.file_path}.png`"> -->
                <!-- <img class="object-cover w-full" :src="`/inventory_images/${this.data.Coastal_ID}.png`"> -->
                <div style="max-height: 250px; overflow-y: auto; width: 392px;">
                    <table class="w-full border-collapse border border-gray-400">
                        <thead>
                            <tr>
                                <th class="border border-gray-300">Attribute</th>
                                <th class="border border-gray-300">Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in tableData">
                                <td class="border border-gray-300">{{ row.attribute }}</td>
                                <td class="border border-gray-300">{{ row.value }}</td>
                            </tr>
                            <tr v-if="this.data.file_path">
                                <td class="border border-gray-300">Image</td>
                                <td class="border border-gray-300">
                                    <a-image style="height: 100px" :src="`/inventory_images/${this.data.Barangay}.png`" :preview="{
                                        src: `/inventory_images/${this.data.Barangay}.png`,
                                    }" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

// Vue Libraries
import { defineComponent, ref, nextTick, h } from "vue";

// OpenLayers Libraries

import "ol/ol.css";
import Map from "ol/Map";
import View from "ol/View";
import TileLayer from "ol/layer/Tile";
import FullScreen from "ol/control/FullScreen";
import { fromLonLat } from "ol/proj";
import XYZ from "ol/source/XYZ";

// Datatables
import { DataTable } from "datatables.net-vue3";

// Overview Component
import Overlay from "ol/Overlay";
import GeoJSON from "ol/format/GeoJSON";
import LayerGroup from "ol/layer/Group";
import TileWMS from "ol/source/TileWMS";
import { transformExtent } from 'ol/proj';

export default defineComponent({
    components: {
        DataTable,
    },
    data() {
        return {
            screenHeight: window.innerHeight - 100,
            columns: [
                {
                    title: "Attribute",
                    key: "attribute",
                },
                {
                    title: "Value",
                    key: "value",
                },
            ],
            data: [],
            tableData: [],
            overlayLayer: null,
            groupLayer: null,
            optionLayers: [],
            addedLayers: [],
            opacityLevel: ref(100),
            isTabVisible: true,
            layerInfo: [],
            // BaseMap Option
            isbasemapOptionVisible: false,
            isGotoLocationVisible: false,
            selectedBaseMap: 'baseMap_OSM',

            isDetailsInstructions: true,
            isResultChartVisible: false,

            goLocationLat: null,
            goLocationLon: null,

            resultChartOptions: {
                chart: {
                    backgroundColor: 'transparent', // Can be a color name, hex code, or rgba value
                    style: {
                        color: '#EEEEEE'
                    },
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                credits: {
                    text: '',
                },
                title: {
                    text: '',
                    style: {
                        color: '#EEEEEE'
                    },
                },
                subtitle: {
                    text: 'Sample',
                    style: {
                        color: '#EEEEEE'
                    },
                },
                plotOptions: {

                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    },
                    series: {
                        animation: true
                    }
                },
                legend: {
                    itemStyle: {
                        color: '#EEEEEE'
                    }
                },
                colors: [],
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                series: [
                    {
                        name: 'Percentage',
                        colorByPoint: true,
                        data: []
                    }
                ]
            },
        };
    },
    computed: {
        minHeightStyle() {
            return this.screenHeight + 11;
        },
    },
    async mounted() {
        const thiss = this;

        // Get Request Information to Operate the Map Layers from Geoserver
        fetch('http://localhost:3655/geoserver/coaster/wms?service=WMS&request=GetCapabilities')
            .then(response => response.text())
            .then(text => {
                const parser = new DOMParser();
                const xmlDoc = parser.parseFromString(text, 'application/xml');
                const layers = xmlDoc.getElementsByTagName('Layer');

                // Collect layer information into an array
                for (let i = 1; i < layers.length; i++) { // Skip the first layer, which is a container
                    const layer = layers[i];
                    const name = layer.getElementsByTagName('Name')[0]?.textContent;

                    // Get bounding box information
                    const bbox = layer.getElementsByTagName('BoundingBox')[0];
                    const extent = bbox ?
                        [bbox.getAttribute('minx'), bbox.getAttribute('miny'), bbox.getAttribute('maxx'), bbox.getAttribute('maxy')]
                        : null;

                    // If there's no BoundingBox, try to get Geographic Bounding Box
                    if (!extent) {
                        const geoBbox = layer.getElementsByTagName('EX_GeographicBoundingBox')[0];
                        if (geoBbox) {
                            extent = [geoBbox.getElementsByTagName('westBoundLongitude')[0]?.textContent,
                            geoBbox.getElementsByTagName('southBoundLatitude')[0]?.textContent,
                            geoBbox.getElementsByTagName('eastBoundLongitude')[0]?.textContent,
                            geoBbox.getElementsByTagName('northBoundLatitude')[0]?.textContent]
                        }
                    }

                    if (name) {
                        thiss.layerInfo.push({
                            name: name,
                            extent: extent
                        });
                    }
                }

                // Sort layer information alphabetically by name
                thiss.layerInfo.sort((a, b) => a.name.localeCompare(b.name));

                // Initializa the Map
                thiss.initializeMap();
            });
    },
    methods: {
        onSelectBaseMap() {
            const thiss = this
            const basemapList = [
                'baseMap_OSM',
                'baseMap_Basic',
            ];
            const layers = this.map.getLayers().getArray();
            layers.forEach(layer => {
                if (basemapList.includes(layer.get('title'))) {
                    layer.setVisible(layer.get('title') === thiss.selectedBaseMap);
                }
            });
        },
        minimize() {
            this.isTabVisible = !this.isTabVisible;
        },
        removeLayer(id, layerTitle) {
            this.addedLayers = this.addedLayers.filter(item => item.id !== id);

            const layers = this.map.getLayers().getArray();
            const layer = layers.find((layer) => layer.get('title') === layerTitle);
            if (layer) {
                layer.setVisible(false);
            }
        },
        onChangeCheckBox(value, layerTitle) {

            // Find the layer by title and set its opacity
            const layers = this.map.getLayers().getArray();
            const layer = layers.find((layer) => layer.get('title') === layerTitle);
            if (layer) {
                layer.setVisible(value);
            }
        },
        onChangeOpacity(value, layerTitle) {

            // Find the layer by title and set its opacity
            const layers = this.map.getLayers().getArray();
            const layer = layers.find((layer) => layer.get('title') === layerTitle);

            if (layer) {
                const opacity = value / 100; // Convert slider value to a range of 0 to 1
                layer.setOpacity(opacity);
            }
        },
        formatter(value) {
            return `${value}%`; // Format the tooltip display
        },
        resultChart(option) {
            // Result Chart
            const thiss = this
            let attributeData = []
            let attributeStyle = []

            const legendUrl = 'http://localhost:3655/geoserver/coaster/wms' + '?' +
                'service=WMS&' +
                'version=1.1.0&' +
                'request=GetLegendGraphic&' +
                `layer=coaster:${option.title}&` +
                'format=application/json';

            fetch(legendUrl)
                .then(response => response.json())  // Parse as JSON instead of text
                .then(data => {
                    console.log('style: ', data);
                    // Extract fill colors with their corresponding EPR trends
                    attributeStyle = data.Legend[0].rules.map(rule => {
                        let color;
                        if (rule.symbolizers[0].Polygon) {
                            color = rule.symbolizers[0].Polygon.fill;
                        } else if (rule.symbolizers[0].Point) {
                            color = rule.symbolizers[0].Point.graphics[0].fill;
                        } else if (rule.symbolizers[0].Line) {
                            color = rule.symbolizers[0].Line.stroke;
                        }
                        return {
                            name: rule.filter.match(/\'(.*?)\'/)[1],  // Extract value between quotes
                            color: color
                        };
                    });

                    // Match attributeData with attributeStyle and set the color

                })
                .catch(error => {
                    console.error('Error getting style:', error);
                });

            const wfsUrl = 'http://localhost:3655/geoserver/coaster/wms' + '?' +
                'service=WFS&' +
                'version=1.1.0&' +
                'request=GetFeature&' +
                `typeName=coaster:${option.title}&` +
                'outputFormat=application/json';
            fetch(wfsUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.features) {
                        throw new Error('No features found in the response');
                    }

                    const geoJsonFormat = new GeoJSON();
                    const features = geoJsonFormat.readFeatures(data);

                    // Extract attributes from features
                    const attributes = features.map(feature => {
                        const props = feature.getProperties();
                        return {
                            Graph: props.Graph,
                            color: props.color,
                            stroke: props.stroke,
                            // any other properties you need
                        };
                    });

                    // Step 1: Count occurrences
                    const counts = attributes.reduce((acc, obj) => {
                        const key = obj.Graph;
                        acc[key] = (acc[key] || 0) + 1;
                        return acc;
                    }, {});

                    // Step 2: Calculate percentages
                    const total = attributes.length;
                    attributeData = Object.entries(counts).map(([key, count]) => ({
                        name: key,
                        y: parseFloat(((count / total) * 100).toFixed(2)),
                    }));


                    attributeData.forEach(attrData => {
                        const style = attributeStyle.find(attrStyle => attrStyle.name === attrData.name);
                        if (style) {
                            attrData.color = style.color;
                        }
                    });

                    const feature = features[0];
                    const attributesForSubTitle = feature.getProperties();

                    // Get the Graph value
                    const graphValue = attributesForSubTitle.Graph;

                    let subTitle = null;

                    // Check which attribute matches Graph
                    for (const key in attributesForSubTitle) {
                        if (attributesForSubTitle[key] === graphValue && key !== 'Graph') {
                            subTitle = key.replace(/_/g, " ");
                            break;  // Stop at the first match
                        }
                    }

                    // Update the chart options with the new data and colors
                    thiss.resultChartOptions.title.text = option.title
                    thiss.resultChartOptions.subtitle.text = subTitle
                    thiss.resultChartOptions.series[0].data = attributeData;
                    thiss.resultChartOptions.colors = attributeData.map(attr => attr.color);
                    // Time for Result Chart to dissapear
                    thiss.isResultChartVisible = true;

                })
                .catch(error => {
                    console.error('Error fetching layer attributes from MMSU GeoServer:', error);
                    throw error;
                });

        },
        showResultChart(option) {
            const thiss = this
            if (thiss.resultChartOptions.title.text != option.title) {
                thiss.resultChart(option)
            } else if (thiss.isResultChartVisible == false) {
                thiss.resultChart(option)
            }
        },
        addToLayer(option) {
            console.log();
            const thiss = this
            this.overlayLayer.setPosition(undefined);
            const exists = this.addedLayers.find(layer => layer.id === option.id || layer.title === option.title);
            if (!exists) {
                this.addedLayers.push(option);

                const layers = this.map.getLayers().getArray();
                const layer = layers.find(l => l.get('title') === option.title);
                if (layer) {
                    layer.setVisible(true);

                    const extent = layer.getExtent ? layer.getExtent() : null;

                    if (extent) {
                        this.map.getView().fit(extent, { duration: 1000, padding: [50, 50, 50, 50] });
                    }

                    thiss.resultChart(option)
                }
            }
        },
        handleClickFeature(coordinate, viewResolution) {

            const visibleWmsLayers = this.groupLayer.getLayers().getArray()
                .filter(layer =>
                    layer.getVisible() &&
                    layer.getSource() instanceof TileWMS
                )

            const overlayTitle = document.getElementById("layerTitle");

            for (let layer of visibleWmsLayers) {
                try {
                    const url = layer.getSource().getFeatureInfoUrl(
                        coordinate,
                        viewResolution,
                        this.map.getView().getProjection(),
                        {
                            'INFO_FORMAT': 'application/json',
                            'FEATURE_COUNT': 10
                        }
                    )

                    if (url) {

                        axios.get(url)
                            .then(response => {
                                this.data = response.data.features[response.data.features.length - 1].properties;
                                console.log(this.data);
                                this.tableData = Object.entries(response.data.features[response.data.features.length - 1].properties)
                                    .filter(([key, value]) => key !== 'Graph' && key !== 'file_path')
                                    .map(([key, value]) => ({
                                        attribute: key,
                                        value: value,
                                    }));
                        
                                const title = response.data.features[response.data.features.length - 1].id;
                                overlayTitle.innerHTML = `Layer Name: ` + title.replace(/\.[^.\s]+/, "");

                                this.overlayLayer.setPosition(coordinate);

                                this.map.getView().animate({
                                    center: coordinate,
                                    duration: 500, // Optional: smooth animation duration
                                });
                            })
                            .catch(error => {
                                console.error('Error fetching data:', error);
                            });

                    }
                } catch (error) {
                }
            }
        },
        onMouseDrag() {
            this.overlayLayer.setPosition(undefined);
            this.isbasemapOptionVisible = false;
            this.isDetailsInstructions = false;
            this.isGotoLocationVisible = false;
            // this.isResultChartVisible = false;
        },
        onDrag() {
            this.isDetailsInstructions = false;
            this.isResultChartVisible = false;
        },
        goToLocation() {
            const thiss = this
            const lat = parseFloat(thiss.goLocationLat);
            const lon = parseFloat(thiss.goLocationLon);

            if (lat && lon) {
                thiss.map.getView().setCenter(fromLonLat([lon, lat]));
                thiss.map.getView().setZoom(10);
                thiss.isGotoLocationVisible = false;
            }
        },
        zoomLevel(level) {
            const thiss = this

            const view = thiss.map.getView();
            const zoom = view.getZoom();

            if (level == 1) {
                view.setZoom(zoom + 0.5); // Increase zoom level
            }
            if (level == 2) {
                view.setCenter(fromLonLat([120.14482, 12.37834])); // Reset center
                view.setZoom(5.7); // Reset zoom level
                thiss.onMouseDrag();
                thiss.onDrag();
            }
            if (level == 3) {
                view.setZoom(zoom - 0.5); // Increase zoom level
            }
        },
        resetAll() {
            const thiss = this

            // Map
            const view = thiss.map.getView();
            view.setCenter(fromLonLat([125.74482, 12.37834])); // Reset center
            view.setZoom(5.7); // Reset zoom level

            thiss.isDetailsInstructions = true;
            thiss.isResultChartVisible = false;
            thiss.isbasemapOptionVisible = false;
            thiss.overlayLayer.setPosition(undefined);

            thiss.addedLayers = [];
        },
        initializeMap() {
            // http://localhost:3655/geoserver/coaster/wms?service=WMS&version=1.1.0&request=GetMap&layers=ne%3APadsan%20River%20100%20yrs&bbox=237461.16438149172%2C2011797.174981621%2C245396.3266869379%2C2015079.483242996&width=768&height=330&srs=EPSG%3A32651&styles=&format=application/openlayers
            // http://localhost:3655/geoserver/coaster/wms?service=WMS&version=1.1.0&request=GetMap&layers=ne%3APadsan%20River%20100%20yrs&bbox=237461.16438149172%2C2011797.174981621%2C245396.3266869379%2C2015079.483242996&width=768&height=330&srs=EPSG%3A32651&styles=&format=application/openlayers
            const thiss = this;

            this.groupLayer = new LayerGroup({
                layers: [],
            });

            const baseMap_Basic = new TileLayer({
                source: new XYZ({
                    url: "https://api.mapbox.com/styles/v1/pcborja/cm4gd7ukq002c01rf9l0z2qb6/tiles/256/{z}/{x}/{y}@2x?access_token=pk.eyJ1IjoicGNib3JqYSIsImEiOiJjbG5sZm9weGIxYzg4MmxtbmpqYjd2YXIxIn0.LmH0x1Rn3NDzJdzq3J6Ayg",
                }),
                visible: false,
                title: "baseMap_Basic",
            });


            const baseMap_OSM = new TileLayer({
                source: new XYZ({
                    url: 'https://{a-c}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                    attributions: '© OpenStreetMap contributors'
                }),
                visible: true,
                title: "baseMap_OSM",
            })

            thiss.groupLayer.getLayers().push(baseMap_Basic);
            thiss.groupLayer.getLayers().push(baseMap_OSM);

            thiss.layerInfo.forEach((info, index) => {
                // Create the new layer
                const newLayer = new TileLayer({
                    source: new TileWMS({
                        url: 'http://localhost:3655/geoserver/coaster/wms',
                        params: {
                            'LAYERS': `coaster:${info.name}`,
                            'TILED': true,
                            'FORMAT': 'image/png',
                            'SRS': 'EPSG:32651'
                        },
                        serverType: 'geoserver'
                    }),
                    visible: false,
                    title: info.name,
                    extent: transformExtent(info.extent, 'EPSG:4326', 'EPSG:3857')
                });

                // Add the layer to the group
                thiss.groupLayer.getLayers().push(newLayer);

                // Add the layer to the optionLayers array
                thiss.optionLayers.push({
                    id: index,
                    title: newLayer.get('title'),
                    opacity: thiss.opacityLevel,
                    visibility: true,
                });
            });


            // Initialize the map
            this.map = new Map({
                target: this.$refs.map,
                layers: this.groupLayer,
                view: new View({
                    center: fromLonLat([125.74482, 12.37834]),
                    zoom: 5.7,
                }),
                controls: [new FullScreen()],
            });
            const overlayContainerElement = document.getElementById("popup");

            // Create a popup overlay
            this.overlayLayer = new Overlay({
                element: overlayContainerElement,
                positioning: "center-center",
                // stopEvent: false,
            });

            this.map.addOverlay(this.overlayLayer);

            // Add a click event to show the popup
            this.map.on("click", (event) => {
                let featureFound = false;

                // Coordinate where the user clicked
                const coordinate = event.coordinate;

                // Construct GetFeatureInfo request
                const viewResolution = this.map.getView().getResolution();

                this.handleClickFeature(coordinate, viewResolution)

                // Hide the popup if no feature was found
                if (!featureFound) {
                    this.tableData = [];
                    this.overlayLayer.setPosition(undefined);
                }
            });

            thiss.map.getView().on('change:resolution', this.onMouseDrag); // Fires during drag
            thiss.map.on('pointerdrag', this.onDrag);
        },
        closePopup() {
            this.overlayLayer.setPosition(undefined);
        },
    },
});
</script>

<style scoped>
/* Add any component-specific styles here */
.full-screen-map {
    position: relative;
    width: 100%;
}

.filter-option {
    z-index: 10;
    position: absolute;
    top: 0px;
    left: 0px;
}

.zoomLevel {
    z-index: 10;
    position: absolute;
    top: 1px;
}

.navButtons {
    z-index: 10;
    position: absolute;
    top: 50px;
    right: 20px;
}

.basemap-option {
    z-index: 10;
    position: absolute;
    top: 86px;
    right: 55px;
}

.goto-location {
    z-index: 10;
    position: absolute;
    top: 122px;
    right: 55px;
}

.details-instruction {
    z-index: 9;
    position: absolute;
    top: 170px;
    right: 230px;
}

.result {
    z-index: 5;
    position: absolute;
    top: 138px;
    right: 60px;
}

.overlay-container {
    background-color: #ffffff;
    /* width: 500px; */
    color: #000000;
    text-align: center;
    width: 400px;
    border-radius: 1px;
    position: absolute;
    z-index: 1;
    bottom: 100%;
    left: 50%;
    margin-bottom: 10px;
    margin-left: -199px;
}

.overlay-container #feature-additional-info::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -10px;
    border-width: 10px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
}

.vertical-checkbox-group {
    display: flex;
    flex-direction: column;
}
</style>
