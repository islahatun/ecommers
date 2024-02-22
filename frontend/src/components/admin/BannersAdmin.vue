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
                                    <span class="text-h5">{{ $t("banners.create") }}</span >
                                </v-card-title>
                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-file-input
                                                    type="file"
                                                    :label="$t('banners.image')"
                                                    :rules="rules.image"
                                                    v-model="models.image"
                                                    required="required"
                                                    @change="onFileChange"></v-file-input>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-text-field
                                                    :label="$t('banners.status')"
                                                    :rules="rules.status"
                                                    v-model="models.status"
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
                        color="blue-darken-1"
                        elevation="6"
                        @click="createItem">{{ $t("text.create") }}
                    </v-btn>
                    <v-btn
                        rounded="lg"
                        class="mx-1"
                        color="green-darken-1"
                        elevation="6"
                        @click="editItem"
                        v-if="selectedItem">{{ $t("text.edit") }}
                    </v-btn>
                    <v-btn
                        rounded="lg"
                        class="mx-1"
                        elevation="6"
                        color="red-darken-1"
                        v-if="selectedItem"
                        @click="deleteItem">Delete</v-btn >
                </v-card-title>

                <v-divider></v-divider>
                <v-card class="my-2">
                    <v-data-table
                        v-model:search="search"
                        :items="banners"
                        item-key="id"
                        :headers="headers"
                        :item-value="(item) => item.id"
                        class="elevation-1 text-start { 'selected-row': selectedItem === item }"
                        @click:row="selectRow">
                        <template v-slot:item.image="{ item }"> <v-card class="my-2" elevation="2"
                        rounded> <v-img :src="`${item.image}`" height="66" width="100" cover ></v-img> </v-card>
                        </template>
                        <template v-slot:item.created_at="{ item }"> {{ formatDate(item.created_at)
                        }} </template>
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
            ratio: "rounded-xl",
            dialog: false,
            search: "",
            headers: [
                {
                    title: "Image",
                    value: "image"
                }, {
                    title: "Status",
                    value: "status"
                }, {
                    title: "Created At",
                    value: "created_at"
                }
            ],
            banners: [],
            selectedItem: null,
            getImage: null,
            models: {
                image: "",
                status: ""
            },
            rules: {
                image: [(value) => !!value || "Image is required"],
                status: [(value) => !!value || "Status required"]
            }
        }),

        methods: {
            getDataBanners() {
                axios
                    .get(`${apiUrl}/banners/getDataBanners`)
                    .then((response) => {
                        this.banners = response.data.data;
                        console.log(this.banners)
                    })
                    .catch((error) => {
                        console.error("Error Fatching data User:", error);
                    });
            },

            formatDate(dataString) {
                return moment(dataString).format("DD-MM-YYYY");
            },
            // event dan data ini default dari @click:row
            selectRow(event, item) {
                this.selectedItem = item.item;
            },

            onFileChange(e) {
                const file = e
                    .target
                    .files[0]
                this.getImage = file
            },

            createItem() {
                this.resetForm();
                this.dialog = true;
            },

            editItem() {
                const data = this.selectedItem;
                this.models = {
                    image: data.image,
                    status: data.status
                };
                this.dialog = true;
            },

            submit() {
                let dataUpdate = this.selectedItem;
                let image = this
                    .getImage
                    console
                    .log(image.name)
                if (dataUpdate) {
                    axios
                        .put(`${apiUrl}/banners/banners/${dataUpdate.id}`, {
                            headers: {
                                'Content-Type': 'multipart/form-data', // Penting untuk mengatur tipe konten
                            },
                            image: image,
                            status: this.models.status
                        })
                        .then((response) => {
                            console.log(response.data.data);
                            this.getDataBanners(); // mengambil data Banners agar datatables akan terisi kembali ketika selesai input
                            this.dialog = false;
                        })
                        .catch((error) => {
                            console.log("error post data: ", error);
                        });
                } else {
                    const formData = new FormData();
                    formData.append('image', image);
                    axios
                        .post(`${apiUrl}/banners/banners`, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data', // Penting untuk mengatur tipe konten
                            },
                            params: {
                                status: this.models.status
                            }
                        })
                        .then((response) => {
                            console.log(response.data.data);
                            this.getDataBanners(); // mengambil data Banners agar datatables akan terisi kembali ketika selesai input
                            this.dialog = false;
                        })
                        .catch((error) => {
                            console.log("error post data: ", error);
                        });
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
                            let dataUpdate = this.selectedItem;
                            try {
                                await axios.delete(`${apiUrl}/Banners/Banners/${dataUpdate.id}`);
                                // Remove the item from the local Banners array
                                this.getDataBanners(); // mengambil data categories agar datatables akan terisi kembali ketika selesai dihapus
                            } catch (error) {
                                console.error("Error deleting item:", error);
                            }
                            this
                                .$swal
                                .fire(
                                    {title: "Deleted!", text: "Your file has been deleted.", icon: "success"}
                                );
                        }
                    });
            },

            resetForm() {
                this.models = {
                    image: "",
                    status: ""
                };
                this.selectedItem = null;
            }
        },

        mounted() {
            this.getDataBanners();
        }
    };
</script>

<style></style>
