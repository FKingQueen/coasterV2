<template>
    <div class="w-full flex">
        <div ref="map" class="full-screen-map h-[90vh]">
            <div id="legend" class="legend">
                <div class=" text-white text-sm rounded-md grid grid-cols-1">
                    <div class="flex justify-start space-x-2">
                        <div class="items-center flex">
                            <span class="h-3 w-4 border border-black"
                                style="background-color: white; border-radius: 50%; display: inline-block;"></span>
                        </div>
                        <div class="text-justify w-full">Bouy Monitoring System</div>
                    </div>
                    <div class="flex justify-start space-x-2">
                        <div class="items-center flex">
                            <span class="h-3 w-4 border"
                                style="background-color: blue; border-radius: 50%; display: inline-block;"></span>
                        </div>
                        <div class="text-justify w-full">Water Level Monitoring System</div>
                    </div>
                    <div class="flex justify-start space-x-2">
                        <div class="items-center flex">
                            <span class="h-3 w-4 border"
                                style="background-color: green; border-radius: 50%; display: inline-block;"></span>
                        </div>
                        <div class="text-justify w-full">Coastal Flood Protection Structure</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-2/7 items-center bg-[#DDE6ED] a p-4 border ">
            <div class=" drop-shadow-md shadow-md p-2 bg-[#154184]">
                <p class="text-center uppercase text-2xl text-white">Structure & Monitoring System</p>
                <p class="text-center uppercase text-sm text-white p-1">-- Select --</p>
                <div class="w-full text-white rounded-md">
                    <div :class="{ active: bmsActive }"
                        class="p-2 h-2/6 w-full cursor-pointer text-center border-x-2 border-t-2 border-b-2 border-[#154184]  hover:bg-sky-600 tracking-widest"
                        @click="bmsActive = !bmsActive, filter1()">
                        BMS
                    </div>
                    <div :class="{ active: wlmsActive }"
                        class="p-2 h-2/6 w-full cursor-pointer text-center border-x-2 border-b-2 border-[#154184] hover:bg-sky-600 tracking-widest"
                        @click="wlmsActive = !wlmsActive, filter1()">
                        WLMS
                    </div>
                    <div :class="{ active: cfpsActive }"
                        class="p-2 h-2/6  w-full cursor-pointer text-center border-x-2 border-b-2 border-[#154184] hover:bg-sky-600 tracking-widest"
                        @click="cfpsActive = !cfpsActive, filter1()">
                        CFPS
                    </div>
                </div>
            </div>
            <a-divider style="height: 2px; background-color: #154184" />
            <div class=" drop-shadow-md shadow-md p-2 bg-[#154184]">
                <p class="text-center uppercase text-2xl text-white">Tropical Cyclone</p>
                <p class="text-center uppercase text-sm text-white p-1">-- Select --</p>
            </div>
        </div>
        <div>
            <div ref="sample" class="ol-popup ">
                <button @click="this.closePopup()" class="ol-popup-closer"></button>
                <WaterLevel v-if="this.selectedName == 'WLMS'" class="w-full" :id="this.selectedID" />
                <Places v-if="this.selectedName == 'CFPS'" class="w-full" :id="this.selectedID" />
                <Bouy v-if="this.selectedName == 'BOUY'" :id="this.selectedID" />
            </div>
        </div>
        
    </div>
</template>
  
<script>
// Vue Libraries
import { defineComponent, ref, nextTick } from 'vue';
// OpenLayers Libraries
import "ol/ol.css";
import Map from "ol/Map";
import View from "ol/View";
import TileLayer from "ol/layer/Tile";
import FullScreen from "ol/control/FullScreen";
import { fromLonLat } from 'ol/proj';
import Feature from "ol/Feature";
import Point from "ol/geom/Point";
import { Circle, Fill, Style, Stroke } from "ol/style";
import VectorLayer from "ol/layer/Vector"; // Correct import statement
import VectorSource from "ol/source/Vector"; // Add VectorSource import
import { OSM, Vector } from "ol/source";



import Overlay from "ol/Overlay";
import { XYZ } from "ol/source";
// Components
import Places from './components/places';
import WaterLevel from './components/waterLevel';
import Bouy from './components/bouy';
export default defineComponent({
    components: {
        // Description,
        // Delft3D,
        WaterLevel,
        Places,
        Bouy,
    },
    data() {
        return {
            bmsActive: ref(true),
            wlmsActive: ref(true),
            cfpsActive: ref(false),
            map: null,
            vectorLayer: null,
            markerInfo: [],
            popup: null,
            cfpsMarkerInfo: [],
            wlmsMarkerInfo: [],
            bouyMarkerInfo: [],
            data: null,
            selectedName: null,
            selectedID: null
        };
    },
    async mounted() {
       
        let existingObj = this;
        await axios.get('/api/getMapInventory')
        .then(response => {
            for(let i = 0; i < response.data.length; i++){
                existingObj.cfpsMarkerInfo.push(
                    new Feature({
                        geometry: new Point(fromLonLat([response.data[i].longitude, response.data[i].latitude])),
                        id: response.data[i].id,
                        name: "CFPS",
                    })
                );
            }
        })
        .catch(function (error) {
            console.error(error);
        });
        this.initializeMap();
    },
    methods: {  
        initializeMap() {
            // Create the map
            this.vectorLayer = new VectorLayer({
                source: new VectorSource(),
            });
            this.map = new Map({
                target: this.$refs.map,
                layers: [
                    new TileLayer({
                        source: new XYZ({
                            url: "https://api.mapbox.com/styles/v1/pcborja/clp6yp9ex00e201rcgbj618ge/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoicGNib3JqYSIsImEiOiJjbG5sZm9weGIxYzg4MmxtbmpqYjd2YXIxIn0.LmH0x1Rn3NDzJdzq3J6Ayg",
                        }),
                    }),
                    this.vectorLayer,
                ],
                view: new View({
                    // center: fromLonLat([0, 0]),
                    center: fromLonLat([121.007046, 17.156009]),
                    zoom: 8,
                }),
                controls: [new FullScreen()],
            });

            // Render the Markers
            this.filter1();

            // Add an overlay to display a popup on the marker
            this.popup = new Overlay({
                element: this.$refs.sample,
                positioning: "bottom-center",
                offset: [0, -5],
            });

            this.map.addOverlay(this.popup);

            // Add a click event to show the popup
            this.map.on("click", (event) => {
                const feature = this.map.forEachFeatureAtPixel(
                    event.pixel,
                    (feature) => feature
                );

                if (feature) {
                    this.selectedName = feature.get('name')
                    this.selectedID = feature.get('id')
                    const coordinates = feature.getGeometry().getCoordinates();
                    this.popup.setPosition(coordinates);
                    setTimeout(() => {
                        this.popup.panIntoView();
                    }, 100); // Adjust the delay as needed
                }

            });

        },
        closePopup() {
            // Closing the modal
            this.popup.setPosition(undefined);
            this.map.getView().animate({
                center: fromLonLat([121.007046, 17.156009]),
                zoom: 8,
                duration: 1000, // Animation duration in milliseconds
            });

        },
        filter1() {
            // Store All Marker Data into MarkerInfo
            this.vectorLayer.getSource().clear();

            this.wlmsMarkerInfo = [
                new Feature({
                    geometry: new Point(fromLonLat([120.571584, 18.200961])),
                    id: 1,
                    name: "WLMS",
                }),
                new Feature({
                    geometry: new Point(fromLonLat([120.466835, 17.557391])),
                    name: "WLMS",
                    id: 2,
                }),
            ];
            this.bouyMarkerInfo = [
                new Feature({
                    geometry: new Point(fromLonLat([120.471584, 18.200961])),
                    name: "BOUY",
                    id: 1,
                }),
                new Feature({
                    geometry: new Point(fromLonLat([120.296835, 17.557391])),
                    name: "BOUY",
                    id: 2,
                }),
            ];

            // Define a custom style for the markers
            const markerStyleWLMS = new Style({
                image: new Circle({
                    radius: 5,
                    fill: new Fill({
                        color: 'Blue', // Color of the circle

                    }),
                    stroke: new Stroke({ color: 'White', width: 1 }) // Set the stroke color and width
                }),
            });
            const markerStyleBOUY = new Style({
                image: new Circle({
                    radius: 5,
                    fill: new Fill({
                        color: 'White', // Color of the circle

                    }),
                    stroke: new Stroke({ color: 'Black', width: 1 }) // Set the stroke color and width
                }),
            });
            const markerStyleCFPS = new Style({
                image: new Circle({
                    radius: 5,
                    fill: new Fill({
                        color: 'Green', // Color of the circle

                    }),
                    stroke: new Stroke({ color: 'White', width: 1 }) // Set the stroke color and width
                }),
            });

            // Apply the custom style to each feature
            this.markerInfo.forEach(feature => {
                if (feature.get("name") == 'BOUY') {
                    feature.setStyle(markerStyleBOUY);
                }
                if (feature.get("name") == 'WLMS') {
                    feature.setStyle(markerStyleWLMS);
                }
                if (feature.get("name") == 'CFPS') {
                    feature.setStyle(markerStyleCFPS);
                }
            });

            // this.vectorLayer.getSource().addFeatures(this.markerInfo);
            this.vectorLayer.getSource().addFeatures(this.wlmsMarkerInfo);
            this.vectorLayer.getSource().addFeatures(this.bouyMarkerInfo);
            this.vectorLayer.getSource().addFeatures(this.cfpsMarkerInfo);

            let existingObj = this;
            // Markers Display Validation
            const source = existingObj.vectorLayer.getSource();
            const features = source.getFeatures();

            // Putting new Style to the markers
            for (let i = 0; i < features.length; i++) {
                const feature = features[i]
                if (feature.get("name") == 'BOUY') {
                    feature.setStyle(markerStyleBOUY);
                }
                if (feature.get("name") == 'WLMS') {
                    feature.setStyle(markerStyleWLMS);
                }
                if (feature.get("name") == 'CFPS') {
                    feature.setStyle(markerStyleCFPS);
                }
            }

            // Removing All Markers that are false
            for (let i = 0; i < features.length; i++) {
                const feature = features[i]
                if (existingObj.bmsActive == false) {
                    if (feature.get("name") == 'BOUY') {
                        source.removeFeature(feature);
                    }
                }
                if (existingObj.wlmsActive == false) {
                    if (feature.get("name") == 'WLMS') {
                        source.removeFeature(feature);
                    }
                }
                if (existingObj.cfpsActive == false) {
                    if (feature.get("name") == 'CFPS') {
                        source.removeFeature(feature);
                    }
                }
            }
        },
    },
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

.legend {
    z-index: 1000;
    position: absolute;
    bottom: 20px;
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
  