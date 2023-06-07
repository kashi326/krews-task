// axios.js

import axios from 'axios'
console.log(import.meta.env.VITE_API_URL)
const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  timeout: 5000, // Set a default timeout for requests
  withCredentials: true
})

export default api
