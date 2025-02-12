<template>

    <div class="w-full flex">
        <div ref="map" class="full-screen-map w-full">
            <div class="filter-option w-[500px] flex">
                <div v-if="isTabVisible" class="w-full">
                    <div class="text-sm bg-[#201E43] space-y-3 ">
                        <div class="bg-[#134B70] tracking-wide blur-none leading-loose">
                            <p class=" py-1 px-2 text-[#EEEEEE]">
                                Layer Selection
                            </p>
                        </div>
                        <!-- Layer Name -->
                        <div class="h-48 overflow-auto space-y-2 space-y-1">
                            <div class="flex items-center space-x-1 cursor-pointer hover:bg-gray-500 py-1"
                                v-for="option in optionLayers" @click="addToLayer(option)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>

                                <p class="hover:underline w-full text-[#EEEEEE]">
                                    {{ option.title }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-800">
                        <div class="bg-[#134B70] tracking-wide blur-none leading-loose">
                            <p class=" py-1 px-2 text-[#EEEEEE]">
                                Layers
                            </p>
                        </div>
                        <div class="h-72 overflow-auto space-y-1 ">
                            <div class=" py-1 hover:bg-gray-500 " v-for="addedLayer in addedLayers">
                                <div class="px-2 w-full flex items-center justify-between">
                                    <a-checkbox class=" text-[#EEEEEE]"
                                        @change="(value) => onChangeCheckBox(addedLayer.visibility, addedLayer.title)"
                                        v-model:checked="addedLayer.visibility">{{ addedLayer.title }}</a-checkbox>
                                    <div class="w-3/6 flex items-center space-x-4">
                                        <a-slider v-model:value="addedLayer.opacity"
                                            @change="(value) => onChangeOpacity(value, addedLayer.title)" :step="10"
                                            :tip-formatter="formatter" class="w-4/5" />
                                        <span class="text-[#EEEEEE]  cursor-pointer"
                                            @click="showResultChart(addedLayer)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                                            </svg>

                                        </span>
                                        <span class="text-[#EEEEEE] cursor-pointer"
                                            @click="removeLayer(addedLayer.id, addedLayer.title)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
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
                    <div @click="minimize()" class="bg-[#508C9B] py-4 cursor-pointer">
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
            </div>
            <!-- /Filter Option -->
            <!-- Navigation buttons right side -->
            <div class="navButtons space-y-3 text-[#EEEEEE]">
                <div class="bg-[#134B70] p-1 cursor-pointer opacity-85 hover:opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </div>
                <div @click="isbasemapOptionVisible = !isbasemapOptionVisible"
                    class="bg-[#134B70] p-1 cursor-pointer opacity-85 hover:opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 0 1-1.161.886l-.143.048a1.107 1.107 0 0 0-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 0 1-1.652.928l-.679-.906a1.125 1.125 0 0 0-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 0 0-8.862 12.872M12.75 3.031a9 9 0 0 1 6.69 14.036m0 0-.177-.529A2.25 2.25 0 0 0 17.128 15H16.5l-.324-.324a1.453 1.453 0 0 0-2.328.377l-.036.073a1.586 1.586 0 0 1-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643m5.276-3.67a9.012 9.012 0 0 1-5.276 3.67m0 0a9 9 0 0 1-10.275-4.835M15.75 9c0 .896-.393 1.7-1.016 2.25" />
                    </svg>
                </div>
                <div class="bg-[#134B70] p-1 cursor-pointer opacity-85 hover:opacity-50 text-center">
                    <p class="text-bold">XY</p>
                </div>
            </div>

            <!-- Change Base map -->
            <div v-if="isbasemapOptionVisible" class="basemap-option bg-gray-800 w-[200px] py-2 px-3">
                <div class="text-[#EEEEEE] space-y-2">
                    <div>
                        <p>
                            Select Base Map
                        </p>
                    </div>
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
            <!-- Change Base map -->

            <!-- Result -->
            <div v-if="isResultChartVisible" class="result bg-gray-800 w-[300px] "
                style="background: rgba(31, 41, 55, 0.50); backdrop-filter: blur(5px);">
                <div @click="isResultChartVisible = false" class="text-[#EEEEEE] w-full justify-end flex">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5 cursor-pointer">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </div>

                <div class="text-[#EEEEEE] py-2 px-3">
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
            <div class="flex justify-center">
                <Table height="250" :columns="columns" :data="data" class="w-full"></Table>
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
// Components

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
            overlayLayer: null,
            groupLayer: null,
            optionLayers: [],
            addedLayers: [],
            opacityLevel: ref(100),
            isTabVisible: true,
            layerInfo: [],
            // BaseMap Option
            isbasemapOptionVisible: false,
            selectedBaseMap: 'baseMap_OSM',

            isResultChartVisible: false,
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
    async mounted() {
        const thiss = this;

        // Get Request Information to Operate the Map Layers from Geoserver
        fetch('https://coaster.mmsu.edu.ph/geoserver/ne/wms?service=WMS&request=GetCapabilities')
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

            const legendUrl = 'https://coaster.mmsu.edu.ph/geoserver/ne/wms' + '?' +
                'service=WMS&' +
                'version=1.1.0&' +
                'request=GetLegendGraphic&' +
                `layer=ne:${option.title}&` +
                'format=application/json';

            fetch(legendUrl)
                .then(response => response.json())  // Parse as JSON instead of text
                .then(data => {
                    // Extract fill colors with their corresponding EPR trends
                    attributeStyle = data.Legend[0].rules.map(rule => ({
                        name: rule.filter.match(/\'(.*?)\'/)[1],  // Extract value between quotes
                        color: rule.symbolizers[0].Polygon.fill
                    }));

                    console.log('attributeStyle:', attributeStyle);

                    // Match attributeData with attributeStyle and set the color

                })
                .catch(error => {
                    console.error('Error getting style:', error);
                });

            const wfsUrl = 'https://coaster.mmsu.edu.ph/geoserver/ne/wms' + '?' +
                'service=WFS&' +
                'version=1.1.0&' +
                'request=GetFeature&' +
                `typeName=ne:${option.title}&` +
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
                    console.log('attributeData:', attributeData);


                    attributeData.forEach(attrData => {
                        const style = attributeStyle.find(attrStyle => attrStyle.name === attrData.name);
                        if (style) {
                            attrData.color = style.color;
                        }
                    });

                    // Update the chart options with the new data and colors
                    thiss.resultChartOptions.title.text = option.title
                    thiss.resultChartOptions.series[0].data = attributeData;
                    thiss.resultChartOptions.colors = attributeData.map(attr => attr.color);
                    console.log(attributeData);

                    // Time for Result Chart to dissapear
                    thiss.isResultChartVisible = true;
                    
                })
                .catch(error => {
                    console.error('Error fetching layer attributes from MMSU GeoServer:', error);
                    throw error;
                });

        },
        showResultChart(option){
            const thiss = this
            if(thiss.resultChartOptions.title.text != option.title){
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
                        this.map.getView().fit(extent, { duration: 1000 });
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
                                // console.log(response.data.features.length);
                                // for (let i = 0; i < response.data.features.length; i++) {
                                //     console.log(response.data.features[i].properties); // Access the response data
                                // }
                                // console.log(response.data.features.properties); // Access the response data

                                this.data = Object.entries(response.data.features[response.data.features.length - 1].properties)
                                    .filter(([key, value]) => key !== 'Graph')
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
        },
        initializeMap() {
            // https://coaster.mmsu.edu.ph/geoserver/ne/wms?service=WMS&version=1.1.0&request=GetMap&layers=ne%3APadsan%20River%20100%20yrs&bbox=237461.16438149172%2C2011797.174981621%2C245396.3266869379%2C2015079.483242996&width=768&height=330&srs=EPSG%3A32651&styles=&format=application/openlayers
            // https://coaster.mmsu.edu.ph/geoserver/ne/wms?service=WMS&version=1.1.0&request=GetMap&layers=ne%3APadsan%20River%20100%20yrs&bbox=237461.16438149172%2C2011797.174981621%2C245396.3266869379%2C2015079.483242996&width=768&height=330&srs=EPSG%3A32651&styles=&format=application/openlayers
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
                        url: 'https://coaster.mmsu.edu.ph/geoserver/ne/wms',
                        params: {
                            'LAYERS': `ne:${info.name}`,
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
                    center: fromLonLat([121.007046, 17.156009]),
                    zoom: 8,
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
                    this.data = [];
                    this.overlayLayer.setPosition(undefined);
                }
            });

            thiss.map.getView().on('change:resolution', this.onMouseDrag); // Fires during drag
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
    top: 1px;
    left: 0px;
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
    top: 94px;
    right: 60px;
}

.result {
    z-index: 5;
    position: absolute;
    top: 200px;
    bottom: 5px;
    right: 60px;
}

.overlay-container {
    background-color: #555;
    /* width: 500px; */
    color: #fff;
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
