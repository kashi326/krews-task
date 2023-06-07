import api from "@/axios";
import store from "@/stores/store";

const blogs = {
  namespaced: true,
  state: {
    blogs: [
      { id: 1, title: 'Blog 1', content: 'Lorem ipsum dolor sit amet.', image: 'blog1.jpg' },
      { id: 2, title: 'Blog 2', content: 'Consectetur adipiscing elit.', image: 'blog2.jpg' }
    ]
  },
  getters: {
    getAllBlogs: (state) => state.blogs,
    getBlogById: (state) => (id) => state.blogs.find((blog) => blog.id.toString() === id.toString())
  },
  actions: {
    async addBlog({ commit }, blog) {
      const formData = new FormData();
      formData.append('title',blog.title)
      formData.append('body',blog.body)
      formData.append('image',blog.image[0]||null)
      await api.post('/api/blog/create',formData,{
        headers:{
          "Authorization":`Bearer ${store.getters["users/token"]}`
        }
      })
      commit('addBlog', blog)
    },
    updateBlog({ commit, state }, updatedBlog) {
      const index = state.blogs.findIndex((blog) => blog.id === updatedBlog.id)
      if (index !== -1) {
        commit('updateBlog', { index, updatedBlog })
        return true
      }
      return false
    },
    deleteBlog({ commit, state }, blogId) {
      const index = state.blogs.findIndex((blog) => blog.id.toString() === blogId.toString())
      if (index !== -1) {
        commit('deleteBlog', index)
        return true
      }
      return false
    }
  },
  mutations: {
    addBlog(state, blog) {
      state.blogs.push(blog)
    },
    updateBlog(state, { index, updatedBlog }) {
      state.blogs.splice(index, 1, updatedBlog)
    },
    deleteBlog(state, index) {
      state.blogs.splice(index, 1)
    }
  }
}
export default blogs
