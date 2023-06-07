<script setup>
import { RouterView } from 'vue-router'
import Header from '@/components/AppHeader.vue'
import Footer from '@/components/AppFooter.vue'
</script>

<template>
  <Header />
  <main>
    <RouterView />
  </main>
  <Footer />
</template>
<style scoped>
main {
  max-width: 1366px;
  padding: 25px;
  margin: auto;
}
</style>
