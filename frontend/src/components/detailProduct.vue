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
                <v-col v-for="i in 6" :key="i" cols="12" md="2">
                    <v-hover v-slot="{isHovering, props}">
                        <v-card
                            :elevation="isHovering ? 12:2"
                            :class="{ 'on-hover': isHovering }"
                            v-bind="props" class="imgProduct">
                            <v-img
                                src="https://source.unsplash.com/1300x900/?decoration"
                                aspect-ratio="1"
                                cover="cover"/>

                            <div class="align-self-center">
                                <v-btn
                                    v-for="(icon, index) in icons"
                                    :key="index"

                                    :class="{ 'show-btns': isHovering }"
                                    :color="transparent"
                                    :icon="icon"
                                    :to="icon === 'mdi-cube-scan' ?'/detail-product':null"
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
    description : ''
  }),

  methods:{
    getDetailProduct(){
      const parameterValue = this.$route.params.productId;
      axios.get(`${apiUrl}/products/getDataById`,{
        params:{id : parameterValue}
      })
      .then((response)=>{
        this.detaiProduct = response.data.data
        this.description  = response.data.data.description

      })
    },

    getItemsContent(tab){
      this.getDetailProduct()
      if(tab =='Description'){
        this.text = this.description
      } else{
        this.text = 'kalklaks'
      }
    }
  },

  mounted() {
    this.getDetailProduct()
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
