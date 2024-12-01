<template>
    <div class="w-full flex">
        <a-checkbox-group v-model:value="checkedValues" @change="onCheck()" :options="plainOptions"
            class="vertical-checkbox-group space-y-2" />
        <div ref="map" class="full-screen-map w-full">
        </div>
        <div class="overlay-container p-1" id="popup">
            <span id="feature-additional-info"></span>
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
import XYZ from 'ol/source/XYZ';
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

import VectorTileLayer from 'ol/layer/VectorTile'
import VectorTileSource from 'ol/source/VectorTile'
import MVT from 'ol/format/MVT'



export default defineComponent({
    components: {
        DataTable,
    },
    setup() {
        const visible = ref(false);
        const plainOptions = [
            'End point Rate (m/yr) of Region 1, Philippines',
            'Net shorline movement (m) of Region 1, Philippines',
        ]

        const checkedValues = ref([])
        return {
            visible,
            popup: null,
            plainOptions,
            checkedValues
        };
    },
    data() {

        return {
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
            overlayLayer: null,
            nsmLayer: null,
            eprLayer: null,
            groupLayer: null,

        }
    },
    async mounted() {
        this.initializeMap();
    },
    methods: {
        onCheck() {
            // console.log(this.checkedValues);
            // console.log(this.nsmLayer.get('title') );
            // console.log(this.groupLayer);
            const layers = this.groupLayer.getLayers()

            // Convert layers to an array if it's not already
            const layersArray = layers.getArray()

            // Iterate through layers
            layersArray.forEach(layer => {
                // Get the layer's title
                const layerTitle = layer.get('title')
                // Check if the layer's title is in the checked values
                if (layerTitle != 'basemap1') {
                    const isVisible = this.checkedValues.includes(layerTitle)
                    // Set layer visibility
                    layer.setVisible(isVisible)
                }
            })

        },
        initializeMap() {
            // Define the tile layers
            // mapbox://styles/pcborja/clt6v3fh3003d01r58rcg2h8p
            // mapbox://styles/pcborja/clt6utkbc00g801raamfl71ab
            const satelliteLayer = new TileLayer({
                source: new XYZ({
                    url: "https://api.mapbox.com/styles/v1/pcborja/clt6utkbc00g801raamfl71ab/tiles/256/{z}/{x}/{y}@2x?access_token=pk.eyJ1IjoicGNib3JqYSIsImEiOiJjbG5sZm9weGIxYzg4MmxtbmpqYjd2YXIxIn0.LmH0x1Rn3NDzJdzq3J6Ayg",
                }),
                visible: true,
                title: 'basemap1'
            });

            // Define GeoJSON layers
            // NSM Region 1
            // this.nsmLayer = new VectorLayer({
            //     source: new VectorSource({
            //         url: "/shapefile/Region1_NSM.geojson",
            //         format: new GeoJSON(),
            //     }),
            //     style: new Style({
            //         stroke: new Stroke({
            //             color: "green",
            //             width: 2,
            //         }),
            //         fill: new Fill({
            //             color: "rgba(0, 255, 0, 0.1)",
            //         }),
            //     }),
            //     visible: false,
            //     title: 'Net shorline movement (m) of Region 1, Philippines'
            // });\

            // mapbox://styles/pcborja/clt6utkbc00g801raamfl71ab
            // pcborja.a5uw2fn2

            // this.nsmLayer = new TileLayer({
            //     source: new XYZ({
            //         url: "https://studio.mapbox.com/tilesets/pcborja.a5uw2fn2",
            //     }),
            //     visible: true,
            //     title: 'basemap1'
            // });


            // new TileLayer({
            //     source: new XYZ({
            //         url: 'https://api.mapbox.com/styles/v1/pcborja.a5uw2fn2/tiles/{z}/{x}/{y}?access_token=sk.eyJ1IjoicGNib3JqYSIsImEiOiJjbTQzdDExa2swZTlzMmxxd2MwNGh2dGQ3In0._gs5QpMmULskjPvReidlUA',
            //         tileSize: 512,
            //         maxZoom: 18,
            //         visible: true,

            //     })
            // });

            const mapboxLayer = new VectorTileLayer({
                source: new VectorTileSource({
                    url: `https://api.mapbox.com/v4/pcborja.8nqhny0h/{z}/{x}/{y}.mvt?access_token=pk.eyJ1IjoicGNib3JqYSIsImEiOiJjbG5sZm9weGIxYzg4MmxtbmpqYjd2YXIxIn0.LmH0x1Rn3NDzJdzq3J6Ayg`,
                    format: new MVT(),
                    // tileLoadFunction: (tile, src) => {
                    //     console.log('Tile Loading:', src);
                    //     fetch(src)
                    //         .then(response => {
                    //             if (!response.ok) {
                    //                 console.error('Tile Load Error:', response.status, response.statusText);
                    //                 return response.text();
                    //             }
                    //             return response.blob();
                    //         })
                    //         .then(data => {
                    //             console.log('Tile Load Response:', data);
                    //             tile.getImage().src = URL.createObjectURL(data);
                    //         })
                    //         .catch(error => {
                    //             console.error('Tile Load Fetch Error:', error);
                    //         });
                    // }
                }),
                visible: true,
                title: 'Mapbox Custom Vector Tileset'
            })

            // EPR Region 1
            this.eprLayer = new VectorLayer({
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
                visible: false,
                title: 'End point Rate (m/yr) of Region 1, Philippines'
            });

            // Create a group layer
            this.groupLayer = new LayerGroup({
                layers: [satelliteLayer, this.eprLayer, mapboxLayer],
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
            const overlayContainerElement = document.getElementById('popup');

            // Create a popup overlay
            this.overlayLayer = new Overlay({
                element: overlayContainerElement,
                positioning: "center-center",
                // stopEvent: false,
            });

            this.map.addOverlay(this.overlayLayer)

            const overlayTitle = document.getElementById('layerTitle');

            // Add a click event to show the popup
            this.map.on("click", (event) => {
                let featureFound = false;
                this.map.forEachFeatureAtPixel(event.pixel, (feature, layer) => {
                    const properties = feature.getProperties();
                    console.log('properties: ', properties);
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

                    this.map.getView().animate({
                        center: coordinate,
                        duration: 500 // Optional: smooth animation duration
                    });
                });



                // Hide the popup if no feature was found
                if (!featureFound) {
                    this.data = []
                    this.overlayLayer.setPosition(undefined);
                }
            });
        },
        closePopup() {
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

.vertical-checkbox-group {
    display: flex;
    flex-direction: column;
}
</style>
