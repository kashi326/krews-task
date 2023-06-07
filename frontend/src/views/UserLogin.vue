<template>
  <v-card max-width="500" class="tw-m-auto">
    <v-card-title>
      <h2>Login</h2>
    </v-card-title>
    <v-divider style="opacity: 1"/>
    <v-card-text >
      <v-form @submit.prevent="handleLogin">
        <v-text-field v-model="credentials.username" variant="outlined" label="Username"></v-text-field>
        <v-text-field v-model="credentials.password" variant="outlined" label="Password" type="password"></v-text-field>
        <div class="tw-flex tw-justify-end">
          <v-btn type="submit" color="primary">Login</v-btn>
        </div>
      </v-form>

    </v-card-text>
  </v-card>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  data() {
    return {
      credentials: {
        username: '',
        password: ''
      }
    }
  },
  methods: {
    ...mapActions('users', ['login']),
    async handleLogin() {
      try {
        await this.login(this.credentials)
        this.$router.push('/')
      } catch (error) {
        // Handle login error
        console.error('Login error:', error)
      }
    }
  },
}
</script>
