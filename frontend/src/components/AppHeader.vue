<template>
  <header class="header">
    <nav class="nav">
      <ul class="nav-list">
        <li class="nav-item"><router-link to="/" class="nav-link">All Blogs</router-link></li>
        <li class="nav-item">
          <router-link to="/create" class="nav-link">Create Blog</router-link>
        </li>
        <li v-if="!isLoggedIn" class="nav-item">
          <router-link to="/login" class="nav-link">Login</router-link>
        </li>
        <li v-if="!isLoggedIn" class="nav-item">
          <router-link to="/register" class="nav-link">Register</router-link>
        </li>
        <li v-if="isLoggedIn" class="nav-item">
          <v-btn variant="text" color="white" class="nav-link" @click="logoutUser">Logout</v-btn>
        </li>
      </ul>
    </nav>
  </header>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import api from "@/axios";

export default {
  data() {
    return {
      isLoggedIn: false
    }
  },
  computed: {
    ...mapGetters('users', ['isAuthenticated']),
    isLogin() {
      const isAuthenticated = this.isAuthenticated
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      this.isLoggedIn = isAuthenticated
      return isAuthenticated
    }
  },
  methods: {
    ...mapActions('users', ['logout']),
    logoutUser() {
      this.logout()
    }
  },
  mounted() {
    this.isLogin
  }
}
</script>

<style scoped>
.header {
  background-color: black;
  padding: 25px 10px;
}

.nav {
  display: flex;
  justify-content: flex-end;
}

.nav-list {
  list-style-type: none;
  display: flex;
  justify-content: space-between;
  padding: 0;
  margin: 0;
}

.nav-item {
  margin: 0 10px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.nav-link {
  color: white;
  text-decoration: none;
  font-weight: 500;
}
</style>
