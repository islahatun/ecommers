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
            single-line
            flat
            hide-details
            variant="solo-filled"
          ></v-text-field>

          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" persistent width="1024">
            <template v-slot:activator="{ props }">
              <v-btn  rounded="lg" class="mx-1" color="blue-darken-1" elevation="6"  v-bind="props">Add</v-btn>
            </template>

            <v-card>
              <v-card-title color="green-darken-2">
                <span class="text-h5">Edit User Profile</span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col
                      cols="12"
                      sm="6"
                      md="4"
                    >
                      <v-text-field
                        label="Legal first name*"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col
                      cols="12"
                      sm="6"
                      md="4"
                    >
                      <v-text-field
                        label="Legal middle name"
                        hint="example of helper text only on focus"
                      ></v-text-field>
                    </v-col>
                    <v-col
                      cols="12"
                      sm="6"
                      md="4"
                    >
                      <v-text-field
                        label="Legal last name*"
                        hint="example of persistent helper text"
                        persistent-hint
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <v-text-field
                        label="Email*"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <v-text-field
                        label="Password*"
                        type="password"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col
                      cols="12"
                      sm="6"
                    >
                      <v-select
                        :items="['0-17', '18-29', '30-54', '54+']"
                        label="Age*"
                        required
                      ></v-select>
                    </v-col>
                    <v-col
                      cols="12"
                      sm="6"
                    >
                      <v-autocomplete
                        :items="['Skiing', 'Ice hockey', 'Soccer', 'Basketball', 'Hockey', 'Reading', 'Writing', 'Coding', 'Basejump']"
                        label="Interests"
                        multiple
                      ></v-autocomplete>
                    </v-col>
                  </v-row>
                </v-container>
                <small>*indicates required field</small>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="blue-darken-1"
                  variant="text"
                  @click="dialog = false"
                >
                  Close
                </v-btn>
                <v-btn
                  color="blue-darken-1"
                  variant="text"
                  @click="dialog = false"
                >
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>

          </v-dialog>

          <v-dialog v-model="dialog" persistent width="1024">
            <template v-slot:activator="{ props }">
              <v-btn  rounded="lg" class="mx-1" color="green-darken-1" elevation="6"  v-bind="props">Edit</v-btn>
            </template>

            <v-card>
              <v-card-title  color="green-darken-2">
                <span class="text-h5">Add User Profile</span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col
                      cols="12"
                      sm="6"
                      md="4"
                    >
                      <v-text-field
                        label="Legal first name*"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col
                      cols="12"
                      sm="6"
                      md="4"
                    >
                      <v-text-field
                        label="Legal middle name"
                        hint="example of helper text only on focus"
                      ></v-text-field>
                    </v-col>
                    <v-col
                      cols="12"
                      sm="6"
                      md="4"
                    >
                      <v-text-field
                        label="Legal last name*"
                        hint="example of persistent helper text"
                        persistent-hint
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <v-text-field
                        label="Email*"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <v-text-field
                        label="Password*"
                        type="password"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col
                      cols="12"
                      sm="6"
                    >
                      <v-select
                        :items="['0-17', '18-29', '30-54', '54+']"
                        label="Age*"
                        required
                      ></v-select>
                    </v-col>
                    <v-col
                      cols="12"
                      sm="6"
                    >
                      <v-autocomplete
                        :items="['Skiing', 'Ice hockey', 'Soccer', 'Basketball', 'Hockey', 'Reading', 'Writing', 'Coding', 'Basejump']"
                        label="Interests"
                        multiple
                      ></v-autocomplete>
                    </v-col>
                  </v-row>
                </v-container>
                <small>*indicates required field</small>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="blue-darken-1"
                  variant="text"
                  @click="dialog = false"
                >
                  Close
                </v-btn>
                <v-btn
                  color="blue-darken-1"
                  variant="text"
                  @click="dialog = false"
                >
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>

          </v-dialog>

          <v-btn  rounded="lg" class="mx-1" elevation="6" color="red-darken-1">
            <v-icon></v-icon>
            Delete
          </v-btn>

        </v-card-title>

        <v-divider></v-divider>
        <v-card>
          <v-data-table v-model:search="search" :items="items">
            <template v-slot:header.stock>
              <div class="text-end">Stock</div>
            </template>

            <template v-slot:item.image="{ item }">
              <v-card class="my-2" elevation="2" rounded>
                <v-img
                  :src="`https://cdn.vuetifyjs.com/docs/images/graphics/gpus/${item.image}`"
                  height="64"
                  cover
                ></v-img>
              </v-card>
            </template>

            <template v-slot:item.rating="{ item }">
              <v-rating
                :model-value="item.rating"
                color="orange-darken-2"
                density="compact"
                size="small"
                readonly
              ></v-rating>
            </template>

            <template v-slot:item.stock="{ item }">
              <div class="text-end">
                <v-chip
                  :color="item.stock ? 'green' : 'red'"
                  :text="item.stock ? 'In stock' : 'Out of stock'"
                  class="text-uppercase"
                  label
                  size="small"
                ></v-chip>
              </div>
            </template>
          </v-data-table>
        </v-card>
      </v-card>
    </v-responsive>
  </v-container-fluid>
</template>

<script>
export default {
    data :()=>({
      ratio: 'rounded-xl',
      dialog:false,
      search: '',
        items: [
          {
            name: 'Nebula GTX 3080',
            image: '1.png',
            price: 699.99,
            rating: 5,
            stock: true,
          },
          {
            name: 'Galaxy RTX 3080',
            image: '2.png',
            price: 799.99,
            rating: 4,
            stock: false,
          },
          {
            name: 'Orion RX 6800 XT',
            image: '3.png',
            price: 649.99,
            rating: 3,
            stock: true,
          },
          {
            name: 'Vortex RTX 3090',
            image: '4.png',
            price: 1499.99,
            rating: 4,
            stock: true,
          },
          {
            name: 'Cosmos GTX 1660 Super',
            image: '5.png',
            price: 299.99,
            rating: 4,
            stock: false,
          },
        ],
    })
  }
</script>

<style>
</style>
