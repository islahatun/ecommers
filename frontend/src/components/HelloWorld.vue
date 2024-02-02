<template>
  <v-container class="fill-height">
    <v-responsive class="text-center fill-height">
      <v-carousel>
        <v-carousel-item
          v-for="(data, index) in imageArray"
          :key="index"
          :src="data.url"
          cover="cover"
        />
      </v-carousel>

      <v-tabs v-model="tab" color="orange-lighten-1" align-tabs="end" mt="3">
        <v-tab v-for="(dataCategory,index) in catgoryArray" :key="index" :value="dataCategory.id" @click="onTabChange(dataCategory.id)" >{{dataCategory.category_name}}</v-tab>
      </v-tabs>

      <v-window v-model="tab">
        <v-window-item v-for="n in 4" :key="n" :value="n">
          <v-container fluid="fluid">
            <v-row>
              <v-col
                v-for="(dataProducts, index) in allProducts"
                :key="index"
                cols="12"
                md="2"
              >
                <v-hover v-slot="{ isHovering, props }">
                  <v-card
                    :elevation="isHovering ? 12 : 2"
                    :class="{ 'on-hover': isHovering }"
                    v-bind="props"
                  >
                    <v-img
                      :src="dataProducts.product_image"
                      :lazy-src="dataProducts.product_image"
                      aspect-ratio="1"
                      cover="cover"
                    />
                    <v-card-title>{{ dataProducts.product_name }}</v-card-title>
                    <v-card-text>{{ dataProducts.price }}</v-card-text>

                    <div class="align-self-center">
                      <v-btn
                        v-for="(icon, index) in icons"
                        :key="index"
                        :class="{ 'show-btns': isHovering }"
                        :color="transparent"
                        :icon="icon"
                        :to="getNavigationLink(icon, dataProducts.id)"
                      >
                      </v-btn>
                    </div>
                  </v-card>
                </v-hover>
              </v-col>
            </v-row>
          </v-container>
        </v-window-item>
      </v-window>
    </v-responsive>
  </v-container>
</template>

<script >
import axios from "axios";
import { apiUrl } from "@/api/index.js";

export default {
  data: () => ({
    tab: null,
    icons: ["mdi-cart-arrow-down", "mdi-thumb-up-outline", "mdi-cube-scan"],
    transparent: "rgba(255, 255, 255, 0)",
    imageArray: [],
    allProducts: [],
    catgoryArray: [],
  }),

  methods: {
    getNavigationLink(icon, productId) {
      if (icon === "mdi-cube-scan") {
        return `/detail-product/${productId}`;
      } else if (icon === "mdi-cart-arrow-down") {
        return `/cart/${productId}`;
      } else if (icon === "mdi-thumb-up-outline") {
        return "/view";
      }
    },

    getImages() {
      axios
        .get(`${apiUrl}/banners/getDataImages`)
        .then((response) => {
          this.imageArray = response.data.data;
        })
        .catch((error) => {
          console.error("Error fatching Images: ", error);
        });
    },

    getAllProduct(categoryId) {
      axios
        .get(`${apiUrl}/products/getDataProducts`,{
          params:{category_id : categoryId}
        })
        .then((response) => {
          console.log(response.data.data);
          this.allProducts = response.data.data;
        })
        .catch((error) => {
          console.error("Error fatching Products: ", error);
        });
    },

    getAllCategory() {
      axios
        .get(`${apiUrl}/categories/getDataCategories`)
        .then((response) => {
          this.catgoryArray = response.data.data;
        })
        .catch((error) => {
          console.error("Error fatching categories: ", error);
        });
    },

    onTabChange(categoryId){
    this.getAllProduct(categoryId)
  },

  },



  computed : {
    filteredProducts(){
      // filter products by category
      return this.allProducts.filter((product)=>product.category_id === this.tab)
    }
  },

  mounted() {
    this.getImages();
    this.getAllCategory();
  },
};
</script>

<style scoped="scoped">
.v-card {
  transition: opacity 0.4s ease-in-out;
}

.v-card:not(.on-hover) {
  opacity: 0.6;
}

.show-btns {
  color: rgb(12, 11, 11) !important;
}
</style>
