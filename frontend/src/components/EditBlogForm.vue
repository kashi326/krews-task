<template>
  <div>
    <v-card>
      <v-card-title>
        <h2>Edit Blog</h2>
      </v-card-title>
      <v-card-text>
        <v-text-field v-model="blogData.title" label="Title" outlined dense></v-text-field>
        <v-textarea v-model="blogData.body" label="Content" outlined dense></v-textarea>
        <v-file-input
          :multiple="false"
          :clearable="false"
          label="Image"
          outlined
          dense
          v-model="blogData.image"
        ></v-file-input>
      </v-card-text>
      <v-card-actions>
        <v-btn @click="saveBlog" :loading="loading" color="primary">Save</v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'

export default {
  data() {
    return {
      blogData: {},
      loading:false
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
    ...mapActions('blogs',['updateBlog']),
    async saveBlog() {
      this.loading = true
      try {
        // Handle save functionality
        await this.updateBlog(this.blog)
        this.loading = false
        this.$router.push('/')
      } catch (error) {
        console.log(error)
        this.error = error.response.data
      } finally {
        this.loading = false
      }
    }
  },
  mounted() {
    this.blog
  }
}
</script>

<style scoped>
.v-text-field--outlined .v-input__control {
  height: 32px;
}
</style>
