<script setup>
import axios from 'axios';
import { defineProps } from 'vue';
import L from 'leaflet';
import { ref, onMounted } from 'vue';
import { initFlowbite } from 'flowbite';
import { useForm } from '@inertiajs/vue3';
import Background from '@/Components/Background.vue';
import Carousel from 'primevue/carousel';
import Textarea from 'primevue/textarea';
import Navbar from '@/Components/Navbar.vue';

const props = defineProps(['id']);
const culturalSpace = ref([]);
const comments = ref([]);
const products = ref();
let info = ref();

let latitud = null;
let longitud = null;

const form = useForm({
  idequipament: props.id,
  content: '',
  assessment: '',
  id_user: '',
});

const submit = () => {
  form.post('/addcomment', form);
  getCommentsById(props.id);
  form.content = '';
  form.assessment = '';
};

const id_town = ref('');

function getIdTownByName(name){
  axios.get('/getIdTownByName/'+name).then(response => {
      id_town.value = response.data.id;
      getSesionUser();
      console.log('Usuari: '+id_user.value);
      console.log('Població: '+id_town.value);
      axios.post('/addfavouritepoblacio/'+id_town.value+'/'+id_user.value);
  });   
} 

const id_user = ref('');

function getSesionUser(){
    axios.get('/getsessionuser').then(response => {
        id_user.value = response.data.id;
        
    });
}

async function addFavouritePoblacio(name) {
  axios.post('/addfavouritepoblacio/'+name);
  console.log('Afegit a preferits ' + name);
  getIdTownByName(name);
}

async function addFavoutieCulturalSpace(name) {
  axios.post('/addfavouriteculturalspace/'+name);
  console.log('Afegit a preferits ' + name);
  getIdCultureSpaceByName(name);
}

const id_cultural_space = ref('');

function getIdCultureSpaceByName(name){
  axios.get('/getIdCultureSpaceByName/'+name).then(response => {
      id_cultural_space.value = response.data;
      console.log('Usuari: '+id_user.value);
      console.log('Centre cultural: '+id_cultural_space.value);
      axios.post('/addfavouriteculturalspace/'+id_cultural_space.value+'/'+id_user.value);
  });   
}

onMounted(() => {
  getSesionUser();
  getSpacesById(props.id);
  initFlowbite();
  getCommentsById(props.id);
});

function getSpacesById(id){
  axios.get('https://analisi.transparenciacatalunya.cat/resource/8gmd-gz7i.json?idequipament='+id)
  .then(response => {
      culturalSpace.value = response.data;
      console.log(culturalSpace);
      latitud = response.data[0].latitud;
      longitud = response.data[0].longitud;
      console.log(response.data[0])
      info.value=response.data[0];
      initMap(latitud, longitud); 
  })
}

function initMap(latitud, longitud) {
  const map = L.map('map').setView([latitud, longitud], 10);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  const marker = L.marker([latitud, longitud], { draggable: true }).addTo(map);
}
 
function getCommentsById(id){
    axios.get('/getCommentsById/'+id)
    .then(response => {
        comments.value = response.data;
        products.value = response.data;
        console.log('Comentaris'+comments);
    })
}
</script>

<template>

  <Navbar />

  <Background>
    <div class="flex flex-col items-center justify-center min-h-screen w-full">
      <div class="container m-4">
        <div class="max-w-6xl w-full mx-auto grid gap-4 grid-cols-1">

          <div v-for="record in culturalSpace" :key="record.index" class="flex flex-col top-0 z-10">
            <div class="bg-white rounded-xl p-4">
              <div class="flex-none sm:flex">
                <div class=" relative h-32 w-32   sm:mb-0 mb-3">
                  <img src="/images/home/Ciudad.jpg" alt="Ciutat" class=" w-32 h-32 object-cover rounded-md">
                </div>
                <div class="flex-auto sm:ml-5 justify-evenly">
                  <div class="flex items-center justify-between sm:mt-2">
                    <div class="flex items-center">
                      <div class="flex flex-col">
                        <div class="w-full flex-none text-lg text-gray-900 font-bold leading-none">{{ record.alies }}</div>
                        <div class="flex-auto text-gray-400 my-1">
                          <span class="mr-3 ">{{ record.via }}</span><span class="mr-3 border-r border-gray-600  max-h-0"></span><span>{{ record.poblacio }} {{ record.cpostal }}</span>
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
                      <p>1.2k Followers</p>
                    </div>         
                      <a @click="addFavouritePoblacio(record.poblacio)" class="flex-no-shrink bg-blue-600 px-5 ml-4 py-2 text-xs shadow-sm hover:shadow-lg font-medium cursor-pointer tracking-wider text-white rounded-md transition ease-in duration-300">AFEGIR LA POBLACIÓ A PREFERITS</a>
                      <a @click="addFavoutieCulturalSpace(record.alies)" class="flex-no-shrink bg-blue-600 px-5 ml-4 py-2 text-xs shadow-sm hover:shadow-lg font-medium cursor-pointer tracking-wider text-white rounded-md transition ease-in duration-300">AFEGIR EL CENTRE CULTURAL A PREFERITS</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="grid gap-4 grid-cols-1 md:grid-cols-2">
            <div class="flex flex-col p-4 relative items-center justify-center bg-white  rounded-xl">
              <div id="map" class="w-full rounded-xl" style="height: 350px;">
            </div>
          </div>

          <div v-for="record in culturalSpace" :key="record.index" class="flex flex-col space-y-4">
            <div class="flex flex-col p-4 bg-white rounded-xl cursor-pointer transition ease-in duration-500  transform hover:scale-105">
              <div class="flex items-center justify-between">
                <div class="flex items-center mr-auto">
                  <div class="inline-flex w-12 h-12">
                    <svg class="w-10 h-10 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M8 4a2.6 2.6 0 0 0-2 .9 6.2 6.2 0 0 0-1.8 6 12 12 0 0 0 3.4 5.5 12 12 0 0 0 5.6 3.4 6.2 6.2 0 0 0 6.6-2.7 2.6 2.6 0 0 0-.7-3L18 12.9a2.7 2.7 0 0 0-3.8 0l-.6.6a.8.8 0 0 1-1.1 0l-1.9-1.8a.8.8 0 0 1 0-1.2l.6-.6a2.7 2.7 0 0 0 0-3.8L10 4.9A2.6 2.6 0 0 0 8 4Z"/>
                    </svg>
                  </div>
                  <div class="flex flex-col ml-3">
                    <div class="font-medium leading-none text-gray-900">Telèfon</div>
                    <p v-if="record.telefon1" class="text-sm text-gray-500 leading-none mt-1">{{ record.telefon1 }}</p>
                    <p v-else class="text-sm text-gray-500 leading-none mt-1">No disponible</p>
                  </div>
                </div>  
              </div>
            </div>
            <div class="flex flex-col p-4 bg-white rounded-xl cursor-pointer transition ease-in duration-500  transform hover:scale-105">
              <div class="flex items-center justify-between">
                <div class="flex items-center mr-auto">
                  <div class="inline-flex w-12 h-12">
                    <svg class="w-10 h-10 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M2 5.6V18c0 1.1.9 2 2 2h16a2 2 0 0 0 2-2V5.6l-.9.7-7.9 6a2 2 0 0 1-2.4 0l-8-6-.8-.7Z"/>
                      <path d="M20.7 4.1A2 2 0 0 0 20 4H4a2 2 0 0 0-.6.1l.7.6 7.9 6 7.9-6 .8-.6Z"/>
                    </svg>
                  </div>
                  <div class="flex flex-col ml-3 min-w-0">
                    <div class="font-medium leading-none text-gray-900">Correu electrònic</div>
                    <p v-if="record.email" class="text-sm text-gray-500 leading-none mt-1 truncate">{{ record.email }}</p>
                    <p v-else class="text-sm text-gray-500 leading-none mt-1 truncate">No disponible</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex flex-col p-4 bg-white rounded-xl cursor-pointer transition ease-in duration-500  transform hover:scale-105">
              <div class="flex items-center justify-between">
                <div class="flex items-center mr-auto">
                  <div class="inline-flex w-12 h-12">
                    <svg class="w-10 h-10 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                      <path fill-rule="evenodd" d="M12 2a8 8 0 0 1 6.6 12.6l-.1.1-.6.7-5.1 6.2a1 1 0 0 1-1.6 0L6 15.3l-.3-.4-.2-.2v-.2A8 8 0 0 1 11.8 2Zm3 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" clip-rule="evenodd"/>
                    </svg>
                  </div>
                  <div class="flex flex-col ml-3 min-w-0">
                    <div class="font-medium leading-none text-gray-900">Direcció</div>
                    <p v-if="record.via" class="text-sm text-gray-500 leading-none mt-1 truncate">{{ record.via }}</p>
                    <p v-else class="text-sm text-gray-500 leading-none mt-1 truncate">No disponible</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex flex-col p-4 bg-white hover:text-green-500 text-gray-400 hover:shodow-lg rounded-xl transition ease-in duration-500  transform hover:scale-105 cursor-pointer">
              <div class="flex items-center justify-between">
                <div class="flex items-center mr-auto">
                  <div class="-space-x-5 flex ">
                    <svg class="w-10 h-10 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 14v4.8a1.2 1.2 0 0 1-1.2 1.2H5.2A1.2 1.2 0 0 1 4 18.8V7.2A1.2 1.2 0 0 1 5.2 6h4.6m4.4-2H20v5.8m-7.9 2L20 4.2"/>
                    </svg>
                  </div>
                  <div class="flex flex-col ml-3 min-w-0">
                    <div  class="font-medium leading-none text-gray-900">Pàgina web</div>
                    <p v-if="info.hasOwnProperty('web')"  class="text-sm text-gray-500 leading-none mt-1 truncate">{{info.web.url}}</p>
                    <p v-else  class="text-sm text-gray-500 leading-none mt-1 truncate">No disponible</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="flex flex-col justify-center items-center p-4 bg-white rounded-xl">
            <form class="p-4 md:p-5 w-full" @submit.prevent="submit">
              <div class="relative flex flex-col rounded-xl bg-transparent bg-clip-border text-gray-700 shadow-none">
                <div class="relative mx-0 flex items-center gap-4 overflow-hidden rounded-xl bg-transparent bg-clip-border pt-0 pb-8 text-gray-700 shadow-none">  
                  <div class="flex w-full flex-col gap-0.5">
                    <div class="flex items-center justify-between">
                      <h5 class="block font-sans text-xl font-semibold leading-snug tracking-normal text-blue-gray-900 antialiased">Afegir comentari</h5>
                    </div>
                  </div>
                </div>
                <div class="mb-6 p-0">
                  <textarea v-model="form.content" id="message" rows="4" class="block mb-4 p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escriu un comentari..."></textarea>
                  <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Valoració</label>
                  <select v-model="form.assessment" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="1">1 estrella</option>
                    <option value="2">2 estrelles</option>
                    <option value="3">3 estrelles</option>
                    <option value="4">4 estrelles</option>
                    <option value="5">5 estrelles</option>
                  </select>
                  <input v-model="form.id_user" type="hidden" id="cultural_space_id" class="w-full px-0 text-sm text-gray-900 bg-gray-300 border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400 rounded-md" required>
                  <button class="flex items-center justify-center w-full px-4 py-2 mt-4 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Enviar comentari</button>
                </div>
              </div>
            </form>
          </div>

          <div v-if="comments.length > 0" class="flex flex-col justify-center p-4 bg-white rounded-xl">
            <Carousel :value="products" :numVisible="1" :numScroll="1" orientation="vertical" verticalViewPortHeight="330px" contentClass="flex align-items-center">
              <template #item="slotProps" >
                <div class="border-1 surface-border border-round m-2  p-3">
                  <figure class="flex flex-col items-center justify-center p-8 text-center bg-white rounded-md  dark:bg-gray-800 border-2 border-gray-300" style="margin: 10px;">
                    <blockquote class="max-w-2xl mx-auto mb-4 text-gray-500 lg:mb-8 dark:text-gray-400">
                      <div class="flex justify-center" >
                        <svg v-for="iteration in slotProps.data.assessment" :key="iteration" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-300 mr-1" viewBox="0 0 20 20" fill="currentColor">
                          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                      </div>
                      <p class="my-4">"{{ slotProps.data.content }}"</p>
                    </blockquote>
                    <figcaption class="flex items-center justify-center ">
                      <div class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-800 flex-shrink-0 text-white">A</div>
                        <div class="space-y-0.5 font-medium dark:text-white text-left rtl:text-right ms-3">
                        <h2 class="mr-auto   text-base text-gray-800 font-medium truncate">{{ slotProps.data.name }}</h2>      
                      </div>
                    </figcaption>    
                  </figure>
                </div>
              </template>
            </Carousel>
          </div>

          <div v-else class="flex flex-col justify-center items-center p-4 bg-white rounded-xl">
            <p class="text-center text-gray-900 text-3x1">Aquest centre cultural encara no té cap comentari</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  </Background>

</template>