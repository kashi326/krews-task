import { createStore } from 'vuex'
import VuexPersistence from 'vuex-persist'
import users from '@/stores/modules/users'
import blogs from '@/stores/modules/blogs'

const vuexLocal = new VuexPersistence({
  storage: window.localStorage,
  modules: ['users', 'blogs']
})
const store = createStore({
  modules: {
    users: users,
    blogs: blogs
  },
  plugins: [vuexLocal.plugin]
})

export default store
