<template>
    <v-container-fluid>
        <v-responsive>
            <v-row>
                <v-col v-for="n in 4" :key="n" cols="3">
                    <v-card
                        class="mx-5"
                        :class="ratio"
                        max-width="344"
                        elevation="6"
                        color="indigo-lighten-5">
                        <v-card-item>
                            <v-card-title>Card Title</v-card-title>
                            <v-card-subtitle>Card Subtitle Secondary</v-card-subtitle>
                        </v-card-item>

                        <v-card-text>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore magna aliqua.
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <v-row>
                <v-card
                    class="mx-5 my-5"
                    :class="ratio"
                    elevation="7"
                    max-width="800">
                    <v-card-item>
                        <v-card-title>Card Title</v-card-title>
                        <v-card-subtitle>Card Subtitle Secondary</v-card-subtitle>
                    </v-card-item>

                    <v-card-text>
                      <template v-slot:text>
                        <v-text-field
                          v-model="search"
                          label="Search"
                          prepend-inner-icon="mdi-magnify"
                          single-line
                          variant="outlined"
                          hide-details
                        ></v-text-field>
                      </template>
                        <v-data-table-server
                            v-model:items-per-page="itemsPerPage"
                            :headers="headers"
                            :items-length="totalItems"
                            :items="serverItems"
                            :loading="loading"
                            item-value="name"
                            :search="search"
                            @update:options="loadItems"
                            :width="100"></v-data-table-server>
                    </v-card-text>
                </v-card>
            </v-row>
        </v-responsive>
    </v-container-fluid>
</template>

<script>

const desserts = [
    {
      name: 'Frozen Yogurt',
      calories: 159,
      fat: 6.0,
      carbs: 24,
      protein: 4.0,
      iron: '1',
    },
    {
      name: 'Jelly bean',
      calories: 375,
      fat: 0.0,
      carbs: 94,
      protein: 0.0,
      iron: '0',
    },
    {
      name: 'KitKat',
      calories: 518,
      fat: 26.0,
      carbs: 65,
      protein: 7,
      iron: '6',
    },
    {
      name: 'Eclair',
      calories: 262,
      fat: 16.0,
      carbs: 23,
      protein: 6.0,
      iron: '7',
    },
    {
      name: 'Gingerbread',
      calories: 356,
      fat: 16.0,
      carbs: 49,
      protein: 3.9,
      iron: '16',
    },
    {
      name: 'Ice cream sandwich',
      calories: 237,
      fat: 9.0,
      carbs: 37,
      protein: 4.3,
      iron: '1',
    },
    {
      name: 'Lollipop',
      calories: 392,
      fat: 0.2,
      carbs: 98,
      protein: 0,
      iron: '2',
    },
    {
      name: 'Cupcake',
      calories: 305,
      fat: 3.7,
      carbs: 67,
      protein: 4.3,
      iron: '8',
    },
    {
      name: 'Honeycomb',
      calories: 408,
      fat: 3.2,
      carbs: 87,
      protein: 6.5,
      iron: '45',
    },
    {
      name: 'Donut',
      calories: 452,
      fat: 25.0,
      carbs: 51,
      protein: 4.9,
      iron: '22',
    },
  ]

  const FakeAPI = {
    async fetch ({ page, itemsPerPage, sortBy }) {
      return new Promise(resolve => {
        setTimeout(() => {
          const start = (page - 1) * itemsPerPage
          const end = start + itemsPerPage
          const items = desserts.slice()

          if (sortBy.length) {
            const sortKey = sortBy[0].key
            const sortOrder = sortBy[0].order
            items.sort((a, b) => {
              const aValue = a[sortKey]
              const bValue = b[sortKey]
              return sortOrder === 'desc' ? bValue - aValue : aValue - bValue
            })
          }

          const paginated = items.slice(start, end)

          resolve({ items: paginated, total: items.length })
        }, 500)
      })
    },
  }

    export default {
            data: () => ({
              ratio: 'rounded-xl',
              itemsPerPage: 5,
              search: '',
              headers: [
        {
          title: 'Dessert (100g serving)',
          align: 'start',
          sortable: false,
          key: 'name',
        },
        { title: 'Calories', key: 'calories', align: 'end' },
        { title: 'Fat (g)', key: 'fat', align: 'end' },
        { title: 'Carbs (g)', key: 'carbs', align: 'end' },
        { title: 'Protein (g)', key: 'protein', align: 'end' },
        { title: 'Iron (%)', key: 'iron', align: 'end' },
      ],
      serverItems: [],
      loading: true,
      totalItems: 0,
            }),

            methods: {
      loadItems ({ page, itemsPerPage, sortBy }) {
        this.loading = true
        FakeAPI.fetch({ page, itemsPerPage, sortBy }).then(({ items, total }) => {
          this.serverItems = items
          this.totalItems = total
          this.loading = false
        })
      },
    },
        }
</script>

<style></style>
