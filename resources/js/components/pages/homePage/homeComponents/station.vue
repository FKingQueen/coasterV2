<template>
    <div class="w-full bg-white text-zinc-700">
        <div class="w-full border">
            <div class="w-full border-b flex w-full px-3 py-2 justify-center">
                <div class="w-full flex space-x-2 justify-center">
                    <div class="w-full flex items-center justify-center">
                        <p class="text-sm text-center">
                            COASTER Stations: Real-Time Status Updates
                        </p>
                    </div>
                </div>
            </div>
            <div class="w-full p-2">
                <p class="py-1 text-xs">Buoy Monitoring System</p>
                <div class=" flex w-full p-3 space-x-2 justify-between">
                    <div class="flex items-center w-1/4">
                        <div>
                            <img src="/img/icons/buoy.png" class="blur-none antialiased h-20 " alt="#">
                            <p class="text-xs text-center">Laoag City</p>
                        </div>
                    </div>
                    <div class="w-3/4 flex items-center">
                        <div class="w-full">
                            <table class="w-full border-none">
                                <tbody>
                                    <tr class="border-b">
                                        <td class="py-1 text-xs">Tide</td>
                                        <td class="py-1 text-xs">{{ parseFloat(stationData.buoyData1.altitude_pressure / 100).toFixed(2) }}</td>
                                        <td class="py-1 text-xs">m</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-1 text-xs">Air Temperature</td>
                                        <td class="py-1 text-xs">{{ parseFloat(stationData.buoyData1.water_temperature).toFixed(2) }}</td>
                                        <td class="py-1 text-xs">°C</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-1 text-xs">Water Temperature</td>
                                        <td class="py-1 text-xs">{{ parseFloat(stationData.buoyData1.barometric_temperature).toFixed(2) }}</td>
                                        <td class="py-1 text-xs">°C</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-1 text-xs">Significant Wave Height</td>
                                        <td class="py-1 text-xs">{{ parseFloat(stationData.buoyData1.significant_wave_height).toFixed(2) }}
                                        </td>
                                        <td class="py-1 text-xs">m</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-1 text-xs">Wave Period</td>
                                        <td class="py-1 text-xs">{{ parseFloat(stationData.buoyData1.wave_period).toFixed(2) }}</td>
                                        <td class="py-1 text-xs">secs</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="text-end text-xs">
                                {{ stationData.buoyData1.formatted_date }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="border-b flex w-full p-3 space-x-2 justify-between">
                    <div class="flex items-center w-1/4">
                        <div>
                            <img src="/img/icons/buoy.png" class="blur-none antialiased h-20 " alt="#">
                            <p class="text-xs text-center">Santa</p>
                        </div>
                    </div>
                    <div class="w-3/4 flex items-center">
                        <div class="w-full">

                            <table class="w-full border-none">
                                <tbody>
                                    <tr class="border-b">
                                        <td class="py-1 text-xs">Tide</td>
                                        <td class="py-1 text-xs">{{  parseFloat(stationData.buoyData2.altitude_pressure / 100).toFixed(2) }}</td>
                                        <td class="py-1 text-xs">m</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-1 text-xs">Air Temperature</td>
                                        <td class="py-1 text-xs">{{  parseFloat(stationData.buoyData2.water_temperature).toFixed(2) }}</td>
                                        <td class="py-1 text-xs">°C</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-1 text-xs">Water Temperature</td>
                                        <td class="py-1 text-xs">{{ parseFloat(stationData.buoyData2.barometric_temperature).toFixed(2) }}</td>
                                        <td class="py-1 text-xs">°C</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-1 text-xs">Significant Wave Height</td>
                                        <td class="py-1 text-xs">{{ parseFloat(stationData.buoyData2.significant_wave_height).toFixed(2) }}
                                        </td>
                                        <td class="py-1 text-xs">m</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-1 text-xs">Wave Period</td>
                                        <td class="py-1 text-xs">{{ parseFloat(stationData.buoyData2.wave_period).toFixed(2) }}</td>
                                        <td class="py-1 text-xs">secs</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="text-end text-xs">
                                {{ stationData.buoyData2.formatted_date }}
                            </p>
                        </div>
                    </div>
                </div>
                <p class="py-1 text-xs">Water Level Monitoring System</p>
                <div class="border-b  w-full p-3 space-y-5">
                    <div class="w-full flex items-center space-x-10 md:space-x-5 justify-between">
                        <div>
                            <img src="/img/icons/wlms.jpg" class="blur-none antialiased h-20 " alt="#">
                            <p class="text-xs text-center">Padsan River</p>
                        </div>
                        <div class="w-3/4 items-center">
                            <table class="w-full border-none">
                                <tbody>
                                    <tr class="border-b">
                                        <td class="py-1 text-xs">Water Level</td>
                                        <td class="py-1 text-xs">{{ parseFloat((Math.round((13.5 - stationData.wlmsData1.level) * 100) / 100)).toFixed(2) }}</td>
                                        <td class="py-1 text-xs">m</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-1 text-xs">Temperature</td>
                                        <td class="py-1 text-xs">{{ parseFloat(stationData.wlmsData1.temperature).toFixed(2) }}</td>
                                        <td class="py-1 text-xs">°C</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-1 text-xs">Humidity</td>
                                        <td class="py-1 text-xs">{{ parseFloat(stationData.wlmsData1.humidity).toFixed(2) }}</td>
                                        <td class="py-1 text-xs">%</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="text-end text-xs">
                                {{ stationData.wlmsData1.formatted_date }}
                            </p>
                        </div>
                    </div>
                    <div class="w-full flex items-center space-x-10 md:space-x-5 justify-between">
                        <div>
                            <img src="/img/icons/wlms.jpg" class="blur-none antialiased h-20 " alt="#">
                            <p class="text-xs text-center">Lagben River</p>
                        </div>
                        <div class="w-3/4 items-center">
                            <table class="w-full border-none">
                                <tbody>
                                    <tr class="border-b">
                                        <td class="py-1 text-xs">Water Level</td>
                                        <td class="py-1 text-xs">{{ parseFloat(Math.round((26  - stationData.wlmsData2.level) * 100) / 100).toFixed(2) }}</td>
                                        <td class="py-1 text-xs">m</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-1 text-xs">Temperature</td>
                                        <td class="py-1 text-xs">{{ parseFloat(stationData.wlmsData2.temperature).toFixed(2) }}</td>
                                        <td class="py-1 text-xs">°C</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-1 text-xs">Humidity</td>
                                        <td class="py-1 text-xs">{{ parseFloat(stationData.wlmsData2.humidity).toFixed(2) }}</td>
                                        <td class="py-1 text-xs">%</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="text-end text-xs">
                                {{ stationData.wlmsData2.formatted_date }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';

export default defineComponent({
    data() {
        return {
            stationData: {
                buoyData1: '',
                buoyData2: '',
                wlmsData1: '',
                wlmsData2: '',
            },
            intervalId: null
        }
    },
    async created() {
        // Fetch data immediately when component is created
        await this.fetchStationData();

        // Set up interval to fetch data every 5 minutes (300000 milliseconds)
        this.intervalId = setInterval(async () => {
            await this.fetchStationData();
        }, 300000);
    },
    methods: {
        async fetchStationData() {
            try {
                const response = await axios.get('/api/getStationCurrentData');
                this.stationData.wlmsData1 = response.data[0];
                this.stationData.wlmsData2 = response.data[1];
                this.stationData.buoyData1 = response.data[2];
                this.stationData.buoyData2 = response.data[3];
            } catch (error) {
                console.error('Error fetching station data:', error);
            }
        }
    },
    // Important: Clear the interval when the component is destroyed to prevent memory leaks
    beforeUnmount() {
        if (this.intervalId) {
            clearInterval(this.intervalId);
        }
    }
})
</script>

<style scoped></style>
