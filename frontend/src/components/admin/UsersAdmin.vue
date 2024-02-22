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

                        <v-card>
                            <v-form @submit.prevent="submit">
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
                                                    v-if="isNewUser"
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
                    <v-btn
                        rounded="lg"
                        class="mx-1"
                        color="blue-darken-1"
                        elevation="6"
                        @click="createItem">{{$t('text.create')}}
                    </v-btn>
                    <v-btn
                        rounded="lg"
                        class="mx-1"
                        color="green-darken-1"
                        elevation="6"
                        @click="editItem"
                        v-if="selectedItem">{{$t('text.edit')}}
                    </v-btn>
                    <v-btn
                        rounded="lg"
                        class="mx-1"
                        elevation="6"
                        color="red-darken-1"
                        @click="deleteItem"
                        v-if="selectedItem">Delete</v-btn>

                </v-card-title>

                <v-divider></v-divider>
                <v-card>
                    <v-data-table
                        v-model:search="search"
                        :items="users"
                        item-key="id"
                        :headers="headers"
                        class="elevation-1 text-start"
                        @click:row="selectRow">
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
            isNewUser:true,
            headers: [
                {
                    title: "Name",
                    value: "name"
                }, {
                    title: "E Mail",
                    value: "email"
                }, {
                    title: "Created At",
                    value: "created_at"
                }
            ],
            users: [],
            selectedItem: false,
            url:'',
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
            selectRow(event, item) {
                this.selectedItem = item.item
            },
            createItem() {
                this.dialog = true
            },
            editItem() {
                let data = this.selectedItem
                this.isNewUser =false
                this.models = {
                    name: data.name,
                    email: data.email
                }
                this.dialog = true
            },
            submit() {
                let updateData = this.selectedItem
                if (updateData) {
                    axios
                        .put(`${apiUrl}/Users/Users/${updateData.id}`, {
                            name: this.models.name,
                            email: this.models.email

                        })
                        .then((response) => {
                            console.log(response.data.data)
                            this.getDataUsers(); // mengambil data users agar datatables akan terisi kembali ketika selesai input
                            this.dialog = false

                        })
                        .catch(error => {
                            console.log('error post data: ', error)

                        })
                    } else {
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
                    }
            },

            async deleteItem() {
              this.$swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then(async (result) => {
          if (result.isConfirmed) {
            let dataUpdate = this.selectedItem;
            try {
              await axios.delete(`${apiUrl}/Users/Users/${dataUpdate.id}`);
              // Remove the item from the local Users array
              this.getDataUsers(); // mengambil data categories agar datatables akan terisi kembali ketika selesai dihapus
            } catch (error) {
              console.error("Error deleting item:", error);
            }
            this.$swal.fire({
              title: "Deleted!",
              text: "Your file has been deleted.",
              icon: "success",
            });
          }
        });
            }
        },

        mounted() {
            this.getDataUsers()
        }
    }
</script>

<style></style>
