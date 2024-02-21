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
                                                    :label="$t('banks.bankCode')"
                                                    :rules="rules.bank_code"
                                                    v-model="models.bank_code"
                                                    required="required"></v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-text-field
                                                    :label="$t('banks.bankName')"
                                                    :rules="rules.bank_name"
                                                    v-model="models.bank_name"
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
                                @click="createItem"
                                >{{$t('text.create')}}
                            </v-btn>
                            <v-btn
                                rounded="lg"
                                class="mx-1"
                                color="green-darken-1"
                                elevation="6"
                                @click="editItem"
                                v-if="selectedItem"
                                >{{$t('text.edit')}}
                            </v-btn>
                    <v-btn
                        rounded="lg"
                        class="mx-1"
                        elevation="6"
                        color="red-darken-1"
                        v-if="selectedItem"
                        @click="deleteItem">Delete</v-btn>

                </v-card-title>

                <v-divider></v-divider>
                <v-card>
                    <v-data-table
                        v-model:search="search"
                        :items="banks"
                        item-key="id"
                        :headers="headers"
                        :item-value="(item) => item.id"
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
            headers: [
                {
                    title: "Bank Code",
                    value: "bank_code"
                }, {
                    title: "Bank Name",
                    value: "bank_name"
                }, {
                    title: "Created At",
                    value: "created_at"
                }
            ],
            banks: [],
            selectedItem:null,
            models: {
                bank_code: '',
                bank_name: ""
            },
            rules: {
                bank_code: [value => !!value || "Bank Code is required"],
                bank_name: [value => !!value || "Bank Name is required"]
            }

        }),

        methods: {
            getDataBanks() {
                axios
                    .get(`${apiUrl}/Banks/getDataBanks`)
                    .then((response) => {
                        this.banks = response.data.data
                    })
                    .catch(error => {
                        console.error('Error Fatching data User:', error)
                    })
                },

            formatDate(dataString) {
                return moment(dataString).format('DD-MM-YYYY')
            },
            // event dan data ini default dari @click:row
            selectRow(event,item){
              this.selectedItem =item.item
            },

            createItem(){
              this.resetForm()
              this.dialog = true
            },

            editItem(){
              const data = this.selectedItem
              this.models= {bank_code:data.bank_code,bank_name:data.bank_name}
              this.dialog = true
            },

            submit() {
               let dataUpdate = this.selectedItem
               if(dataUpdate){
                axios
                    .put(`${apiUrl}/Banks/Banks/${dataUpdate.id}`, {
                                bank_code: this.models.bank_code,
                                bank_name: this.models.bank_name

                    })
                    .then((response) => {
                        console.log(response.data.data)
                        this.getDataBanks(); // mengambil data Banks agar datatables akan terisi kembali ketika selesai input
                        this.dialog = false

                    })
                    .catch(error => {
                        console.log('error post data: ', error)

                    })
               }else{
                axios
                    .post(`${apiUrl}/Banks/Banks`, {
                      // mengirim data multiple
                        data: [
                            {
                                bank_code: this.models.bank_code,
                                bank_name: this.models.bank_name
                            }
                        ]

                    })
                    .then((response) => {
                        console.log(response.data.data)
                        this.getDataBanks(); // mengambil data Banks agar datatables akan terisi kembali ketika selesai input
                        this.dialog = false

                    })
                    .catch(error => {
                        console.log('error post data: ', error)

                    })
               }
                },

            async deleteItem() {
              this
                    .$swal
                    .fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                    })
                    .then(async (result) => {
                        if (result.isConfirmed) {
                            let dataUpdate = this.selectedItem
                            try {
                                await axios.delete(`${apiUrl}/Banks/Banks/${dataUpdate.id}`);
                                // Remove the item from the local Banks array
                                this.getDataBanks(); // mengambil data categories agar datatables akan terisi kembali ketika selesai dihapus
                            } catch (error) {
                                console.error('Error deleting item:', error);
                            }
                            this
                                .$swal
                                .fire(
                                    {title: "Deleted!", text: "Your file has been deleted.", icon: "success"}
                                );

                        }
                    });
            },

            resetForm(){
              this.models = {bank_code:"",bank_name:""}
              this.selectedItem = null
            }
        },

        mounted() {
            this.getDataBanks()
        }
    }
</script>

<style></style>
