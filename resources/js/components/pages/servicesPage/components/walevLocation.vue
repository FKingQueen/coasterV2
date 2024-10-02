<template>
    <div ref="map" class="full-screen-map md:h-[10vh] h-[5vh]">
    </div>
</template>

<script>
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

// Vue Libraries
import { defineComponent, reactive, ref, nextTick } from 'vue';
// Components

export default defineComponent({
    props: ["id"],
    data() {
        return {
            wlmsMarkerInfo: [],
            vectorLayer: null,
            markerInfo: [],
            map: null,
        };
    },
    async mounted() {
        let thiss = this;
        this.initializeMap();
    },
    methods: {
        initializeMap() {
            let thiss = this;
            // Create the map
            this.vectorLayer = new VectorLayer({
                source: new VectorSource(),
            });
            this.map = new Map({
                target: this.$refs.map,
                layers: [
                    new TileLayer({
                        source: new XYZ({
                            url: "https://api.mapbox.com/styles/v1/pcborja/clt6utkbc00g801raamfl71ab/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoicGNib3JqYSIsImEiOiJjbG5sZm9weGIxYzg4MmxtbmpqYjd2YXIxIn0.LmH0x1Rn3NDzJdzq3J6Ayg",
                        }),
                    }),
                    this.vectorLayer,
                ],
                view: new View({
                    // center: fromLonLat([0, 0]),
                    center: thiss.id === 1 ? fromLonLat([120.571584, 18.200961]) : fromLonLat([120.466835, 17.557391]), 
                    zoom: 12,
                }),
                controls: [new FullScreen()],
            });
            // Render the Markers
            thiss.vectorLayer.getSource().clear();
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

            this.markerInfo.forEach(feature => {
                if (feature.get("name") == 'WLMS') {
                    feature.setStyle(markerStyleWLMS);
                }
            });

            this.vectorLayer.getSource().addFeatures(this.wlmsMarkerInfo);
            // Markers Display Validation
            const source = thiss.vectorLayer.getSource();
            const features = source.getFeatures();

            // Putting new Style to the markers
            for (let i = 0; i < features.length; i++) {
                const feature = features[i]
                if (feature.get("name") == 'WLMS') {
                    feature.setStyle(markerStyleWLMS);
                }
            }

            for (let i = 0; i < features.length; i++) {
                const feature = features[i]
                if (thiss.wlmsActive == false) {
                    if (feature.get("name") == 'WLMS') {
                        source.removeFeature(feature);
                    }
                }
            }
        },
    }
});
</script>

<style></style>

<style scoped>
.active {
    /* color: rgb(31 41 55); */
    background-color: #cee53a;
    color: white;
}
</style>