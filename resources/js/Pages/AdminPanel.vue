<script setup>
import { Head } from '@inertiajs/vue3';
import { defineProps, onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import { initModals } from 'flowbite';
import { ref } from 'vue';
import AdminPanelUsers from '@/Components/AdminPanelUsers.vue';
import Users from '@/Components/Users.vue';
import AdminPanelActivities from '@/Components/AdminPanelActivities.vue';
import Activities from '@/Components/Activities.vue';
import AdminPanelPlans from '@/Components/AdminPanelPlans.vue';
import Plans from '@/Components/Plans.vue';
import AdminPanelCategories from '@/Components/AdminPanelCategories.vue';
import Categories from '@/Components/Categories.vue';
import AdminPanelContracts from '@/Components/AdminPanelContracts.vue';
import Contracts from '@/Components/Contracts.vue';
import AdminPanelTickets from '@/Components/AdminPanelTickets.vue';
import NavbarAdmin from '@/Components/NavbarAdmin.vue'
import Stats from './Stats.vue';

const props = defineProps(['user', 'activity', 'roles', 'contracts', 'plans', 'categories', 'contracts','result1','result2']);

let activeSection = ref('users');

function setActiveSection(section) {
   activeSection.value = section;
}

function toggleUsers() {
   setActiveSection('users');
}

function togglePlans() {
   setActiveSection('plans');
}

function toggleActivitats() {
   setActiveSection('activitats');
}

function toggleCategories() {
   setActiveSection('categories');
}

function toggleTickets() {
   setActiveSection('tickets');
}

function toggleContracts() {
   setActiveSection('contracts');
}

function toggleGraphs() {
   setActiveSection('graphs');
}

onMounted(() => {
    initFlowbite();
    initModals();
});
</script>

<template>

   <Head title="AdminPanel" />

   <NavbarAdmin />

   <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 h-screen pt-20 transition-transform -translate-x-full bg-gray-900 border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
      <div class="h-full px-3 pb-4 overflow-y-auto bg-gray-900 dark:bg-gray-800">
         <ul class="space-y-2 font-medium">
            <li>
               <a href="#" @click="toggleUsers" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <svg class="w-5 h-5 group-hover:text-gray-900 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                     <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                  </svg>
                  <span class="ms-3 group-hover:text-gray-900">Usuaris</span>
               </a>
            </li>
            <li>
               <a href="#" @click="toggleActivitats" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <svg class="flex-shrink-0 w-5 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                     <path fill-rule="evenodd" d="M5 5c.6 0 1-.4 1-1a1 1 0 1 1 2 0c0 .6.4 1 1 1h1c.6 0 1-.4 1-1a1 1 0 1 1 2 0c0 .6.4 1 1 1h1c.6 0 1-.4 1-1a1 1 0 1 1 2 0c0 .6.4 1 1 1a2 2 0 0 1 2 2v1c0 .6-.4 1-1 1H4a1 1 0 0 1-1-1V7c0-1.1.9-2 2-2ZM3 19v-7c0-.6.4-1 1-1h16c.6 0 1 .4 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6-6c0-.6-.4-1-1-1a1 1 0 1 0 0 2c.6 0 1-.4 1-1Zm2 0a1 1 0 1 1 2 0c0 .6-.4 1-1 1a1 1 0 0 1-1-1Zm6 0c0-.6-.4-1-1-1a1 1 0 1 0 0 2c.6 0 1-.4 1-1ZM7 17a1 1 0 1 1 2 0c0 .6-.4 1-1 1a1 1 0 0 1-1-1Zm6 0c0-.6-.4-1-1-1a1 1 0 1 0 0 2c.6 0 1-.4 1-1Zm2 0a1 1 0 1 1 2 0c0 .6-.4 1-1 1a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                  </svg>
                  <span class="flex-1 ms-3 whitespace-nowrap group-hover:text-gray-900">Activitats</span>
               </a>
            </li>
            <li>
               <a href="#" @click="togglePlans" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <svg class="flex-shrink-0 w-5 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                     <path fill-rule="evenodd" d="M5 5c.6 0 1-.4 1-1a1 1 0 1 1 2 0c0 .6.4 1 1 1h1c.6 0 1-.4 1-1a1 1 0 1 1 2 0c0 .6.4 1 1 1h1c.6 0 1-.4 1-1a1 1 0 1 1 2 0c0 .6.4 1 1 1a2 2 0 0 1 2 2v1c0 .6-.4 1-1 1H4a1 1 0 0 1-1-1V7c0-1.1.9-2 2-2ZM3 19v-7c0-.6.4-1 1-1h16c.6 0 1 .4 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6-6c0-.6-.4-1-1-1a1 1 0 1 0 0 2c.6 0 1-.4 1-1Zm2 0a1 1 0 1 1 2 0c0 .6-.4 1-1 1a1 1 0 0 1-1-1Zm6 0c0-.6-.4-1-1-1a1 1 0 1 0 0 2c.6 0 1-.4 1-1ZM7 17a1 1 0 1 1 2 0c0 .6-.4 1-1 1a1 1 0 0 1-1-1Zm6 0c0-.6-.4-1-1-1a1 1 0 1 0 0 2c.6 0 1-.4 1-1Zm2 0a1 1 0 1 1 2 0c0 .6-.4 1-1 1a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                  </svg>
                  <span class="flex-1 ms-3 whitespace-nowrap group-hover:text-gray-900">Plans</span>
               </a>
            </li>
            <li>
               <a href="#" @click="toggleCategories" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <svg class="flex-shrink-0 w-5 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                     <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                  </svg>
                  <span class="flex-1 ms-3 whitespace-nowrap group-hover:text-gray-900">Categories</span>
               </a>
            </li>
            <li>
               <a href="#" @click="toggleContracts" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <svg class="flex-shrink-0 w-5 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                     <path fill-rule="evenodd" d="M9 2.2V7H4.2l.4-.5 3.9-4 .5-.3Zm2-.2v5a2 2 0 0 1-2 2H4v11c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Z" clip-rule="evenodd"/>
                  </svg>
                  <span class="flex-1 ms-3 whitespace-nowrap group-hover:text-gray-900">Contractes</span>
               </a>
            </li>
            <li>
               <a href="#" @click="toggleTickets" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <svg class="flex-shrink-0 w-5 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                     <path d="M4 5a2 2 0 0 0-2 2v2.5c0 .6.4 1 1 1a1.5 1.5 0 1 1 0 3 1 1 0 0 0-1 1V17a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2.5a1 1 0 0 0-1-1 1.5 1.5 0 1 1 0-3 1 1 0 0 0 1-1V7a2 2 0 0 0-2-2H4Z"/>
                  </svg>
                  <span class="flex-1 ms-3 whitespace-nowrap group-hover:text-gray-900">Tickets</span>
               </a>
            </li>
            <li>
               <a href="#" @click="toggleGraphs" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <svg class="flex-shrink-0 w-5 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                     <path fill-rule="evenodd" d="M9.6 2.6A2 2 0 0 1 11 2h2a2 2 0 0 1 2 2l.5.3a2 2 0 0 1 2.9 0l1.4 1.3a2 2 0 0 1 0 2.9l.1.5h.1a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2l-.3.5a2 2 0 0 1 0 2.9l-1.3 1.4a2 2 0 0 1-2.9 0l-.5.1v.1a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2l-.5-.3a2 2 0 0 1-2.9 0l-1.4-1.3a2 2 0 0 1 0-2.9l-.1-.5H4a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2l.3-.5a2 2 0 0 1 0-2.9l1.3-1.4a2 2 0 0 1 2.9 0l.5-.1V4c0-.5.2-1 .6-1.4ZM8 12a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd"/>
                  </svg>
                  <span class="flex-1 ms-3 whitespace-nowrap group-hover:text-gray-900">Gràfics</span>
               </a>
            </li>
         </ul>
      </div>
   </aside>

   <section v-if="activeSection==='users'">
      <AdminPanelUsers :roles="roles" :contracts="contracts" :user="user">
         <Users v-for="user in user" :key="user.id" :user="user" :roles="roles" :contracts="contracts"/>
      </AdminPanelUsers>   
   </section>

   <section v-if="activeSection==='activitats'">
      <AdminPanelActivities :activity="activity" :plans="plans">
         <Activities v-for="activity in activity" :key="activity.id" :activity="activity" :plans="plans"/>
      </AdminPanelActivities>
   </section>

   <section v-if="activeSection==='plans'">
      <AdminPanelPlans :plans="plans" :user="user" :categories="categories">
         <Plans v-for="plan in plans" :key="plan.id" :plans="plan" :categories="categories"/>
      </AdminPanelPlans>
   </section>

   <section v-if="activeSection==='categories'">
      <AdminPanelCategories :categories="categories">
         <Categories v-for="category in categories" :key="category.id" :categories="category"/>
      </AdminPanelCategories>
   </section>

   <section v-if="activeSection==='contracts'">
      <AdminPanelContracts :contracts="contracts">
         <Contracts v-for="contract in contracts" :key="contract.id" :contracts="contract"/>
      </AdminPanelContracts>
   </section>

   <section v-if="activeSection==='tickets'">
      <AdminPanelTickets />
   </section>

   <section v-if="activeSection==='graphs'">
      <Stats :result1="result1" :result2="result2"/>
   </section>

</template>