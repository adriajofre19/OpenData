<template>
    <div id="map" style="height: 400px;"></div>
  </template>
  
  <script>
  export default {
    mounted() {
      this.map = L.map('map').setView([51.505, -0.09], 13);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(this.map);
    }
  }
  </script>
  
  <style scoped>
  #map {
    width: 100%;
  }
  </style>
  