<template>
  <v-container class="fill-height">
    <v-responsive class="text-center fill-height">
      <v-carousel>
        <v-carousel-item
          v-for="(data, index) in imageArray"
          :key="index"
          src="data.url"
          cover="cover"
        />
      </v-carousel>

      <v-tabs v-model="tab" color="orange-lighten-1" align-tabs="end" mt="3">
        <v-tab>All</v-tab>
        <v-tab>Furniture</v-tab>
        <v-tab>Lighting</v-tab>
        <v-tab>Decoration</v-tab>
        <v-tab>Electronics</v-tab>
      </v-tabs>

      <v-window v-model="tab">
        <v-window-item v-for="n in 4" :key="n" :value="n">
          <v-container fluid="fluid">
            <v-row>
              <v-col v-for="i in 6" :key="i" cols="12" md="2">
                <v-hover v-slot="{ isHovering, props }">
                  <v-card
                    :elevation="isHovering ? 12 : 2"
                    :class="{ 'on-hover': isHovering }"
                    v-bind="props"
                  >
                    <v-img
                      :src="`https://picsum.photos/500/300?image=${
                        i * n * 5 + 10
                      }`"
                      :lazy-src="`https://picsum.photos/10/6?image=${
                        i * n * 5 + 10
                      }`"
                      aspect-ratio="1"
                      cover="cover"
                    />

                    <div class="align-self-center">
                      <v-btn
                        v-for="(icon, index) in icons"
                        :key="index"
                        :class="{ 'show-btns': isHovering }"
                        :color="transparent"
                        :icon="icon"
                        :to="getNavigationLink(icon)"
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
  }),

  methods: {
    getNavigationLink(icon) {
      if (icon === "mdi-cube-scan") {
        return "/detail-product";
      } else if (icon === "mdi-cart-arrow-down") {
        return "/cart";
      } else if (icon === "mdi-thumb-up-outline") {
        return "/view";
      }
    },

    getImages() {
      axios.get(`${apiUrl}/banners/getDataImages`)
        .then((response) => {

          this.imageArray = response.data.data;
        })
        .catch((error) => {
          console.error("Error atching Images: ", error);
        });
    },
  },


  mounted() {
    this.getImages();
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
