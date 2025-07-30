<template>
    <div>
        <div v-for="msg in messages" :key="msg.id">
            <b>{{ msg.user.name }}:</b> {{ msg.message }}
        </div>
        <input v-model="text" @keyup.enter="send" placeholder="Введите сообщение">
    </div>
</template>
<script>
export default {
    data() {
        return {
            messages: [],
            text: ''
        }
    },
    mounted() {
        axios.get('/chat').then(res => {
            this.messages = res.data.messages;
        });

        window.Echo.channel('chat')
            .listen('.message.sent', (e) => {
                this.messages.push(e.message);
            });
    },
    methods: {
        send() {
            axios.post('/chat/send', { message: this.text });
            this.text = '';
        }
    }
}
</script>
