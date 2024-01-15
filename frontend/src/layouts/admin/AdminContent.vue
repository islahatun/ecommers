<template>
  <v-app>
    <side-bar />

    <app-bar />
    <v-main>
      <router-view />
    </v-main>
  </v-app>
</template>

<script setup>
import AppBar from './AdminAppBar.vue'
import SideBar from './AdminSideBar.vue'
</script>

<style>
</style>
