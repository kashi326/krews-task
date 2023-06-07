<template>
  <v-card max-width="500" class="tw-m-auto">
    <v-card-title>
      <h2>Login</h2>
    </v-card-title>
    <v-divider style="opacity: 1" />
    <v-card-text>
      <v-alert variant="outlined" class="tw-mb-4" v-if="error.message" type="error">
        {{ error.message }}
      </v-alert>
      <v-form @submit.prevent="handleLogin">
        <v-text-field
          v-model="credentials.email"
          :error-messages="error.errors?.email"
          variant="outlined"
          label="Email"
        ></v-text-field>
        <br />
        <v-text-field
          v-model="credentials.password"
          :error-messages="error.errors?.password"
          variant="outlined"
          label="Password"
          type="password"
        ></v-text-field>
        <div class="tw-flex tw-justify-end">
          <v-btn type="submit" color="primary">Login</v-btn>
        </div>
      </v-form>
    </v-card-text>
  </v-card>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  data() {
    return {
      credentials: {
        email: '',
        password: ''
      },
      error: {}
    }
  },
  methods: {
    ...mapActions('users', ['login']),
    ...mapGetters('users', ['getError']),
    async handleLogin() {
      try {
        await this.login(this.credentials)
        window.location.href = '/'
      } catch (error) {
        this.error = error.response.data
      }
    }
  }
}
</script>
