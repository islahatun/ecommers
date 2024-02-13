<template>
    <v-container-fluid>
        <v-responsive>
            <v-card :class="ratio" elevation="6" class="mx-5 my-5">
                <v-card-title class="d-flex align-center pe-2">
                    <v-text-field
                        v-model="search"
                        prepend-inner-icon="mdi-magnify"
                        density="compact"
                        label="Search"
                        single-line="single-line"
                        flat="flat"
                        hide-details="hide-details"
                        variant="solo-filled"></v-text-field>

                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" persistent="persistent" width="500">
                        <template v-slot:activator="{ props }">
                            <v-btn
                                rounded="lg"
                                class="mx-1"
                                color="blue-darken-1"
                                elevation="6"
                                v-bind="props">{{$t('text.create')}}
                            </v-btn>
                            <v-btn
                                rounded="lg"
                                class="mx-1"
                                color="green-darken-1"
                                elevation="6"
                                v-bind="props">{{$t('text.edit')}}
                            </v-btn>
                        </template>

                        <v-card>
                            <v-form @submit.prevent="createItem">
                                <v-card-title color="green-darken-2">
                                    <span class="text-h5">{{$t('text.create')}}
                                        User Profile</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container>

                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field
                                                    :label="$t('users.name')"
                                                    :rules="rules.name"
                                                    v-model="models.name"
                                                    required="required"></v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-text-field
                                                    :label="$t('users.email')"
                                                    :rules="rules.email"
                                                    v-model="models.email"
                                                    required="required"></v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-text-field
                                                    :label="$t('users.password')"
                                                    :rules="rules.password"
                                                    v-model="models.password"
                                                    type="password"
                                                    required="required"></v-text-field>
                                            </v-col>
                                        </v-row>

                                    </v-container>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue-darken-1" variant="text" @click="dialog = false">
                                        {{ $t('text.closeDialog') }}
                                    </v-btn>
                                    <v-btn color="blue-darken-1" variant="text" type="submit">
                                        {{ $t('text.save') }}
                                    </v-btn>
                                </v-card-actions>
                            </v-form>
                        </v-card>

                    </v-dialog>

                    <!-- <v-dialog v-model="dialog" persistent="persistent" width="1024"> <template
                    v-slot:activator="{ props }"> <v-btn rounded="lg" class="mx-1"
                    color="green-darken-1" elevation="6" v-bind="props">{{$t('text.edit')}}</v-btn>
                    </template> <v-card> <v-card-title color="green-darken-2"> <span
                    class="text-h5">{{$t('text.edit')}} User Profile</span> </v-card-title>
                    <v-card-text> <v-container> <v-row> <v-col cols="12" sm="6" md="4">
                    <v-text-field label="Legal first name*" required="required"></v-text-field>
                    </v-col> <v-col cols="12" sm="6" md="4"> <v-text-field label="Legal middle name"
                    hint="example of helper text only on focus"></v-text-field> </v-col> <v-col
                    cols="12" sm="6" md="4"> <v-text-field label="Legal last name*" hint="example of
                    persistent helper text" persistent-hint="persistent-hint"
                    required="required"></v-text-field> </v-col> <v-col cols="12"> <v-text-field
                    label="Email*" required="required"></v-text-field> </v-col> <v-col cols="12">
                    <v-text-field label="Password*" type="password"
                    required="required"></v-text-field> </v-col> <v-col cols="12" sm="6"> <v-select
                    :items="['0-17', '18-29', '30-54', '54+']" label="Age*"
                    required="required"></v-select> </v-col> <v-col cols="12" sm="6">
                    <v-autocomplete :items="['Skiing', 'Ice hockey', 'Soccer', 'Basketball',
                    'Hockey', 'Reading', 'Writing', 'Coding', 'Basejump']" label="Interests"
                    multiple="multiple"></v-autocomplete> </v-col> </v-row> </v-container>
                    <small>*indicates required field</small> </v-card-text> <v-card-actions>
                    <v-spacer></v-spacer> <v-btn color="blue-darken-1" variant="text" @click="dialog
                    = false"> Close </v-btn> <v-btn color="blue-darken-1" variant="text"
                    @click="dialog = false"> Save </v-btn> </v-card-actions> </v-card> </v-dialog>
                    -->

                    <v-btn
                        rounded="lg"
                        class="mx-1"
                        elevation="6"
                        color="red-darken-1"
                        @click="deleteItem">Delete</v-btn>

                </v-card-title>

                <v-divider></v-divider>
                <v-card>
                    <v-data-table
                        v-model:search="search"
                        :items="users"
                        item-key="id"
                        :headers="headers"
                        show-select="show-select"
                        class="elevation-1 text-start"
                        @click:row ="selectRow">
                        <template v-slot:item.created_at="{item}">
                            {{ formatDate(item.created_at) }}
                        </template>
                    </v-data-table>
                </v-card>
            </v-card>
        </v-responsive>
    </v-container-fluid>
</template>

<script>
    import axios from "axios";
    import moment from "moment";
    import {apiUrl} from "@/api/index.js";

    export default {
        data: () => ({
            ratio: 'rounded-xl',
            dialog: false,
            search: '',
            headers: [
                {
                    title: "Name",
                    align: "center",
                    value: "name"
                }, {
                    title: "E Mail",
                    align: "center",
                    value: "email"
                }, {
                    title: "Created At",
                    align: "center",
                    value: "created_at"
                }
            ],
            users: [],
            models: {
                name: '',
                email: "",
                password: ""
            },
            rules: {
                name: [value => !!value || "Name is required"],
                email: [value => !!value || "Email is required"],
                password: [
                    value => !!value || "Password is required",
                    value => (value && value.length >= 6) || "Password must be more than 5 characters"
                ]
            }

        }),

        methods: {
            getDataUsers() {
                axios
                    .get(`${apiUrl}/Users/getDataUsers`)
                    .then((response) => {
                        this.users = response.data.data
                    })
                    .catch(error => {
                        console.error('Error Fatching data User:', error)
                    })
                },
            formatDate(dataString) {
                return moment(dataString).format('DD-MM-YYYY')
            },
            createItem() {
                axios
                    .post(`${apiUrl}/Users/Users`, {
                        name: this.models.name,
                        email: this.models.email,
                        password: this.models.password

                    })
                    .then((response) => {
                        console.log(response.data.data)
                        this.getDataUsers(); // mengambil data users agar datatables akan terisi kembali ketika selesai input
                        this.dialog = false

                    })
                    .catch(error => {
                        console.log('error post data: ', error)

                    })
                },
                
            async deleteItem() {
                for (const selectedItem of this.users) {
                    try {
                        await axios.delete(`${apiUrl}/Users/Users/${selectedItem.id}`);
                        // Remove the item from the local users array
                        const index = this
                            .users
                            .findIndex((item) => item.id === selectedItem.id);
                        if (index !== -1) {
                            this
                                .users
                                .splice(index, 1);
                        }
                        this.selectedItem = null;
                    } catch (error) {
                        console.error('Error deleting item:', error);
                    }
                }
            }
        },

        mounted() {
            this.getDataUsers()
        }
    }
</script>

<style></style>
