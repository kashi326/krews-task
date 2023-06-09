<template>
  <div class="blog-view">
    <div class="blog-header">
      <div class="go-back">
        <v-btn icon @click="goBack">
          <v-icon>mdi-arrow-left</v-icon>
        </v-btn>
      </div>
      <h1 class="blog-title">{{ blog.title }}</h1>
      <div class="blog-meta">
        <span class="blog-date">{{ formatDate(blog.created_at) }}</span>
      </div>
    </div>
    <div class="blog-content">
      <img :src="blog.image_link" alt="Blog Image" class="!tw-min-h-[600px] blog-image" />
      <div class="blog-body">
        {{ blog.body }}
      </div>
    </div>
  </div>
</template>

<script>
import { formatDate } from '@/utils/utils'
import { mapGetters } from 'vuex'

export default {
  methods: {
    formatDate,
    goBack() {
      this.$router.go(-1)
    }
  },
  data() {
    return {
      blogData: {}
    }
  },
  computed: {
    ...mapGetters('blogs', ['getBlogById']),
    blog() {
      const blogId = this.$route.params.id
      this.blogData = this.getBlogById(blogId)
      return this.blogData
    }
  }
}
</script>

<style scoped>
.blog-view {
  max-width: 1280px;
  margin: 0 auto;
  padding: 20px;
}

.blog-header {
  margin-bottom: 20px;
}

.blog-title {
  font-size: 28px;
  font-weight: bold;
  margin: 0;
}

.blog-meta {
  color: #999;
  font-size: 14px;
}

.blog-date {
  margin-left: 10px;
}

.blog-content {
  background-color: #f7f7f7;
  padding: 20px;
}

.blog-image {
  width: 100%;
  max-height: 400px;
  object-fit: cover;
  margin-bottom: 20px;
}

.blog-body {
  line-height: 1.6;
  white-space: pre-line;
}
</style>
