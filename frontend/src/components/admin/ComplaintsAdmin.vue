<template>
  <v-container-fluid>
    <v-responsive>
      <v-card :class="ratio" elevation="6" class="mx-3 my-3">
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
      <v-spacer/>

      <v-btn color="blue-darken-1" elevation="6" class="mx-1">Add</v-btn>
      <v-btn color="green-darken-1" elevation="6" class="mx-1">Edit</v-btn>
      <v-btn color="red-darken-1" elevation="6" class="mx-1">
        <v-icon icon="delete-outline"></v-icon>
        Delete
      </v-btn>

       </v-card-title>
        <v-data-table :items="items" :headers="headers" v-model:search="search"></v-data-table>
      </v-card>
    </v-responsive>
  </v-container-fluid>
</template>

<script>
export default {
  data: () => ({
    ratio: "rounded-xl",
    search: '',
    headers:[
      {title:'Name', key:'name'},
      {title:'complaint',key:'complaint'},
      {title:'Status',key:'status'}
    ],
    items : [
  {
    name: "African Elephant",
    complaint: "Loxodonta africana",
    status: "Herbivore",
  },
  {
    name: "African Elephant",
    complaint: "Loxodonta africana",
    status: "Herbivore",
  },
  {
    name: "African Elephant",
    complaint: "Loxodonta africana",
    status: "Herbivore",
  },
  {
    name: "African Elephant",
    complaint: "Loxodonta africana",
    status: "Herbivore",
  },
]
  }),
};
</script>
