<script setup>
import { ref } from "vue";
import Dropdown from 'primevue/dropdown';
import axios from "axios";
import { onMounted } from "vue";
import Navbar from "@/Components/Navbar.vue";
import Background from "@/Components/Background.vue";
import { Head } from "@inertiajs/vue3";

const cityRecords = ref([]);
const selectedCity = ref();
const cities = ref([]);

onMounted(() => {
    getAllCities();
});

function getAllCities() {
  axios.get('https://analisi.transparenciacatalunya.cat/resource/8gmd-gz7i.json')
    .then(response => {
      const poblaciones = response.data.map(item => item.poblacio);
      const poblacionesUnicas = [...new Set(poblaciones)];
      cities.value = poblacionesUnicas.map(city => ({ name: city }));
    })
    .catch(error => {
      console.error('Error al obtener datos:', error);
    });
}

async function getInfoAboutCity() {
  if (selectedCity.value && selectedCity.value.name) {
    const cityName = selectedCity.value.name;
    const totalRecords = [];
    const pageSize = 100; 
    let page = 0;

    try {
      while (true) {
        const response = await axios.get(`https://analisi.transparenciacatalunya.cat/resource/8gmd-gz7i.json?poblacio=${cityName}&$limit=${pageSize}&$offset=${page * pageSize}`);
        const records = response.data;
        
        if (records.length === 0) {
          break;
        }
        
        const culturaRecords = records.filter(record => record.categoria && record.categoria.toLowerCase().startsWith('cultura'));
        totalRecords.push(...culturaRecords);
        page++;
      }

      cityRecords.value = totalRecords;
      let noteworthySection = document.getElementById('noteworthy-section');
      noteworthySection.scrollIntoView({ behavior: 'smooth' });
    } catch (error) {
      console.error('Error al buscar registros por ciudad:', error);
    }
  }
} 

function addCityToFavorites(selectedCity) {
  console.log('Añadir ciudad a favoritos:', selectedCity.value);

} 
</script>

<template>

  <Head title="Centres Culturals" />

  <Navbar />

  <div class="w-full min-h-screen flex flex-col items-center justify-center overflow-hidden bg-white mb-2" style="background-image: url('/images/home/Ciudad.jpg');">
    <Dropdown v-model="selectedCity" editable :options="cities" optionLabel="name" placeholder="Selecciona una ciutat" class="md:w-14rem" @change="getInfoAboutCity" />
  </div>

  <div v-if="cityRecords.length > 0">
    <Background>
      <div class="flex flex-col items-center justify-center min-h-screen w-full" id="noteworthy-section">
        <div class="container m-4">
          <div class="max-w-6xl w-full mx-auto grid gap-4 grid-cols-1">
            <div v-for="(record, index) in cityRecords" :key="index" class="flex flex-col sticky top-0 z-10">
              <div class="bg-white shadow-lg rounded-xl p-4">
                <div class="flex-none sm:flex">
                  <div class=" relative h-32 w-32   sm:mb-0 mb-3">
                    <img src="/images/home/Ciudad.jpg" alt="Ciutat" class=" w-32 h-32 object-cover rounded-2xl">
                  </div>
                  <div class="flex-auto sm:ml-5 justify-evenly">
                    <div class="flex items-center justify-between sm:mt-2">
                      <div class="flex items-center">
                        <div class="flex flex-col">
                          <div class="w-full flex-none text-lg text-gray-900 font-bold leading-none">{{ record.alies }}</div>
                            <div class="flex-auto text-gray-600 my-1">
                              <span class="mr-3 ">{{ record.via, record.num}}</span><span class="mr-3 border-r border-gray-600  max-h-0"></span><span>Tel: {{ record.telefon1 }}</span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="flex flex-row items-center">
                        <div class="flex">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 text-yellow-400">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                          </svg>
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 text-yellow-400">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                          </svg>
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 text-yellow-400">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                          </svg>
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 text-yellow-400">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                          </svg>
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 text-yellow-400">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                          </svg>
                        </div>
                      </div>
                      <div class="flex pt-2  text-sm text-gray-400">
                        <div class="flex-1 inline-flex items-center">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
                          </svg>
                          <p class="text-gray-600">1.2k Followers</p>
                        </div>
                        <a :href="route('culturalspaces.getSpaceCulture', { id: record.idequipament })" target="_blank" class="flex-no-shrink bg-blue-600 px-5 ml-4 py-2 text-xs shadow-sm font-medium tracking-wider border-2 text-white rounded-md transition ease-in duration-300">Més informació</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </Background>
    </div>
    
</template>