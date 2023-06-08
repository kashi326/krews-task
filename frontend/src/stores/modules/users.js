import api from '@/axios'
import store from '@/stores/store'

const users = {
  namespaced: true,
  state: {
    currentUser: null,
    loading: false
  },
  mutations: {
    setUser(state, user) {
      state.currentUser = user
    },

    setLoading(state, loading) {
      state.loading = loading
    }
  },
  getters: {
    isAuthenticated: (state) => !!state.currentUser,
    token: (state) => state.currentUser?.access_token||null
  },
  actions: {
    async login({ commit }, credentials) {
      // const response =  await axios.post('')
      commit('setLoading', true)
      try {
        const response = await api.post('/api/login', credentials)
        const user = response.data
        commit('setUser', user)
        commit('setLoading', false)
      } catch (error) {
        commit('setLoading', false)
        throw error
      }
      // Simulating a successful login
    },
    async signup({ commit }, userData) {
      commit('setLoading', true)
      try {
        const response = await api.post('/api/register', userData)
        const user = response.data
        commit('setUser', user)
        commit('setLoading', false)
      } catch (error) {
        commit('setLoading', false)
        throw error
      }
    },
    async logout({ commit }) {
      commit('setLoading', true)
      try {
        await api.post(
          '/api/logout',
          {},
          {
            headers: {
              Authorization: `Bearer ${store.getters['users/token']}`
            }
          }
        )
        commit('setUser', null)
      } finally {
        commit('setLoading', false)
      }
    }
  }
}
export default users
