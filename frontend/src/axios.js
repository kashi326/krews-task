// axios.js

import axios from 'axios'
import store from '@/stores/store'
console.log(import.meta.env.VITE_API_URL)
const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  withCredentials: true
})
api.interceptors.response.use(
  (response) => {
    return response
  },
  (error) => {
    // Handle response errors
    if (error.response.status === 401) {
      store.commit('users/setUser', null)
      window.location.href = '/login'
    }
    return Promise.reject(error)
  }
)

export default api
