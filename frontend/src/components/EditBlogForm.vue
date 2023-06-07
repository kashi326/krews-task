<template>
  <div>
    <v-card>
      <v-card-title>
        <h2>Edit Blog</h2>
      </v-card-title>
      <v-card-text>
        <v-text-field v-model="blogData.title" label="Title" outlined dense></v-text-field>
        <v-textarea v-model="blogData.content" label="Content" outlined dense></v-textarea>
        <v-file-input
          :multiple="false"
          :clearable="false"
          label="Image"
          outlined
          dense
        ></v-file-input>
      </v-card-text>
      <v-card-actions>
        <v-btn @click="saveBlog" color="primary">Save</v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  data() {
    return {
      blogData: {}
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
    saveBlog() {
      console.log(this.blogData)
      // Handle save functionality
      console.log('Save blog:', this.blogData)
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
