<script setup>
import { useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import axios from 'axios';
import { ref } from 'vue';

onMounted(() => {
    initFlowbite();
    getSesionUser();
    fetchUsers();
})

const messages = ref([]);
const id = ref(0);

function getSesionUser(){
    axios.get('/getsessionuser').then(response => {
        form.user_from = response.data.id;
        id.value = response.data.id;
    });
}


function fetchMessages(id){
    axios.get('/messages/' +id).then(response => {
        messages.value = response.data;
        
    });
}

const form = useForm({
    message: '',
    user_from: '',
    user_to: '',

});

const submit = () => {
    form.post('/addmessage', form);
    form.message = '';
    fetchMessages(form.user_from);
    setStateOne(form.user_to);
    fetchUsers();
    
}

const users = ref([]);

function fetchUsers(){
    axios.get('/usersandmessagesfromadmin').then(response => {
        users.value = response.data;
        console.log(users.value);
    });
}

function getUser(id){
    console.log(id);
    form.user_to = id;
    fetchMessages(form.user_from);
}

function setStateOne(id){
    axios.get('/setstateone/' +id);
}
</script>

<template>

  <div class="p-6 bg-white rounded-xl">
    <div class="relative overflow-x-auto">
      <div class="flex flex-col-reverse sm:flex-row items-align flex-nowrap justify-content">
        <div class="flex flex-col flex-auto h-full p-6 h-screen sm:order-last">
          <div class="flex flex-col flex-auto flex-shrink-0 rounded-2xl bg-gray-100 h-full p-4">
            <div class="flex flex-col h-full overflow-x-auto mb-4">
              <div class="flex flex-col h-full">
                <div v-for="message in messages" :key="message.id" class="grid grid-cols-12 gap-y-2">
                  <div v-if="message.user_from !== 3" class="col-start-1 col-end-8 p-3 rounded-lg">
                    <div class="flex flex-row items-center">
                      <div class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-800 flex-shrink-0 text-white">A</div>
                      <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl"><div>{{ message.message }}</div>
                      </div>
                    </div>
                  </div>
                  <div v-else class="col-start-6 col-end-13 p-3 rounded-lg">
                    <div class="flex items-center justify-start flex-row-reverse">
                      <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">A</div>
                      <div class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">
                        <div> {{ message.message }}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex flex-row items-center h-16 rounded-xl bg-white w-full px-4">
              <form @submit.prevent="submit" class="w-full flex flex-row align-center">
                <div class="flex-grow">
                  <div class="relative w-full">
                    <input v-model="form.message" type="text" class="flex w-full border rounded-xl focus:outline-none focus:border-indigo-300 pl-4 h-10"/>
                  </div>
                </div>
                <div class="ml-4">
                  <button type="submit" class="flex items-center justify-center bg-gray-800 rounded-xl text-white px-4 py-1 flex-shrink-0" style="padding-bottom: 8px; padding-top: 8px;">
                    <span>Enviar</span>
                    <span class="ml-2">
                      <svg class="w-4 h-4 transform rotate-45 -mt-px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" ></path>
                      </svg>
                    </span>
                  </button>
                </div>
                <input v-model="form.user_from" type="text" class="hidden flex w-full border rounded-xl focus:outline-none focus:border-indigo-300 pl-4 h-10"/>
                <input v-model="form.user_to" type="text" class="hidden flex w-full border rounded-xl focus:outline-none focus:border-indigo-300 pl-4 h-10"/>
              </form>
            </div>
          </div>
        </div>
        <div class="flex flex-col flex-shrink-0 w-full sm:w-60 sm:order-first">
          <div class="flex flex-col p-4">
            <div class="flex flex-row items-center justify-center w-full mb-4 p-4">
              <div class="flex items-center justify-center rounded-2xl text-indigo-700 bg-indigo-100 h-10 w-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
              </div>
              <div class="ml-2 font-bold text-2xl">Xat</div>
            </div>
            <div class="flex flex-col mt-8">
              <div class="flex flex-col space-y-1 mt-4 -mx-2 overflow-y-auto">
                <button @click="getUser(user.id)" v-for="user in users" :key="user.id" class="flex flex-row items-center hover:bg-gray-100 rounded-xl p-2 justify-between">
                  <div class="flex flex-row flex-nowrap justify-center flex-center" style="align-items: center;">
                    <div class="flex items-center justify-center h-8 w-8 bg-gray-800 rounded-full text-white">A</div>
                    <div class="ml-2 text-sm font-semibold">{{ user.name }}</div>
                  </div>
                  <span v-if="user.has_messages === 1" style="font-size: 1px;" class="flex items-center justify-center bg-red-300 h-4 w-4 rounded-full">!</span> 
                </button> 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>