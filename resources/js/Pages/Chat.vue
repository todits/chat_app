<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref } from 'vue';


const users = ref([])
const selectedUser = ref({})
const messages = ref([])
const message = ref('')

const getMessages = () => {
    axios.get(`/api/messages/${selectedUser.value.id}`)
        .then(response => {
            messages.value = response.data
        })
}

const handleClickMessageMe = (user) => {
    selectedUser.value = user
    getMessages()
}

const handleClickSend = () => {
    axios.post(`/api/messages/${selectedUser.value.id}`, {
        message: message.value
    })
        .then(response => {
            getMessages()
            message.value = ''
        })
}

onMounted(() => {
    axios.get(`/api/users`)
        .then(response => {
            users.value = response.data
        })
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Chat</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex content-between"
                    style="justify-content: center;">

                    <div class="list">
                        <ul>
                            <li v-for="user in users" :key="user.id" class="users">
                                <div>
                                    {{ user.id }} - {{ user.name }}
                                </div>
                                <button @click="handleClickMessageMe(user)" class="message_me">Message
                                    Me</button>

                            </li>
                        </ul>
                    </div>

                    <div class="messages">
                        <div>
                            <div>
                                <div class="name">{{ selectedUser.name }}</div>
                                <template v-for="message in messages" :key="message.id">
                                    <span>
                                        {{ message.from.name }}
                                        <!-- {{ message.from.name }} -->
                                    </span>
                                    <div class="message">

                                        {{ message.message }}
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div>
                            <div>
                                <textarea name="" id="" cols="30" rows="10" v-model="message"
                                    :placeholder="`Message ${selectedUser?.name ?? ''}`"
                                    style=" height: 71px; border-radius: 8px;border: none;"></textarea>
                            </div>
                            <div>
                                <button @click="handleClickSend" class="send">Send</button>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style scoped>
.list {
    background: #dae2ff;
    margin: 5px;
    padding: 16px;
    border-radius: 12px;
    height: 70vh;
    margin-right: 20px;
}

.message_me {
    background: white;
    border-radius: 5px;
    padding: 2px 10px;
    font-weight: 600;
    font-family: system-ui;
}

.users {
    margin-bottom: 5px;
    display: flex;
    gap: 10px;
    justify-content: space-between;
}

.messages {
    background: #dae2ff;
    margin: 5px;
    padding: 16px;
    border-radius: 12px;
    height: 70vh;
    margin-right: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;

}

.send {
    background: white;
    padding: 2px 19px;
    border-radius: 20px;
    border-bottom: solid;
    color: #091672;
    font-weight: 800;
}

.message {
    background: white;
    padding: 5px 10px;
    border-radius: 5px;
    margin-bottom: 10px;
}

.name {
    background: white;
    margin-bottom: 10px;
    padding: 2px 10px;
    width: fit-content;
    border-radius: 5px;
    font-weight: 900;
}
</style>
