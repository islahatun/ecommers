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
                                v-bind="props">{{ $t("text.create") }}
                            </v-btn>
                        </template>

                        <v-card>
                            <v-form @submit.prevent="createItem">
                                <v-card-title color="green-darken-2">
                                    <span class="text-h5">{{ $t("text.create") }}
                                    </span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field
                                                    :label="$t('categories.categoryName')"
                                                    :rules="rules.category_name"
                                                    v-model="models.category_name"
                                                    required="required"></v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue-darken-1" variant="text" @click="dialog = false">
                                        {{ $t("text.closeDialog") }}
                                    </v-btn>
                                    <v-btn color="blue-darken-1" variant="text" type="submit">
                                        {{ $t("text.save") }}
                                    </v-btn>
                                </v-card-actions>
                            </v-form>
                        </v-card>
                    </v-dialog>
                    <v-btn
                        rounded="lg"
                        class="mx-1"
                        color="green-darken-1"
                        elevation="6"
                        @click="editItem"
                        v-if="selectedItem"
                        v-bind="props">{{ $t("text.edit") }}
                    </v-btn>
                    <v-btn
                        rounded="lg"
                        class="mx-1"
                        elevation="6"
                        color="red-darken-1"
                        @click="deleteItem">Delete</v-btn >
                </v-card-title>

                <v-divider></v-divider>
                <v-card>
                    <v-data-table
                        v-model:search="search"
                        :items="categories"
                        item-key="id"
                        :headers="headers"
                        show-select="show-select"
                        :item-value="(item) => item.id"
                        class="elevation-1 text-start"
                        @click:row="selectRow">
                        <template v-slot:item.created_at="{ item }">
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
                    title: "Category Name",
                    value: "category_name"
                }, {
                    title: "Created At",
                    value: "created_at"
                }
            ],
            categories: [],
            selectedItem: null,
            models: {
                category_name: ""
            },
            rules: {
                category_name: [value => !!value || "Bank Name is required"]
            }

        }),

        methods: {
            getDatacategories() {
                let dataUpdate = axios
                    .get(`${apiUrl}/categories/getDataCategories`)
                    .then((response) => {
                        this.categories = response.data.data
                    })
                    .catch(error => {
                        console.error('Error Fatching data User:', error)
                    })
                },
            formatDate(dataString) {
                return moment(dataString).format('DD-MM-YYYY')
            },

            // event dan item ini default dari veutify @click:row : ivent mengambil event
            // sedangkan item mengambil data item yang ada di datatables
            selectRow(event, item) {

                this.selectedItem = item.item
            },

            createItem() {

                let dataUpdate = this.selectedItem
                if (dataUpdate != null) {
                    axios
                        .put(
                            `${apiUrl}/categories/categories/${dataUpdate.id}`,
                            {category_name: this.models.category_name}
                        )
                        .then((response) => {
                            console.log(response.data.data)
                            this.getDatacategories(); // mengambil data categories agar datatables akan terisi kembali ketika selesai input
                            this.dialog = false

                        })
                        .catch(error => {
                            console.log('error post data: ', error)

                        })
                    } else {
                    axios
                        .post(
                            `${apiUrl}/categories/categories`,
                            {category_name: this.models.category_name}
                        )
                        .then((response) => {
                            console.log(response.data.data)
                            this.getDatacategories(); // mengambil data categories agar datatables akan terisi kembali ketika selesai input
                            this.dialog = false

                        })
                        .catch(error => {
                            console.log('error post data: ', error)

                        })
                    }

            },

            editItem() {
                const data = this.selectedItem
                this.dialog = true
                this.models.category_name = data.category_name
            },

            async deleteItem() {
              let dataUpdate = this.selectedItem
                    try {
                        await axios.delete(`${apiUrl}/categories/categories/${dataUpdate.id}`);
                        // Remove the item from the local categories array
                        this.getDatacategories(); // mengambil data categories agar datatables akan terisi kembali ketika selesai dihapus
                    } catch (error) {
                        console.error('Error deleting item:', error);
                    }

            }
        },

        mounted() {
            this.getDatacategories()
        }
    }
</script>

<style></style>
