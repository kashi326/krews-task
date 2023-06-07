<template>
  <div>
    <v-card>
      <v-card-title class="tw-p-4">
        <h2>Create Blog</h2>
      </v-card-title>
      <v-divider style="opacity: 1"/>
      <v-card-text>
        <v-text-field v-model="blog.title" label="Title" variant="outlined" dense></v-text-field>
        <v-textarea v-model="blog.content" label="Content" variant="outlined" dense></v-textarea>
        <v-file-input
            :multiple="false"
            :clearable="false"
            label="Image"
            v-model="blog.image"
            variant="outlined"
            dense
            accept="image/*"
        ></v-file-input>
        <template v-if="previewLink !== null">
          <p class="px-5 mb-2">Image Preview</p>
          <v-img :src="previewLink" width="200" height="200"/>
        </template>
      </v-card-text>
      <v-card-actions>
        <v-btn @click="saveBlog" :loading="loading" color="primary">Save</v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
import {mapActions} from 'vuex'
import {useCreateBlob} from '@/composition/file-conversion'

export default {
  data() {
    return {
      loading: false,
      blog: {
        title: '',
        content: '',
        image: null
      },
      previewLink: null,
      error: {}
    }
  },
  methods: {
    ...mapActions('blogs', ['addBlog']),
    async saveBlog() {
      this.loading = true
      try {
        // Handle save functionality
        const response = await this.addBlog(this.blog)
        if (response) {
          this.loading = false
          this.$router.push('/')
        }
      } catch (error) {
        this.error = error.response.data
      } finally {
        this.loading = false
      }
    }
  },
  watch: {
    'blog.image': {
      handler(newVal) {
        console.log('blog.image changed:', newVal)
        const {url} = useCreateBlob(newVal[0])
        this.previewLink = url
      },
      deep: true // Enable deep watching for nested properties
    }
  }
}
</script>

<style scoped>
.v-text-field--outlined .v-input__control {
  height: 32px;
}
</style>
