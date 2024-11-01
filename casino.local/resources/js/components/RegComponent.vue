<template>
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Registration</h2>

        <div v-if="link" class="bg-green-100 text-green-700 p-4 rounded mb-4">
            You are successfully registered! Please click <router-link :to="'/dashboard/'+link">here</router-link> to start gambling
        </div>

            <!-- Username Field -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input v-model="user_name" type="text" name="username" id="username" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('username') }}">
                <p v-if="errors.user_name.length > 0" class="text-red-500 text-sm mt-1">{{ errors.user_name[0] }}</p>
            </div>

            <!-- phone_number Field -->
            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700">phone_number</label>
                <input v-model="phone_number" type="text" name="phone_number" id="phone_number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('phone_number') }}">
                <p v-if="errors.phone_number.length > 0" class="text-red-500 text-sm mt-1">{{ errors.phone_number[0] }}</p>

            </div>

            <!-- Register Button -->
            <div>
                <button @click="reg" class="w-full py-2 px-4 font-semibold rounded-md shadow bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Register</button>
            </div>
    </div>
</template>

<script setup lang="ts">

import {ref} from 'vue';
import axios from "axios";

const reg = async () => {
    try {
        const response = await axios.post('http://casino.local/api/register', {
            user_name: user_name.value,
            phone_number: phone_number.value
        });
        link.value = response.data.hash;
        console.log('User added:', response.data);
    } catch (error) {
        if(error.status === 422)
        {
            errors.value = error.response.data.errors;
        }
    }
}
const errors = ref({user_name: [], phone_number:[]});
const phone_number = ref(null);
const link = ref(null);
const user_name = ref(null);

</script>
