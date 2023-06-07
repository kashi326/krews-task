import { createStore } from 'vuex'
import VuexPersistence from 'vuex-persist'

const vuexLocal = new VuexPersistence({
  storage: window.localStorage,
  modules: ['users']
})
const store = createStore({
  modules: {
    users: {
      namespaced: true,
      state: {
        currentUser: null
      },
      mutations: {
        setUser(state, user) {
          state.currentUser = user
        }
      },
      getters: {
        isAuthenticated: (state) => !!state.currentUser
      },
      actions: {
        login({ commit }, credentials) {
          // Perform login logic here
          // Assuming a successful login returns the user object

          // Simulating a successful login
          console.log('here', credentials)
          const user = { id: 1, username: credentials.username }
          commit('setUser', user)
        },
        signup({ commit }, userData) {
          // Perform signup logic here
          // Assuming a successful signup returns the newly created user object

          // Simulating a successful signup
          const user = { id: 1, username: userData.username }
          commit('setUser', user)
        },
        logout({ commit }) {
          commit('setUser', null)
        }
      }
    },
    blogs: {
      namespaced: true,
      state: {
        blogs: [
          { id: 1, title: 'Blog 1', content: 'Lorem ipsum dolor sit amet.', image: 'blog1.jpg' },
          { id: 2, title: 'Blog 2', content: 'Consectetur adipiscing elit.', image: 'blog2.jpg' }
        ]
      },
      getters: {
        getAllBlogs: (state) => state.blogs,
        getBlogById: (state) => (id) =>
          state.blogs.find((blog) => blog.id.toString() === id.toString())
      },
      actions: {
        addBlog({ commit }, blog) {
          commit('addBlog', blog)
          return true
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
  },
  plugins: [vuexLocal.plugin]
})

export default store
