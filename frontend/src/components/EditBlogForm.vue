<template>
  <div>
    <v-card>
      <v-card-title>
        <h2>Edit Blog</h2>
      </v-card-title>
      <v-divider style="opacity: 1" />
      <v-card-text>
        <v-alert variant="outlined" class="tw-mb-4" v-if="error.message" type="error">
          {{ error.message }}
        </v-alert>
        <v-text-field
          v-model="blogData.title"
          :error-messages="error.errors?.title"
          label="Title"
          outlined
          dense
        ></v-text-field>
        <br />
        <v-textarea
          v-model="blogData.body"
          :error-messages="error.errors?.body"
          label="Blog Body"
          outlined
          dense
        ></v-textarea>
        <br />
        <v-file-input
          :multiple="false"
          :clearable="false"
          label="Image"
          outlined
          dense
          v-model="blogData.image"
          :error-messages="error.errors?.image"
        ></v-file-input>
      </v-card-text>
      <v-card-actions>
        <v-btn @click="saveBlog" :loading="loading" color="primary">Save</v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  data() {
    return {
      blogData: {},
      loading: false,
      error: {}
    }
  },
  computed: {
    ...mapGetters('blogs', ['getBlogById']),
    blog() {
      const blogId = this.$route.params.id
      const data = this.getBlogById(blogId)
      this.blogData = data
      return this.blogData
    }
  },
  methods: {
    ...mapActions('blogs', ['updateBlog']),
    async saveBlog() {
      this.loading = true
      try {
        // Handle save functionality
        await this.updateBlog(this.blog)
        this.loading = false
        this.$router.push('/')
      } catch (error) {
        this.error = error.response.data
      } finally {
        this.loading = false
      }
    }
  },
  mounted() {
    const data = this.blog
    if (!data) {
      //if no blog is found redirect to all blogs
      this.$router.push('/')
    }
  }
}
</script>

<style scoped>
.v-text-field--outlined .v-input__control {
  height: 32px;
}
</style>
