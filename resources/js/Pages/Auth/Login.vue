<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Background from '@/Components/Background.vue';
import Navbar from '@/Components/Navbar.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>

    <Head title="Log in" />

    <Navbar />

    <Background>
        <div class="p-16">
            <div class="bg-white p-8 rounded-lg">
                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">{{ status }}</div>
                <div class="flex justify-center">
                    <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
                </div>
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="email" value="Correu electrònic" />
                        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="password" value="Contrasenya" />
                        <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>
                    <div class="block mt-4">
                        <label class="flex items-center">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span class="ms-2 text-sm text-gray-600">Recorda'm</span>
                        </label>
                    </div>
                    <div class="mt-4">
                        <a :href="route('login.github')">
                            <SecondaryButton class="mt-2 bg-blue-500 hover:bg-blue-700 text-white" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Login with Github
                            </SecondaryButton>
                        </a>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Has oblidat la teva contrasenya?
                        </Link>
                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Iniciar sessió
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </Background>

</template>