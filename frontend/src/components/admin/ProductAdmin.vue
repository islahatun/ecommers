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
                                    <span class="text-h5">{{$t('products.createProducts')}}</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field
                                                    :label="$t('products.productName')"
                                                    :rules="rules.product_name"
                                                    v-model="models.product_name"
                                                    required="required"></v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-autocomplete
                                                    :label="$t('products.productCategory')"
                                                    :rules="rules.category_id"
                                                    :items="itemsCategory"
                                                    item-title="category_name"
                                                    item-value="id"
                                                    v-model="models.category_id"
                                                    :search-input.sync="search"
                                                    required="required"></v-autocomplete>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-text-field
                                                    :label="$t('products.productPrice')"
                                                    :rules="rules.price"
                                                    v-model="models.price"
                                                    required="required"></v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-text-field
                                                    :label="$t('products.productWeight')"
                                                    :rules="rules.weight"
                                                    v-model="models.weight"
                                                    required="required"></v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-textarea
                                                    :label="$t('products.productDescription')"
                                                    :rules="rules.description"
                                                    v-model="models.description"
                                                    required="required"></v-textarea>
                                            </v-col>
                                            <v-col cols="12" v-if="isUpdate">
                                            <v-img v-model="models.prev_image" :src="models.prev_image" width="100"></v-img>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-file-input
                                                    :label="$t('products.productImage')"
                                                    accept="image/*"
                                                    type="file"
                                                    :rules="rules.product_image"
                                                    v-model="models.product_image"
                                                    required="required"></v-file-input>
                                            </v-col>

                                        </v-row>
                                    </v-container>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue-darken-1" variant="text" @click="dialog = false">
                                        Close
                                    </v-btn>
                                    <v-btn color="blue-darken-1" variant="text" type="submit">
                                        Save
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
                               >{{$t('text.create')}}</v-btn>
                            <v-btn
                                rounded="lg"
                                class="mx-1"
                                color="green-darken-1"
                                elevation="6"
                                v-if="selectedItem"
                                @click="editItem"
                               >{{$t('text.edit')}}</v-btn>
                    <v-btn rounded="lg" class="mx-1" elevation="6" color="red-darken-1" v-if="selectedItem" @click="deleteItem">
                        {{$t('text.delete') }}
                    </v-btn>

                </v-card-title>

                <v-divider></v-divider>
                <v-card>
                    <v-data-table
                        v-model:search="search"
                        :items="itemsProduct"
                        :headers="headers"
                        @click:row="selectRow">
                        <template v-slot:header.stock>
                            <div class="text-end">Stock</div>
                        </template>
                        <template v-slot:header.actions>
                          <div class="text-end">Actions</div>
                      </template>

                        <template v-slot:item.product_image="{ item }">
                            <v-card class="my-2" elevation="2" rounded="rounded">
                                <v-img
                                    :src="`${item.product_image}`"
                                    height="66" width="100"
                                    cover="cover"></v-img>
                            </v-card>
                        </template>

                        <template v-slot:item.rating="{ item }">
                            <v-rating
                                :model-value="item.rating"
                                color="orange-darken-2"
                                density="compact"
                                size="small"
                                readonly="readonly"></v-rating>
                        </template>

                        <template v-slot:item.stock="{ item }">
                            <div class="text-end">
                                <v-chip
                                    :color="item.stock ? 'green' : 'red'"
                                    :text="item.stock ? 'In stock' : 'Out of stock'"
                                    class="text-uppercase"
                                    label="label"
                                    size="small"></v-chip>
                            </div>
                        </template>
                        <template v-slot:item.actions="{item}">
                          <div class="text-end">
                            <v-btn elevation="2" rounded="rounded" color="orange-darken-1" @click="editItem(item)">{{$t('text.detail')}}</v-btn>
                          </div>
                        </template>
                    </v-data-table>
                </v-card>
            </v-card>
        </v-responsive>
    </v-container-fluid>
</template>

<script>
    import axios from "axios";
    import {apiUrl} from "@/api/index.js";
    export default {
        data: () => ({
            ratio: 'rounded-xl',
            dialog: false,
            isUpdate:true,
            search: '',
            headers: [
                {
                    title: 'Product Name',
                    value: 'product_name'
                }, {
                    title: 'Product Image',
                    value: 'product_image'
                }, {
                    title: 'Price Product',
                    value: 'price'
                }, {
                    title: 'rating',
                    value: 'rating'
                }, {
                    title: 'stock',
                    value: 'stock'
                },
                {
                  title:'Actions',key:'actions',sortabe:false
                }
            ],
            itemsProduct: [],
            itemsCategory: [],
            selectedItem: null,
            models: {
                product_name: '',
                category_id: '',
                product_image: '',
                price: '',
                weight: '',
                description: '',
                prev_image:''
            },
            rules: {
                product_name: [(value) => !!value || "Product Name is required"],
                category_id: [(value) => !!value || "Category Name required"],
                product_image: [(value) => !!value || "Product Image required"],
                price: [(value) => !!value || "Price required"],
                weight: [(value) => !!value || "Weight required"],
                description: [(value) => !!value || "Description required"]
            }
        }),

        methods: {
            selectRow(event, item) {
                this.selectedItem = item.item

            },
            getDataProducts(){
              axios.get(`${apiUrl}/products/getDataProducts`).then((response)=>{
                this.itemsProduct = response.data.data
              })
            },
            async getCatgeory() {
                await axios
                    .get(`${apiUrl}/categories/getDataCategories`)
                    .then((response) => {

                        this.itemsCategory = response
                            .data
                            .data
                    })
            },

            createItem(){
              this.dialog = true;
            },

            editItem(){
              let getData = this.selectedItem
              this.models = {
                product_name  : getData.product_name,
                category_id   : getData.category_id,
                prev_image    : getData.product_image,
                price         : getData.price,
                description   : getData.description,
                weight        : getData.weight
              }
              this.search = getData.category_name;
              this.dialog = true;
            },

            submit() {
                let selectData = this.selectedItem
                console.log(selectData)
                const formData = new FormData();
                formData.append('product_image', this.models.product_image[0])
                formData.append('product_name', this.models.product_name)
                formData.append('price', this.models.price)
                formData.append('weight', this.models.weight)
                formData.append('category_id', this.models.category_id)
                formData.append('description', this.models.description)

                if (selectData) {
                    axios
                        .put(`${apiUrl}/products/products/${selectData.id}`,formData,{
                          headers: {
                                'Content-Type': 'multipart/form-data', // Penting untuk mengatur tipe konten
                            }
                        })
                        .then((response) => {
                          this.dialog = false
                          this.getDataProducts()
                            this
                                .$swal
                                .fire(
                                    {position: "top-end", icon: "success", title: "Your work has been saved", showConfirmButton: false, timer: 1500}
                                );
                        })
                } else {
                    axios
                        .post(`${apiUrl}/products/products`, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data', // Penting untuk mengatur tipe konten
                            }
                        })
                        .then((response) => {
                          this.dialog = false
                          this.getDataProducts()
                            this
                                .$swal
                                .fire(
                                    {position: "top-end", icon: "success", title: "Your work has been saved", showConfirmButton: false, timer: 1500}
                                );
                        })
                }
            }
        },

        async mounted() {
            await this.getCatgeory()
            await this.getDataProducts()
        }
    }
</script>

<style></style>
