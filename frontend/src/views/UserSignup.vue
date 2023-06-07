<template>
  <v-card max-width="500" class="tw-m-auto">
    <v-card-title>
      <h2>Signup</h2>
    </v-card-title>
    <v-divider style="opacity: 1" />
    <v-card-text>
      <v-alert variant="outlined" class="tw-mb-4" v-if="error.message" type="error">
        {{ error.message }}
      </v-alert>
      <v-form @submit.prevent="handleSignup">
        <v-text-field
          v-model="userData.name"
          :error-messages="error.errors?.name"
          variant="outlined"
          label="Name"
        ></v-text-field>
        <br />
        <v-text-field
          v-model="userData.email"
          :error-messages="error.errors?.email"
          variant="outlined"
          label="Email"
        ></v-text-field>
        <br />
        <v-text-field
          v-model="userData.password"
          variant="outlined"
          label="Password"
          type="password"
          :error-messages="error.errors?.password"
        ></v-text-field>
        <br />
        <div class="tw-flex tw-justify-end">
          <v-btn type="submit" color="primary">Signup</v-btn>
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
      userData: {
        name: '',
        email: '',
        password: ''
      },
      error: {}
    }
  },
  methods: {
    ...mapActions('users', ['signup']),
    async handleSignup() {
      try {
        await this.signup(this.userData)
        this.$router.push('/login')
      } catch (error) {
        console.log(error.response)
        this.error = error.response.data
      }
    }
  }
}
</script>
