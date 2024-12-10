<template>
    <div
        class="max-w-sm mx-auto mt-5 bg-white border border-gray-200 shadow-md rounded-lg overflow-hidden"
    >
        <div class="p-4">
            <h2 class="text-lg font-semibold text-gray-700">
                Current Weather - New York City
            </h2>
            <div class="mt-4">
                <!-- Weather information -->
                <template v-if="weather?.current?.temp">
                    <p class="text-4xl font-bold text-gray-800">
                        {{ weather.current.temp }}°C
                    </p>
                    <p class="text-sm text-gray-500 mt-2">
                        {{ weather.current.weather[0]?.description }}
                    </p>
                </template>
                <template v-else>
                    <p class="text-lg text-red-500">Weather data unavailable</p>
                </template>
            </div>
            <div class="mt-4 space-y-2">
                <p>
                    <strong>Humidity:</strong> {{ weather?.current?.humidity }}%
                </p>
                <p>
                    <strong>Wind Speed:</strong>
                    {{ weather?.current?.wind_speed }} m/s
                </p>
            </div>
        </div>
        <div
            class="bg-blue-100 py-2 px-4 text-center text-xs text-gray-700 border-t"
        >
            Data provided by OpenWeather
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const weather = ref({});

const fetchWeatherData = async () => {
    try {
        const response = await axios.get("/weather");
        weather.value = response.data; // Assign fetched data to the Vue `weather` state
    } catch (error) {
        console.error("Error fetching weather data:", error);
    }
};

// Fetch the weather data when the component is mounted
onMounted(() => {
    fetchWeatherData();
});
</script>

<style scoped>
/* Add custom styles if necessary */
</style>
