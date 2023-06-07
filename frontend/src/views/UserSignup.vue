<template>
  <v-card max-width="500" class="tw-m-auto">
    <v-card-title>
      <h2>Signup</h2>
    </v-card-title>
    <v-divider style="opacity: 1"/>
    <v-card-text>
      <v-form @submit="handleSignup">
        <v-text-field v-model="userData.username" variant="outlined" label="Username"></v-text-field>
        <v-text-field v-model="userData.password" variant="outlined" label="Password" type="password"></v-text-field>
        <div class="tw-flex tw-justify-end">
          <v-btn type="submit" color="primary">Signup</v-btn>
        </div>
      </v-form>
    </v-card-text>
  </v-card>
</template>

<script>
import {mapActions} from 'vuex'

export default {
  data() {
    return {
      userData: {
        username: '',
        password: ''
      }
    }
  },
  methods: {
    ...mapActions('users', ['signup']),
    async handleSignup() {
      try {
        await this.signup(this.userData)
        // Signup successful, user is stored in Vuex
        // Proceed with any necessary logic
      } catch (error) {
        // Handle signup error
        console.error('Signup error:', error)
      }
    }
  }
}
</script>
