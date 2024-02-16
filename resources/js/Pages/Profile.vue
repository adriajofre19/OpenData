<script setup>
import { Head } from '@inertiajs/vue3';
import Background from '@/Components/Background.vue';
import { ref } from 'vue';
import Edit from '@/Pages/Profile/Edit.vue'
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import PlanView from '@/Pages/Profile/PlanView.vue'
import Plan from '@/Pages/Profile/Plan.vue'
import Api from './Profile/Api.vue';
import TownsCulturalSpaces from './Profile/TownsCulturalSpaces.vue';
import Navbar from '@/Components/Navbar.vue';
import Tickets from './Tickets.vue';
import axios from 'axios';

const props = defineProps(['userId', 'plans', 'activities', 'categories', 'users', 'notifications', 'sharedPlans', 'user_town', 'user_cultural_space']);
let activeSection = ref('edit');
let planModal = ref(true);
const notifications = ref(props.notifications);

function setActiveSection(section) {
    activeSection.value = section;
}

function handleNotificationClick(planId) {
    planModal.value = true
    console.log(planId);
    axios.post('/profile/accept-notification/' + planId);
    closeModal();
}

function handleDeleteNotificationClick(planId) {
    console.log(planId);
    axios.post('/profile/delete-notification/' + planId);
}

function closeModal() {
    planModal.value = false;
}

onMounted(() => {
    initFlowbite();
    console.log(props.user_town);
});
</script>

<template>
    <Head title="Profile" />

    <Navbar />
    
        <Background>
            <div class="container flex flex-col items-center justify-center">

                <div v-if="notifications.length > 0" class="pt-8">
                    <div v-for="notification in notifications" :key="notification.id" id="alert-additional-content-3" class="p-6 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Has rebut una nova notificacio</span>
                            <h3 class="text-lg font-medium">Has rebut una invitació</h3>
                        </div>
                        <div class="mt-2 mb-2 text-sm">
                            Títol: {{ notification.plan.title }}
                        </div>
                        <div class="mt-2 mb-2 text-sm">
                            Descripció: {{ notification.plan.description }}
                        </div>
                        <div class="mt-2 mb-2 text-sm">
                            Durada: {{ notification.plan.start_date }} - {{ notification.plan.end_date }}
                        </div>
                        <div class="flex">
                            <button type="button" @click="handleNotificationClick(notification.id_plan)" class="text-white bg-green-800 hover:bg-green-900 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" aria-label="Close">
                                Acceptar
                            </button>
                            <button type="button" @click="handleDeleteNotificationClick(notification.id_plan)" class="text-green-800 bg-transparent border border-green-800 hover:bg-green-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-green-600 dark:border-green-600 dark:text-green-400 dark:hover:text-white dark:focus:ring-green-800" data-dismiss-target="#alert-additional-content-3" aria-label="Close">
                                Cancel·lar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-16 pb-4 pt-4 w-full">
                    <div class="flex flex-col justify-center items-center h-full">
                        <div class="relative flex flex-col items-center rounded-[20px] w-full mx-auto p-2 bg-white bg-clip-border shadow-3xl shadow-shadow-500 dark:!bg-navy-800 dark:text-white dark:!shadow-none">
                            <div class="relative flex h-32 w-full justify-center rounded-xl bg-cover">
                                <img src='/images/bannerProfile.png' alt="banner" class="absolute flex h-32 w-full justify-center rounded-xl bg-cover">
                                <div class="absolute -bottom-12 flex h-[87px] w-[87px] items-center justify-center rounded-full border-[4px] border-white bg-pink-400 dark:!border-navy-700">
                                    <img class="h-full w-full rounded-full" src="/images/Profile.jpg" alt="user" />
                                </div>
                            </div>
                            <div class="mt-16 flex flex-col items-center">
                                <h4 class="text-xl font-bold text-navy-700 dark:text-white">
                                    {{ $page.props.auth.user.name }}
                                </h4>
                                <p class="text-base font-normal text-gray-600">{{ $page.props.auth.user.email }}</p>
                            </div>
                            <div class="mt-6 mb-3 flex gap-14 md:!gap-14">
                                <div class="flex flex-col items-center justify-center">
                                    <p class="text-2xl font-bold text-navy-700 dark:text-white">17</p>
                                    <p class="text-sm font-normal text-gray-600">Posts</p>
                                </div>
                                <div class="flex flex-col items-center justify-center">
                                    <p class="text-2xl font-bold text-navy-700 dark:text-white">
                                        9.7K
                                    </p>
                                    <p class="text-sm font-normal text-gray-600">Followers</p>
                                </div>
                                <div class="flex flex-col items-center justify-center">
                                    <p class="text-2xl font-bold text-navy-700 dark:text-white">
                                        434
                                    </p>
                                    <p class="text-sm font-normal text-gray-600">Following</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-16 pt-0 pb-4 w-full">
                    <div class="sm:hidden"> 
                        <select id="tabs" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" @change.prevent="setActiveSection($event.target.value)">
                            <option value="edit">Editar</option>
                            <option value="plan">Plans</option>
                            <option value="sheared_plan">Compartits</option>
                            <option value="favourite">Favorits</option>
                            <option value="chat">Xat</option>
                            <option v-if="$page.props.auth.user.id_role === 2 || $page.props.auth.user.id_role === 3" value="api">API</option>
                        </select>
                    </div>
                    <ul class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow sm:flex dark:divide-gray-700 dark:text-gray-400">
                        <li class="w-full">
                            <a href="#" @click.prevent="setActiveSection('edit')" class="inline-block w-full p-4 text-gray-900 bg-gray-100 border-r border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 active focus:outline-none dark:bg-gray-700 dark:text-white" aria-current="page">Editar</a>
                        </li>
                        <li class="w-full">
                            <a href="#" @click.prevent="setActiveSection('plan')" class="inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">Plans</a>
                        </li>
                        <li class="w-full">
                            <a href="#" @click.prevent="setActiveSection('sheared_plan')" class="inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">Compartits</a>
                        </li>
                        <li class="w-full">
                            <a href="#" @click.prevent="setActiveSection('favourite')" class="inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">Favorits</a>
                        </li>
                        <li class="w-full">
                            <a href="#" @click.prevent="setActiveSection('chat')" class="inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">Xat</a>
                        </li>
                        <li v-if="$page.props.auth.user.id_role === 2 || $page.props.auth.user.id_role === 3" class="w-full">
                            <a href="#" @click.prevent="setActiveSection('api')" class="inline-block w-full p-4 bg-white border-s-0 border-gray-200 dark:border-gray-700 rounded-e-lg hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">API</a>
                        </li>
                    </ul>
                </div>

                <section v-if="activeSection === 'edit'" class="p-16 pt-0 w-full">
                    <Edit />
                </section>

                <section v-if="activeSection === 'plan'" class="p-16 pt-0 w-full">
                    <PlanView :plans="plans" :categories="categories">
                        <Plan v-for="plan in plans" :key="plan.id" :plans="plan" :categories="categories" :users="users" :showButtons="true"/>
                    </PlanView>
                </section>

                <section v-if="activeSection === 'sheared_plan'" class="p-16 pt-0 w-full">
                    <Plan v-for="plan in sharedPlans" :key="plan.id" :plans="plan" :users="users" :showButtons="false"/>
                </section>

                <section v-if="activeSection === 'favourite'" class="p-16 pt-0 w-full">
                    <TownsCulturalSpaces :town="user_town" :space="user_cultural_space"/>
                </section>
            
                <section v-if="activeSection === 'api'" class="p-16 pt-0 w-full">
                    <Api />
                </section>

                <section v-if="activeSection === 'chat'" class="p-16 pt-0 w-full">
                    <Tickets />
                </section>
            </div>
        </Background>
</template>