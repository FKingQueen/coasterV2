<template>

    <div class="w-full flex">
        <div ref="map" class="full-screen-map w-full">
            <div class="filter-option w-[400px] flex">
                <div v-if="isTabVisible" class="w-full">
                    <div class="text-sm bg-white space-y-3 ">
                        <div class="bg-[#ffb703] tracking-wide blur-none leading-loose">
                            <p class=" py-1 px-2">
                                Layer Selection
                            </p>
                        </div>
                        <!-- Layer Name -->
                        <div class="h-48 overflow-auto space-y-2 px-2 space-y-1">
                            <div class="flex items-center space-x-1 cursor-pointer hover:bg-slate-50 py-1"
                                v-for="option in Options.slice(1)" @click="addToLayer(option)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>

                                <p class="hover:underline w-full">
                                    {{ option.title }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white py-2">
                        <div class="bg-[#ffb703] tracking-wide blur-none leading-loose">
                            <p class=" py-1 px-2">
                                Layers
                            </p>
                        </div>
                        <div class="h-72 overflow-auto space-y-1  px-2">
                            <div class="w-full flex items-center justify-between py-1 hover:bg-slate-50"
                                v-for="addedLayer in addedLayers">
                                <a-checkbox
                                    @change="(value) => onChangeCheckBox(addedLayer.visibility, addedLayer.title)"
                                    v-model:checked="addedLayer.visibility">{{ addedLayer.title }}</a-checkbox>

                                <div class="w-2/6 flex items-center space-x-2">
                                    <a-slider v-model:value="addedLayer.opacity"
                                        @change="(value) => onChangeOpacity(value, addedLayer.title)" :step="10"
                                        :tip-formatter="formatter" class="w-4/5" />
                                    <span class="border cursor-pointer"
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
                <div>
                    <div @click="minimize()" class="bg-white border-y border-r py-4 cursor-pointer hover:bg-slate-50">
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
            <div class="navButtons space-y-3">
                <div class="bg-[#ffb703] p-1 cursor-pointer opacity-85 hover:opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </div>
                <div class="bg-[#ffb703] p-1 cursor-pointer opacity-85 hover:opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 0 1-1.161.886l-.143.048a1.107 1.107 0 0 0-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 0 1-1.652.928l-.679-.906a1.125 1.125 0 0 0-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 0 0-8.862 12.872M12.75 3.031a9 9 0 0 1 6.69 14.036m0 0-.177-.529A2.25 2.25 0 0 0 17.128 15H16.5l-.324-.324a1.453 1.453 0 0 0-2.328.377l-.036.073a1.586 1.586 0 0 1-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643m5.276-3.67a9.012 9.012 0 0 1-5.276 3.67m0 0a9 9 0 0 1-10.275-4.835M15.75 9c0 .896-.393 1.7-1.016 2.25" />
                    </svg>
                </div>
                <div class="bg-[#ffb703] p-1 cursor-pointer opacity-85 hover:opacity-50 text-center">
                    <p class="text-bold">XY</p>
                </div>
            </div>
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
import { Fill, Style, Stroke } from "ol/style";
// import VectorLayer from "ol/layer/Vector"; // Correct import statement
// import VectorSource from "ol/source/Vector"; // Add VectorSource import
import XYZ from "ol/source/XYZ";
// import GeoJSON from 'ol/format/GeoJSON';

// Datatables
import { DataTable } from "datatables.net-vue3";
import Select from "datatables.net-select";
// Components

// Overview Component
import Overlay from "ol/Overlay";
import VectorLayer from "ol/layer/Vector";
import VectorSource from "ol/source/Vector";
import GeoJSON from "ol/format/GeoJSON";
import LayerGroup from "ol/layer/Group";

import VectorTileLayer from "ol/layer/VectorTile";
import VectorTileSource from "ol/source/VectorTile";
import MVT from "ol/format/MVT";
import TileWMS from "ol/source/TileWMS";
import { transformExtent } from 'ol/proj';
import { get as getProjection } from 'ol/proj'

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
            nsmLayer: null,
            eprLayer: null,
            groupLayer: null,
            Options: [],
            addedLayers: [],
            opacityLevel: ref(100),
            isTabVisible: true,
        };
    },
    async mounted() {
        this.initializeMap();
    },
    methods: {
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
        addToLayer(option) {
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
            const basemap1 = new TileLayer({
                source: new XYZ({
                    url: "https://api.mapbox.com/styles/v1/pcborja/cm4gd7ukq002c01rf9l0z2qb6/tiles/256/{z}/{x}/{y}@2x?access_token=pk.eyJ1IjoicGNib3JqYSIsImEiOiJjbG5sZm9weGIxYzg4MmxtbmpqYjd2YXIxIn0.LmH0x1Rn3NDzJdzq3J6Ayg",
                }),
                visible: true,
                title: "basemap1",
            });

            // http://10.10.56.5:3655/geoserver/ne/wms?service=WMS&version=1.1.0&request=GetMap&layers=ne%3APadsan%20River%20100%20yrs&bbox=237461.16438149172%2C2011797.174981621%2C245396.3266869379%2C2015079.483242996&width=768&height=330&srs=EPSG%3A32651&styles=&format=application/openlayers
            // http://10.10.56.5:3655/geoserver/ne/wms?service=WMS&version=1.1.0&request=GetMap&layers=ne%3APadsan%20River%20100%20yrs&bbox=237461.16438149172%2C2011797.174981621%2C245396.3266869379%2C2015079.483242996&width=768&height=330&srs=EPSG%3A32651&styles=&format=application/openlayers
            const padsanRiver100Yrs = new TileLayer({
                source: new TileWMS({
                    url: 'http://10.10.56.5:3655/geoserver/ne/wms',
                    params: {
                        'LAYERS': 'ne:Padsan River 100 yrs',
                        'TILED': true,
                        'FORMAT': 'image/png',
                        'SRS': 'EPSG:32651'
                    },
                    serverType: 'geoserver'
                }),
                visible: false,
                title: 'Padsan River 100yrs',
                extent: transformExtent([120.51769320066239, 18.179295968103457, 120.59307783662878, 18.20989103880793], 'EPSG:4326', 'EPSG:3857')
            })


            const ilocos_Norte_EPR_1977_2022 = new TileLayer({
                source: new TileWMS({
                    url: 'http://10.10.56.5:3655/geoserver/ne/wms',
                    params: {
                        'LAYERS': 'ne:Ilocos_Norte_EPR_1977_2022',
                        'TILED': true,
                        'FORMAT': 'image/png',
                        'SRS': 'EPSG:32651'
                    },
                    serverType: 'geoserver'
                }),
                visible: false,
                title: 'Ilocos Norte EPR 1977-2022',
                extent: transformExtent([120.41818359729491, 17.90143379782558, 120.9716765175055, 18.652416013413312], 'EPSG:4326', 'EPSG:3857')
            })

            const ilocos_Norte_NSM_1977_2022 = new TileLayer({
                source: new TileWMS({
                    url: 'http://10.10.56.5:3655/geoserver/ne/wms',
                    params: {
                        'LAYERS': 'ne:Ilocos_Norte_NSM_1977_2022',
                        'TILED': true,
                        'FORMAT': 'image/png',
                        'SRS': 'EPSG:32651'
                    },
                    serverType: 'geoserver'
                }),
                visible: false,
                title: 'Ilocos Norte NSM 1977-2022',
                extent: transformExtent([120.41818359729491, 17.90143379782558, 120.9716765175055, 18.652416013413312], 'EPSG:4326', 'EPSG:3857')
            })

            const ilocos_Sur_EPR_1977_2022 = new TileLayer({
                source: new TileWMS({
                    url: 'http://10.10.56.5:3655/geoserver/ne/wms',
                    params: {
                        'LAYERS': 'ne:Ilocos_Sur_EPR_1977_2022',
                        'TILED': true,
                        'FORMAT': 'image/png',
                        'SRS': 'EPSG:32651'
                    },
                    serverType: 'geoserver'
                }),
                visible: false,
                title: 'Ilocos Sur EPR 1977-2022',
                extent: transformExtent([120.33311300640369, 16.92223405502681, 120.47011946679432, 17.902835762517046], 'EPSG:4326', 'EPSG:3857')
            })

            const ilocos_Sur_NSM_1977_2022 = new TileLayer({
                source: new TileWMS({
                    url: 'http://10.10.56.5:3655/geoserver/ne/wms',
                    params: {
                        'LAYERS': 'ne:Ilocos_Sur_NSM_1977_2022',
                        'TILED': true,
                        'FORMAT': 'image/png',
                        'SRS': 'EPSG:32651'
                    },
                    serverType: 'geoserver'
                }),
                visible: false,
                title: 'Ilocos Sur NSM 1977-2022',
                extent: transformExtent([120.33311300640369, 16.92223405502681, 120.47011946679432, 17.902835762517046], 'EPSG:4326', 'EPSG:3857')
            })

            const la_Union_EPR_1977_2022 = new TileLayer({
                source: new TileWMS({
                    url: 'http://10.10.56.5:3655/geoserver/ne/wms',
                    params: {
                        'LAYERS': 'ne:La_Union_EPR_1977_2022',
                        'TILED': true,
                        'FORMAT': 'image/png',
                        'SRS': 'EPSG:32651'
                    },
                    serverType: 'geoserver'
                }),
                visible: false,
                title: 'La Union EPR 1977-2022',
                extent: transformExtent([120.27361207663644, 16.206629015536805, 120.41852212717214, 16.9171909257348], 'EPSG:4326', 'EPSG:3857')
            })

            const la_Union_NSM_1977_2022 = new TileLayer({
                source: new TileWMS({
                    url: 'http://10.10.56.5:3655/geoserver/ne/wms',
                    params: {
                        'LAYERS': 'ne:La_Union_NSM_1977_2022',
                        'TILED': true,
                        'FORMAT': 'image/png',
                        'SRS': 'EPSG:32651'
                    },
                    serverType: 'geoserver'
                }),
                visible: false,
                title: 'La Union NSM 1977-2022',
                extent: transformExtent([120.27361207663644, 16.206629015536805, 120.41852212717214, 16.9171909257348], 'EPSG:4326', 'EPSG:3857')
            })

            const pangasinan_EPR_1977_2022 = new TileLayer({
                source: new TileWMS({
                    url: 'http://10.10.56.5:3655/geoserver/ne/wms',
                    params: {
                        'LAYERS': 'ne:Pangasinan_EPR_1977_2022',
                        'TILED': true,
                        'FORMAT': 'image/png',
                        'SRS': 'EPSG:32651'
                    },
                    serverType: 'geoserver'
                }),
                visible: false,
                title: 'Pangasinan Union EPR 1977-2022',
                extent: transformExtent([119.74269731224621, 15.81182175139877, 120.43011115764864, 16.399918522447717], 'EPSG:4326', 'EPSG:3857')
            })


            const pangasinan_NSM_1977_2022 = new TileLayer({
                source: new TileWMS({
                    url: 'http://10.10.56.5:3655/geoserver/ne/wms',
                    params: {
                        'LAYERS': 'ne:Pangasinan_NSM_1977_2022',
                        'TILED': true,
                        'FORMAT': 'image/png',
                        'SRS': 'EPSG:32651'
                    },
                    serverType: 'geoserver'
                }),
                visible: false,
                title: 'Pangasinan Union NSM 1977-2022',
                extent: transformExtent([119.74269731224621, 15.81182175139877, 120.43011115764864, 16.399918522447717], 'EPSG:4326', 'EPSG:3857')
            })


            // Create a group layer
            this.groupLayer = new LayerGroup({
                layers: [basemap1, padsanRiver100Yrs, ilocos_Norte_EPR_1977_2022, ilocos_Norte_NSM_1977_2022, ilocos_Sur_EPR_1977_2022, ilocos_Sur_NSM_1977_2022, la_Union_EPR_1977_2022, la_Union_NSM_1977_2022, pangasinan_EPR_1977_2022, pangasinan_NSM_1977_2022],
            });

            this.Options = this.groupLayer.getLayers().getArray().map((layer, index) => {
                return {
                    id: index,  // Generate an id using the index or create a unique id as needed
                    title: layer.get('title'),
                    opacity: this.opacityLevel,
                    visibility: true,
                };
            });

            // console.log(this.Options);

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

            this.map.on('pointerdrag', this.onMouseDrag); // Fires during drag
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
    top: 5px;
    left: 0px;
}

.navButtons {
    z-index: 10;
    position: absolute;
    top: 50px;
    right: 20px;
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
