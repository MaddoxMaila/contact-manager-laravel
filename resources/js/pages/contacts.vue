<template>
  

    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <button class="btn btn-alert btn-block btn-lg">New Contact</button>
            <div class="list-group" v-if="contacts.length > 0">
                <div class="list-group-item" v-bind:for="(contact, index) in contacts" :key="index">
                    <div class="media">
                        <div class="media-body">
                            <h4>
                                {{contact.name}}
                            </h4>
                            <span>
                                {{contact.numbers}} | {{contact.email}}
                            </span>
                        </div>
                        <div class="media-right">
                            <button class="btn btn-danger btn-sm">Delete</button>
                            <button class="btn btn-primary btn-sm">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4"></div>
    </div>

</template>

<script>
import axios from 'axios'

export default {
    name: "Contacts",
    middleware: 'guest',
    data: () => ({
        contacts: [],
        e : {
            error: false,
            message: ''
        }
    }),
    methods: {

         getAllContacts: async function() {

             axios.get('api/contacts/all').then((resp) => {
                 console.log(resp)
                 if(resp.data.error){
                    this.e.error = resp.data.error
                    this.e.message = resp.data.message
                }else{

                    resp.data.contacts.forEach(contact => {
                        this.contacts.push(contact)
                    });

                }

                console.log(this.contacts)
             })

            // const resp = await axios.get('api/contacts/all')
            // console.log(resp)
            // if(resp.data.error){
            //         this.e.error = resp.data.error
            //         this.e.message = resp.data.message
            //     }else{

            //         this.contacts = resp.data.contacts

            //     }

            //     console.log(this.contacts)

        }

    },
    mounted() {
        this.$nextTick(async () => {
            await this.getAllContacts()
        })
    }

}
</script>

<style scoped>

</style>