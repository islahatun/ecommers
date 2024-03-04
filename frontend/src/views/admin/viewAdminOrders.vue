

<template>
  <v-container-fluid>
    <v-card  class="mx-5"
    :class="ratio"
    elevation="6">
      <wizard/>

    </v-card>
  </v-container-fluid>

</template>

<script setup>
  import Wizard from '@/components/wizardComponent.vue'
</script>

<script>
export default {
  data:()=>({
    ratio: 'rounded-xl',
    search:'',
    headers: [
          {
            align: 'start',
            key: 'name',
            sortable: false,
            title: 'NAME',
          },
          { key: 'calories', title: 'Calories' },
          { key: 'fat', title: 'Fat (g)' },
          { key: 'carbs', title: 'Carbs (g)' },
          { key: 'protein', title: 'Protein (g)' },
          { key: 'iron', title: 'Iron (%)' },
        ],
        desserts: [],

  })
}
</script>
