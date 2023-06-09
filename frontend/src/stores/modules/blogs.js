import api from '@/axios'
import store from '@/stores/store'
import axios from 'axios'

const blogs = {
  namespaced: true,
  state: {
    blogs: [],
    pagination: {
      total: 0,
      currentPage: 1,
      last_page: 1
    },
    cancelToken: null
  },
  getters: {
    getAllBlogs: (state) => state.blogs,
    getBlogById: (state) => (id) =>
      state.blogs.find((blog) => blog.id.toString() === id.toString()),
    getPagination: (state) => state.pagination
  },
  actions: {
    async fetchAllBlogs({ commit, state }, search = '') {
      if (state.cancelToken && state.cancelToken?.cancel) {
        state.cancelToken?.cancel('Request cancelled')
      }

      // Create a new cancel token for the current request
      const cancelToken = axios.CancelToken.source()
      commit('setCancelToken', cancelToken)

      const currentPage = state.pagination.currentPage || 1

      const params = {
        page: search.length > 0 ? 1 : currentPage,
        search: search
      }
      return api
        .get('/api/blogs', {
          headers: {
            Authorization: `Bearer ${store.getters['users/token']}`
          },
          params,
          cancelToken: cancelToken.token
        })
        .then((response) => {
          const blogs = response.data
          commit('setBlogs', blogs.data)
          commit('setPagination', {
            total: blogs.total,
            currentPage: blogs.current_page,
            last_page: blogs.last_page
          })
        })
        .catch(() => {})
    },
    async addBlog({ commit }, blog) {
      const formData = new FormData()
      formData.append('title', blog.title)
      formData.append('body', blog.body)
      if (blog.image) {
        formData.append('image', blog.image[0] || null)
      }
      await api.post('/api/blogs', formData, {
        headers: {
          Authorization: `Bearer ${store.getters['users/token']}`
        }
      })
    },
    async updateBlog({ commit }, updatedBlog) {
      const formData = new FormData()
      formData.append('title', updatedBlog.title)
      formData.append('body', updatedBlog.body)
      if (updatedBlog.image?.length) {
        formData.append('image', updatedBlog.image[0])
      }
      await api.post('/api/blogs/' + updatedBlog.id, formData, {
        headers: {
          Authorization: `Bearer ${store.getters['users/token']}`
        }
      })
    },
    async deleteBlog({ commit }, blogId) {
      await api.delete('/api/blogs/' + blogId, {
        headers: {
          Authorization: `Bearer ${store.getters['users/token']}`
        }
      })
    },
    updateCurrentPage({ commit, state }, currentPage) {
      commit('setPagination', {
        ...state.pagination,
        currentPage
      })
    },
    async likeBlog({ commit, state }, blogId) {
      const blogs = state.blogs.map((blog) => {
        if (blog.id.toString() === blogId.toString()) {
          blog.liked = !blog.liked
        }
        return blog
      })
      commit('setBlogs', blogs)
      await api.post(
        '/api/blogs/' + blogId + '/like',
        {},
        {
          headers: {
            Authorization: `Bearer ${store.getters['users/token']}`
          }
        }
      )
    }
  },
  mutations: {
    setBlogs(state, blogs) {
      state.blogs = blogs
    },
    setPagination(state, pagination) {
      state.pagination = pagination
    },
    setCancelToken(state, cancelToken) {
      state.cancelToken = cancelToken
    }
  }
}
export default blogs
