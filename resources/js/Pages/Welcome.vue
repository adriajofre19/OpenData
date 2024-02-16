<script setup>
import { Head } from '@inertiajs/vue3';
import Background from '@/Components/Background.vue';
import { onMounted } from 'vue';
import { initFlowbite } from 'flowbite';
import Contract from '@/Components/Contract.vue';
import Presentation from '@/Components/Presentation.vue';
import Navbar from '@/Components/Navbar.vue';
import Card from '@/Components/Card.vue';

const props = defineProps(['contracts', 'categoryCenters']);

onMounted(() => {
    initFlowbite();
    console.log(props.categoryCenters)
});
</script>

<template>

  <Head title="Home" />

  <Navbar />

    <Background>
      <div class="bg-white pb-2 w-full flex items-center justify-center">
        <section class="relative w-full bg-cover bg-center py-32 justify-center items-center" style="background-image: url('/images/home/Banner.jpg');">
          <div class="absolute inset-0 bg-gray-900 opacity-50"></div>
          <div class="container text-center text-white flex flex-col justify-center items-center relative">
            <div class="bg-white p-6 rounded-xl flex justify-center items-center">
              <h4 class="text-2xl font-extrabold text-gray-900 dark:text-white md:text-3xl lg:text-3xl whitespace-nowrap">Benvingut a <span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">CulturaPlus</span></h4>
            </div>
          </div>
        </section>
      </div>
      <div class="w-full p-16 pt-4">
        <div class="container relative flex flex-col justify-between h-full max-w-6xl px-10 mx-auto xl:px-0 mt-5 mb-5">
          <div class="flex flex-col items-center mt-4 text-white">    
            <h1 class="text-center mb-4 text-4xl font-extrabold leading-none tracking-tight text-white md:text-5xl lg:text-6xl dark:text-white">Descobriu Catalunya d'una manera única</h1>
            <p class="text-center mb-6 text-lg font-normal text-white lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">Explorant centres culturals i participant en activitats emocionants. A CulturaPlus, us oferim una experiència excepcional.</p>
          </div>
        </div>
        <Presentation/>
        <div v-if="$page.props.auth.user" class="container relative flex flex-col justify-between h-full max-w-6xl px-10 mx-auto xl:px-0 mt-5">
          <div class="flex flex-col items-center mt-5 mb-5 text-white">
              <h1 class="text-center mb-4 text-4xl font-extrabold leading-none tracking-tight text-white md:text-5xl lg:text-6xl dark:text-white">Activitats i Centres Culturals de Catalunya</h1>
              <p class="text-center text-lg font-normal text-white lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">Tot el que necessiteu, res que no necessiteu. Trieu les activitats i centres culturals que millor s'adaptin a les vostres preferències.</p>    
          </div>
          <div class="flex flex-wrap justify-center">
              <Card v-for="category in categoryCenters" :key="category.id" :id="category.id" :name="category.name" :image="category.image" :description="category.description"/>
          </div>
        </div>

        <div v-else class="container relative flex flex-col justify-between h-full max-w-6xl px-10 mx-auto xl:px-0 mt-5">
          <div class="flex flex-col items-center mt-4 text-white">    
            <h1 class="text-center mb-4 text-4xl font-extrabold leading-none tracking-tight text-white md:text-5xl lg:text-6xl dark:text-white">Preus senzills, sense compromís.</h1>
            <p class="text-center text-lg font-normal text-white lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">Tot el que necessites, res que no necessitis. Trieu el pla que millor s'adapti a les vostres necessitats.</p>
            <Contract v-for="contract in contracts" :key="contract.id" :name="contract.name" :description="contract.description" :price="contract.price" :type="contract.type" :contract_description="contract.contract_description" :id="contract.id"/>
          </div>
        </div>
      </div>
      </Background>

</template>