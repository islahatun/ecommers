<template>
    <v-container class="fill-height">
        <v-responsive class="fill-height">
            <v-row>
                <v-col>
                    <v-card>
                        <v-img :src="detaiProduct.product_image" cover="cover"/>
                    </v-card>
                </v-col>
                <v-col>
                    <v-card subtitle="" variant="outline">
                      <v-card-item>
                        <v-card-title>{{ detaiProduct.product_name }}</v-card-title>
                        <v-card-subtitle>{{detaiProduct.price }}</v-card-subtitle>
                        <v-rating v-model="rating"  :size="35" color="orange-lighten-1" active-color="orange-lighten-1"/>
                      </v-card-item>
                      <v-divider></v-divider>
                    </v-card>
                </v-col>
            </v-row>

            <v-tabs v-model="tab" size="small" color="orange-lighten-1" class="mt-4" align-tabs="center">
                <v-tab v-for="item in itemsContent" :key="item" :value="item" @click="getItemsContent(item)">
                    {{ item }}
                </v-tab>
            </v-tabs>

            <v-window v-model="tab">
                <v-window-item v-for="item in itemsContent" :key="item" :value="item" >
                  <v-card color="basil" flat variant="outlined">
                    <v-card-text>{{text}}</v-card-text>
                  </v-card>
                </v-window-item>
            </v-window>

            <v-card title="Same Product" class="text-center">
              <v-row>
                <v-col v-for="(itemProduct,index) in ProductsByCatgory" :key="index" cols="12" md="2">
                    <v-hover v-slot="{isHovering, props}">
                        <v-card
                            :elevation="isHovering ? 12:2"
                            :class="{ 'on-hover': isHovering }"
                            v-bind="props" class="imgProduct">
                            <v-img
                                :src="itemProduct.product_image"
                                aspect-ratio="1"
                                cover="cover"/>
                                <v-card-title>{{ itemProduct.product_name }}</v-card-title>
                                <v-card-text>{{ itemProduct.price }}</v-card-text>
                            <div class="align-self-center">
                                <v-btn
                                    v-for="(icon, index) in icons"
                                    :key="index"

                                    :class="{ 'show-btns': isHovering }"
                                    :color="transparent"
                                    :icon="icon"
                                    :to="getNavigationLink(icon, itemProduct.id)"
                                    >
                                </v-btn>
                            </div>
                        </v-card>

                    </v-hover>
                </v-col>
            </v-row>
            </v-card>
        </v-responsive>
    </v-container>
</template>

<script >

import axios from "axios";
import { apiUrl } from "@/api/index.js";
export default{
  data:()=>({
    tab:'',
    itemsContent:['Description', 'Additional Information', 'Shipping & Returns', 'Reviews',],
    text: '',
    icons: [
                'mdi-cart-arrow-down', 'mdi-thumb-up-outline', 'mdi-cube-scan'
            ],
    transparent: 'rgba(255, 255, 255, 0)',
    rating:3,
    detaiProduct :[],
    description : '',
    dataByCategory : null,
    ProductsByCatgory :[]
  }),

  methods:{
    getNavigationLink(icon, productId) {
    
      if (icon === "mdi-cube-scan") {
        return `/detail-product/${productId}`;
      } else if (icon === "mdi-cart-arrow-down") {
        return `/cart/${productId}`;
      } else if (icon === "mdi-thumb-up-outline") {
        return "/view";
      }
    },

    getDetailProduct(){
      const parameterValue = this.$route.params.productId;
      axios.get(`${apiUrl}/products/getDataById`,{
        params:{id : parameterValue}
      })
      .then((response)=>{
        this.detaiProduct   = response.data.data
        this.description    = response.data.data.description
        this.dataByCategory = response.data.data.category_id

      }). catch((error)=>{
        console.error("Error fatching product: ", error);
      })
    },

    getItemsContent(tab){
      this.getDetailProduct()
      if(tab =='Description'){
        this.text = this.description
      } else{
        this.text = 'kalklaks'
      }
    },

    getDataByCategory(){
      this.getDetailProduct()
      console.log(this.dataByCategory)
      axios.get(`${apiUrl}/products/getDataProducts`,{
        params:{category_id :this.dataByCategory }
      }).then((response)=>{
        this.ProductsByCatgory = response.data.data
      }).catch((error)=>{
        console.error("Error fatching categories: ", error);
      })
    }
  },

  mounted() {
    this.getDetailProduct(),
    this.getDataByCategory()
  }
}
</script>
<style scoped="scoped">
    .imgProduct {
        transition: opacity 0.4s ease-in-out;
    }

    .imgProduct:not(.on-hover) {
        opacity: 0.6;
    }

    .show-btns {
        color: rgb(12, 11, 11) !important;
    }
</style>
