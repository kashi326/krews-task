<template>
  <div>
    <v-text-field
      v-model="search"
      label="Search"
      variant="outlined"
      class="search-field"
    ></v-text-field>
    <v-alert
      variant="outlined"
      class="tw-mb-4"
      v-if="message.length > 0"
      type="success"
      closable="true"
    >
      {{ message }}
    </v-alert>
    <v-alert
      variant="outlined"
      class="tw-mb-4"
      v-if="error.length > 0"
      type="error"
      closable="true"
    >
      {{ error }}
    </v-alert>
    <div v-if="blogs.length > 0">
      <v-row>
        <v-col v-for="blog in blogs" :key="blog.id" cols="12" sm="6" md="4">
          <v-card>
            <v-img :src="blog.image_link" height="200"></v-img>
            <router-link :to="'/view/' + blog.id">
              <v-card-title class="tw-text-blue-400">{{ blog.title }}</v-card-title>
            </router-link>
            <v-card-text class="tw-min-h-[80px] !tw-py-2">{{
              blog.body.slice(0, 150)
            }}</v-card-text>
            <v-card-actions class="!tw-justify-between">
              <p>{{ formatDate(blog.created_at) }}</p>
              <div v-if="blog.owned">
                <v-icon small class="mr-2 !tw-text-green-500" @click="editBlog(blog)"
                  >mdi-pencil</v-icon
                >
                <v-icon small class="!tw-text-red-500" @click="removeBlog(blog)">mdi-delete</v-icon>
              </div>
              <v-btn
                icon
                style="position: absolute; top: 0px; right: 10px"
                @click="likeBlogAction(blog.id)"
              >
                <v-icon small :class="blog.liked && '!tw-text-red-500'">mdi-heart</v-icon>
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </div>
    <div v-else class="no-blogs">
      <i class="mdi mdi-alert-circle-outline"></i>
      <p>No blogs found.</p>
    </div>
    <br />
    <div class="tw-flex tw-justify-end" v-if="blogs.length > 0">
      <v-pagination
        v-model="pagination.currentPage"
        :length="Math.floor(pagination.total / 15) + 1"
        variant="outlined"
        rounded="circle"
        @update:model-value="onPageChange"
        total-visible="7"
      ></v-pagination>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import { formatDate } from '@/utils/utils'

export default {
  computed: {
    ...mapGetters('blogs', ['getAllBlogs', 'getPagination']),
    blogs() {
      return this.getAllBlogs
    },
    pagination() {
      return this.getPagination
    }
  },
  data() {
    return {
      search: '',
      message: '',
      error: ''
    }
  },
  created() {
    this.fetchAllBlogs()
  },
  methods: {
    formatDate,
    ...mapActions('blogs', ['deleteBlog', 'fetchAllBlogs', 'updateCurrentPage', 'likeBlog']),
    onPageChange(newPage) {
      this.pagination.currentPage = newPage
      this.updateCurrentPage(newPage)
      this.fetchAllBlogs()
    },
    editBlog(blog) {
      this.$router.push({ name: 'edit', params: { id: blog.id } })
    },
    async removeBlog(blog) {
      if (confirm('Are you sure you want to delete this blog?')) {
        try {
          await this.deleteBlog(blog.id)
          this.message = 'Blog deleted successfully'
          await this.fetchAllBlogs(this.search)
        } catch (e) {
          this.error = 'Something went wrong'
        }
      }
    },
    likeBlogAction(blogId) {
      this.likeBlog(blogId)
    }
  },
  watch: {
    search(newValue) {
      this.fetchAllBlogs(newValue)
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
.no-blogs {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  padding: 20px;
  text-align: center;
  color: #999;
  font-size: 2em;
}

.no-blogs i {
  color: rgba(204, 11, 11, 0.59);
  margin-bottom: 10px;
}
</style>
