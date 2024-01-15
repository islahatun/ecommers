<template>
    <v-container class="fill-height">
        <v-responsive class="fill-height">
            <v-row>
                <v-col>
                    <v-card>
                        <v-img src="https://source.unsplash.com/1300x900/?decoration" cover="cover"/>
                    </v-card>
                </v-col>
                <v-col>
                    <v-card subtitle="" variant="outline">
                      <v-card-item>
                        <v-card-title>Nama Produk</v-card-title>
                        <v-rating v-model="rating"  :size="35" color="orange-lighten-1" active-color="orange-lighten-1"/>
                      </v-card-item>
                      <v-divider></v-divider>
                    </v-card>
                </v-col>
            </v-row>

            <v-tabs v-model="tab" size="small" color="orange-lighten-1" class="mt-4" align-tabs="center">
                <v-tab v-for="item in itemsContent" :key="item" :value="item">
                    {{ item }}
                </v-tab>
            </v-tabs>

            <v-window v-model="tab">
                <v-window-item v-for="item in itemsContent" :key="item" :value="item">
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
export default{
  data:()=>({
    tab:'Description',
    itemsContent:['Description', 'Additional Information', 'Shipping & Returns', 'Reviews',],
    text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
    icons: [
                'mdi-cart-arrow-down', 'mdi-thumb-up-outline', 'mdi-cube-scan'
            ],
            transparent: 'rgba(255, 255, 255, 0)',
            rating:3
  })
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
