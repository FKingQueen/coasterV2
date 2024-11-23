<template>
    <div id="app">
      <h1>Weather Forecast</h1>
      <div>
        <label>Latitude:</label>
        <input v-model="latitude" placeholder="e.g., 51.5074" />
        <label>Longitude:</label>
        <input v-model="longitude" placeholder="e.g., -0.1278" />
        <button @click="getWeather">Get Weather</button>
      </div>
  
      <div v-if="weatherData">
        <h2>Weather Forecast</h2>
        <p><strong>Temperature:</strong> {{ weatherData.temperature }} °C</p>
        <p><strong>Wind Speed:</strong> {{ weatherData.wind }} m/s</p>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        latitude: "51.5074", // Default latitude for London
        longitude: "-0.1278", // Default longitude for London
        weatherData: null,
      };
    },
    methods: {
      async getWeather() {
//         "https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&current=temperature_2m,wind_speed_10m&hourly=temperature_2m,relative_humidity_2m,wind_speed_10m"

// {
        const url = `https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&current=temperature_2m,wind_speed_10m&daily=temperature_2m,relative_humidity_2m,wind_speed_10m`;
        try {
          const response = await axios.get(url);
            console.log(response);
        } catch (error) {
          console.error("Error fetching weather data:", error);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  #app {
    text-align: center;
    margin-top: 20px;
  }
  input {
    margin: 5px;
    padding: 8px;
    font-size: 16px;
  }
  button {
    padding: 8px 16px;
    font-size: 16px;
    cursor: pointer;
  }
  </style>
  