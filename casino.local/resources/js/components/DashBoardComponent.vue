<template>
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <div v-if="msg.remove" class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{msg.remove}}
        </div>
        <div v-if="link && msg.reset" class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{msg.reset}} <br>
            New link <router-link :to="'/dashboard/'+link">http://casino.local/dashboard/{{link}}</router-link>
        </div>
        <div v-if="msg.gambling.length > 0" class="bg-blue-100 text-green-700 p-4 rounded mb-4 absolute top-0 left-0">
            <span class="pb-3 block" v-for="m in msg.gambling">{{m}}</span>
        </div>
        <div v-if="history_gambling.length > 0" class="bg-purple-100 text-white p-4 rounded mb-4 absolute top-0 right-0">
            <span class="pb-3 block" v-for="h in history_gambling">{{h.msg}} at {{h.created_at}}</span>
        </div>
            <button class="w-full py-2 px-4 font-semibold rounded-md shadow bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    @click="gamble" >Imfeelinglucky</button>
            <button class="w-full py-2 px-4 font-semibold rounded-md shadow bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                @click="removeHash" >Deactivate link</button>
            <button class="w-full py-2 px-4 font-semibold rounded-md shadow bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    @click="resetHash">Reset link</button>
            <span @click="history">Load history</span>
        </div>
</template>

<script setup>

import {ref, defineProps, onMounted} from 'vue';
import axios from "axios";


const resetHash = async () => {

    try {
        const response = await axios.patch('http://casino.local/api/dashboard/'+props.hash+'/reset-link', {});
        link.value = response.data.hash;
        msg.value.reset = response.data.msg;
    } catch (error) {
        console.error('Error:', error);
    }

}

const removeHash = async () => {
    try {
        const response = await axios.patch('http://casino.local/api/dashboard/'+props.hash+'/remove-link', {});
        msg.value.remove = response.data.msg;
    } catch (error) {
        console.error('Error:', error);
    }
}

const history = async () => {
    try {
        const response = await axios.get('http://casino.local/api/dashboard/'+props.hash+'/history');
        history_gambling.value = response.data.data;
        console.log(response)
    } catch (error) {
        console.error('Error:', error);
    }
}

const gamble = async () => {
    try {
        await axios.post('http://casino.local/api/dashboard/'+props.hash+'/gamble', {});
    } catch (error) {
        console.error('Error:', error);
    }
}
const history_gambling = ref([]);
const link = ref(null);
const msg = ref({remove:null, reset:null, gambling:[]});
const props = defineProps(['hash']);
onMounted(() => {

    window.Echo.channel('gambling')
        .listen('GamblingProcessedEvent', (e) => {
            console.log('New message received:', e.msg);
            msg.value.gambling.push(e.msg);
        });

});

</script>
