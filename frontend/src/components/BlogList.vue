<template>
  <div>
    <v-text-field
      v-model="search"
      label="Search"
      variant="outlined"
      class="search-field"
    ></v-text-field>
    <v-row>
      <v-col v-for="blog in filteredBlogs" :key="blog.id" cols="12" sm="6" md="4" lg="3">
        <v-card>
          <v-img :src="blog.image" height="200"></v-img>
          <v-card-title>{{ blog.title }}</v-card-title>
          <v-card-text>{{ blog.content }}</v-card-text>
          <v-card-actions>
            <v-icon small class="mr-2" @click="editBlog(blog)">mdi-pencil</v-icon>
            <v-icon small @click="removeBlog(blog)">mdi-delete</v-icon>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex'

export default {
  data() {
    return {
      search: ''
    }
  },
  computed: {
    filteredBlogs() {
      return this.blogs.filter((blog) =>
        blog.title.toLowerCase().includes(this.search.toLowerCase())
      )
    },
    ...mapGetters('blogs', ['getAllBlogs']),
    blogs() {
      return this.getAllBlogs
    }
  },

  methods: {
    ...mapActions('blogs', ['deleteBlog']),
    editBlog(blog) {
      this.$router.push({ name: 'edit', params: { id: blog.id } })
    },
    async removeBlog(blog) {
      console.log(await this.deleteBlog(blog.id))
    },
    filterBlogs() {
      // Handle search functionality
    }
  }
}
</script>

<style scoped>
.search-field {
  max-width: 300px;
  margin-bottom: 20px;
  margin-left: auto;
}
</style>
