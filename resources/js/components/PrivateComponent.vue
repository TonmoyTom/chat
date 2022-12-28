<template>
<div class="chat-app">
    <conversation :contact="selectedContact" :messages="messages"  @new="saveNewMessage"></conversation>
    <contact-list :contacts="contacts" @selected="startConversationWith" ></contact-list>
</div>
</template>

<script>
export default {
    props : {
        user: {
            type: Object,
            required: true
        }
    },
   data(){
       return {
           selectedContact : null,
           contacts : [],
           messages : []
       }
   },
    created() {
        console.log(this.selectedContact);
        let id = this.user.id;
        Echo.join('private.'+id)
            .listen('DataSend',(e)=> {
                console.log(e);
              this.handleIncoming(e.message);
            })
        this.fetchUser();

    },
    methods: {
        fetchUser(){
            axios.get('/contact').then(response => {
                this.contacts = response.data;
                this.startConversationWith(response.data[0]);
            });
        },
        startConversationWith(contact) {
            this.updateUnreadCount(contact, true);
            axios.get(`/conversation/${contact.id}`)
                .then((response) => {
                    this.messages = response.data;
                    this.selectedContact = response.data[0];
            })

        },
        saveNewMessage(message) {
            this.messages.push(message);
        },
        handleIncoming(message) {
            if (this.selectedContact && message.from == this.selectedContact.id) {
                this.saveNewMessage(message);
                return;
            }
            this.updateUnreadCount(message.from_contact, false);
        },
        updateUnreadCount(contact, reset) {
            this.contacts = this.contacts.map((single) => {
                if (single.id !== contact.id) {
                    return single;
                }
                if (reset)
                    single.unread = 0;
                else
                    single.unread += 1;
                return single;
            })
        }

    },
}
</script>

<style scoped>
.chat-app {
    display: flex;
}
</style>
