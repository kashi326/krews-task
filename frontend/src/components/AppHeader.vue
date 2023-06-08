<template>
  <header class="header">
    <nav class="nav">
      <ul class="nav-list">
        <li class="nav-item" v-if="isLoggedIn"><router-link to="/" class="nav-link">All Blogs</router-link></li>
        <li class="nav-item" v-if="isLoggedIn">
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

export default {
  data() {
    return {
      isLoggedIn: false
    }
  },
  computed: {
    ...mapGetters('users', ['isAuthenticated'])
  },
  methods: {
    ...mapActions('users', ['logout']),
    async logoutUser() {
      await this.logout()
      window.location.href = '/login'
      this.isLoggedIn = false
    }
  },
  created() {
    this.isLoggedIn = this.isAuthenticated
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
