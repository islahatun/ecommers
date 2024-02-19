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
                        elevation="6"
                        color="red-darken-1"
                        @click="deleteItem">Delete</v-btn>

                </v-card-title>

                <v-divider></v-divider>
                <v-card>
                    <v-data-table
                        v-model:search="search"
                        :items="banks"
                        item-key="id"
                        :headers="headers"
                        show-select="show-select"
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
            createItem() {
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
                },

            async deleteItem() {
                for (const selectedItem of this.banks) {
                    try {
                        await axios.delete(`${apiUrl}/Banks/Banks/${selectedItem.id}`);
                        // Remove the item from the local Banks array
                        const index = this
                            .Banks
                            .findIndex((item) => item.id === selectedItem.id);
                        if (index !== -1) {
                            this
                                .Banks
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
            this.getDataBanks()
        }
    }
</script>

<style></style>
