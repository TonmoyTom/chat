<template>
    <div class="conversation">
        <h1>{{ 'Select a Contact' }}</h1>
        <messages-feed :contact="contact" :messages="messages"></messages-feed>
        <messages-composer @send="sendMessage"></messages-composer>
    </div>

</template>

<script>

export default {
    props: {
        contact: {
            type: Object,
            default: null
        },
        messages: {
            type: Array,
            default: []
        }
    },

    methods: {
        sendMessage(message) {
            if (!this.contact) {
                return;
            }
            axios.post('/conversation/send', {
                contact_id: this.contact.id,
                message: message
            }).then((response) => {
                this.$emit('new', response.data);
            })
        }
    },


}
</script>

<style scoped>
.conversation {
    flex: 5;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
h1 {
    font-size: 20px;
    padding: 10px;
    margin: 0;
    border-bottom: 1px dashed lightgray;
}
}
</style>
