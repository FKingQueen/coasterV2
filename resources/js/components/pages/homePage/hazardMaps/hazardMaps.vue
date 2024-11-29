<template>
    <div class="w-full flex">
        <div ref="map" class="full-screen-map w-full">
        </div>
        <div class="overlay-container p-1" id="popup">
            <span id="feature-additional-info" ></span>
            <div class="flex justify-between w-full items-center">
                <p class="capitalize" id="layerTitle"></p>
                <button @click="closePopup()" class="capitalize">x</button>
            </div>
            <div class="flex justify-center">
                <Table height="200" :columns="columns" :data="data" class="w-full"></Table>
            </div>
            
        </div>
    </div>
</template>

<script>

// Vue Libraries
import { defineComponent, ref, nextTick, h } from 'vue';
// OpenLayers Libraries

import "ol/ol.css";
import Map from "ol/Map";
import View from "ol/View";
import TileLayer from "ol/layer/Tile";
import FullScreen from "ol/control/FullScreen";
import { fromLonLat } from 'ol/proj';
import { Fill, Style, Stroke } from "ol/style";
// import VectorLayer from "ol/layer/Vector"; // Correct import statement
// import VectorSource from "ol/source/Vector"; // Add VectorSource import
import { XYZ } from "ol/source";
// import GeoJSON from 'ol/format/GeoJSON';

// Datatables
import { DataTable } from 'datatables.net-vue3';
import Select from 'datatables.net-select';
// Components

// Overview Component
import Overlay from "ol/Overlay";
import VectorLayer from "ol/layer/Vector";
import VectorSource from "ol/source/Vector";
import GeoJSON from "ol/format/GeoJSON";
import LayerGroup from "ol/layer/Group";


export default defineComponent({
    components: {
        DataTable,
    },
    setup() {
        const visible = ref(false);
        return {
            visible,
            popup: null,
        };
    },
    data() {
        const data = [
            { name: 'John Doe', age: 30, city: 'New York' },
            { name: 'Jane Smith', age: 25, city: 'San Francisco' },
            { name: 'Bob Johnson', age: 35, city: 'Chicago' }
        ];
        return {
            // data,
            columns: [
                {
                    title: 'Attribute',
                    key: 'attribute'
                },
                {
                    title: 'Value',
                    key: 'value'
                },
            ],
            data: [],
            overlayLayer: null
        }
    },
    async mounted() {
        this.initializeMap();
    },
    methods: {
        initializeMap() {
            const thiss = this;
            // Define the tile layers
            const satelliteLayer = new TileLayer({
                source: new XYZ({
                    url: "https://api.mapbox.com/styles/v1/pcborja/clt6utkbc00g801raamfl71ab/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoicGNib3JqYSIsImEiOiJjbG5sZm9weGIxYzg4MmxtbmpqYjd2YXIxIn0.LmH0x1Rn3NDzJdzq3J6Ayg",
                }),
                visible: true,
                title: 'basemap1'
            });

            // Define GeoJSON layers
            const provinceLayer = new VectorLayer({
                source: new VectorSource({
                    url: "/shapefile/Region1_Province.geojson",
                    format: new GeoJSON(),
                }),
                style: new Style({
                    stroke: new Stroke({
                        color: "blue",
                        width: 2,
                    }),
                    fill: new Fill({
                        color: "rgba(0, 0, 255, 0.1)",
                    }),
                }),
                visible: true,
                title: 'region1'
            });
            // NSM Region 1
            const nsmLayer = new VectorLayer({
                source: new VectorSource({
                    url: "/shapefile/Region1_NSM.geojson",
                    format: new GeoJSON(),
                }),
                style: new Style({
                    stroke: new Stroke({
                        color: "green",
                        width: 2,
                    }),
                    fill: new Fill({
                        color: "rgba(0, 255, 0, 0.1)",
                    }),
                }),
                visible: false,
                title: 'NSM'
            });
            // EPR Region 1
            const eprLayer = new VectorLayer({
                source: new VectorSource({
                    url: "/shapefile/Region1_EPR.geojson",
                    format: new GeoJSON(),
                }),
                style: new Style({
                    stroke: new Stroke({
                        color: "green",
                        width: 2,
                    }),
                    fill: new Fill({
                        color: "rgba(0, 255, 0, 0.1)",
                    }),
                }),
                visible: true,
                title: 'EPR'
            });

            // Create a group layer
            const groupLayer = new LayerGroup({
                layers: [satelliteLayer, eprLayer, provinceLayer, nsmLayer],
            });

            // Initialize the map
            this.map = new Map({
                target: this.$refs.map,
                layers: [groupLayer],
                view: new View({
                    center: fromLonLat([121.007046, 17.156009]),
                    zoom: 8,
                }),
                controls: [new FullScreen()],
            });
            const overlayContainerElement = document.getElementById('popup');

            // Create a popup overlay
            this.overlayLayer = new Overlay({
                element: overlayContainerElement,
                positioning: "bottom-center",
                // stopEvent: false,
            });

            this.map.addOverlay(this.overlayLayer)

            const overlayTitle = document.getElementById('layerTitle');

            // Add a click event to show the popup
            this.map.on("click", (event) => {
                let featureFound = false;
                this.map.forEachFeatureAtPixel(event.pixel, (feature, layer) => {
                    const properties = feature.getProperties();

                    const layerTitle = layer.get('title');

                    const formattedData = Object.entries(properties)
                        .filter(([key]) => key !== 'geometry') // Exclude geometry
                        .map(([key, value]) => ({
                            attribute: key,
                            value: value
                        }));

                    // Populate the data array
                    this.data = formattedData;

                    overlayTitle.innerHTML = `Layer Name: ` + layerTitle

                    let coordinate = event.coordinate;
                    // console.log(properties);
                    this.overlayLayer.setPosition(coordinate);
                    featureFound = true;
                });



                // Hide the popup if no feature was found
                if (!featureFound) {
                    this.data = []
                    this.overlayLayer.setPosition(undefined);
                }
            });
        },
        closePopup(){
            this.overlayLayer.setPosition(undefined);
        }
    }
});
</script>

<style scoped>
/* Add any component-specific styles here */
.full-screen-map {
    position: relative;
    width: 100%;
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
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -10px;
    border-width: 10px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
}
</style>