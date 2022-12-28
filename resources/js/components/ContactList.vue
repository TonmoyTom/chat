<template>
    <div class="contacts-list">
        <ul>
            <li v-for="(contact , index) in sortedContacts" :key="contact.id"
                @click="selectContact(contact)">
                <div class="contact">
                    <p class="name">{{ contact.name }}</p>
                    <p class="email">{{ contact.email }}</p>

                </div>
                <span class="unread" v-if="contact.unread" >{{ contact.unread }}</span>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        contacts: {
            type: Array,
            default: []
        }
    },
    data() {
        return {
            selected: this.contacts.length ? this.contacts[0] : null
        };
    },
    methods: {
        selectContact(contact ,index) {
            // this.selected = contact;
            this.$emit('selected', contact);
        }
    },
    computed: {
        sortedContacts() {
            return _.sortBy(this.contacts, [(contact) => {
                if (contact == this.selected) {
                    return Infinity;
                }
            }]).reverse();
        }
    }
}
</script>

<style scoped>
.contacts-list {
    flex: 2;
    max-height: 100%;
    height: 600px;
    overflow: scroll;
    border-left: 1px solid #a6a6a6;
}
.contacts-list ul {
    list-style-type: none;
    padding-left: 0;
}
.contacts-list ul li {
    display: flex;
    padding: 2px;
    border-bottom: 1px solid #aaaaaa;
    height: 80px;
    position: relative;
    cursor: pointer;
}
.contacts-list ul li.selected {
    background: #dfdfdf;
}
.contacts-list ul li span.unread {
    background: #82e0a8;
    color: #fff;
    position: absolute;
    right: 11px;
    top: 20px;
    display: flex;
    font-weight: 700;
    min-width: 20px;
    justify-content: center;
    align-items: center;
    line-height: 20px;
    font-size: 12px;
    padding: 0 4px;
    border-radius: 3px;
}
.contacts-list ul li .avatar {
    flex: 1;
    display: flex;
    align-items: center;
}
.contacts-list ul li .avatar img {
    width: 35px;
    border-radius: 50%;
    margin: 0 auto;
}
.contacts-list ul li .contact {
    flex: 3;
    font-size: 10px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin-left: 20px;
}
.contacts-list ul li .contact p {
    margin: 0;
}
.contacts-list ul li .contact p.name {
    font-weight: bold;
}
</style>
