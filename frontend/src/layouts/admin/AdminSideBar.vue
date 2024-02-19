<template>
      <v-navigation-drawer
        v-model="drawer"
        :rail="rail"
        permanent
        @click="rail = false"
      >
        <v-list-item
          prepend-avatar="https://randomuser.me/api/portraits/men/85.jpg"
          title="John Leider"
          nav
        >
          <template v-slot:append>
            <v-btn
              variant="text"
              icon="mdi-chevron-left"
              @click.stop="rail = !rail"
            ></v-btn>
          </template>
        </v-list-item>

        <v-divider></v-divider>

        <v-list density="compact" nav>
          <v-list-item :to="'/admin/dashboard'" prepend-icon="mdi-home-city" title="Home" value="home"></v-list-item>
          <v-list-item :to="'/admin/users'" prepend-icon="mdi-account-group-outline" title="Users" value="users"></v-list-item>
          <v-list-item :to="'/admin/product'" prepend-icon="mdi-account" title="Product" value="Product"></v-list-item>
          <v-list-item :to="'/admin/complaint'" prepend-icon="mdi-account" title="Complaint" value="Complaint"></v-list-item>
          <v-list-item :to="'/admin/orders'" prepend-icon="mdi-account" title="Orders" value="Orders"></v-list-item>
          <v-list-item :to="'/admin/banks'" prepend-icon="mdi-account" title="Banks" value="Banks"></v-list-item>
          <v-list-item :to="'/admin/banners'" prepend-icon="mdi-account" title="Banners" value="Banners"></v-list-item>
          <v-list-item :to="'/admin/categories'" prepend-icon="mdi-account" title="Categoris" value="Categoris"></v-list-item>
        </v-list>
      </v-navigation-drawer>
</template>

<script>
  export default {
    data () {
      return {
        drawer: true,
        rail: false,
      }
    },
  }
</script>


<style>
</style>
