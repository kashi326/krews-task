import { createRouter, createWebHistory } from 'vue-router'
import BlogList from '@/components/BlogList.vue'
import CreateBlogForm from '@/components/CreateBlogForm.vue'
import EditBlogForm from '@/components/EditBlogForm.vue'
import Login from '@/views/UserLogin.vue'
import Signup from '@/views/UserSignup.vue'
import store from '@/stores/store'
import ViewBlog from '@/components/ViewBlog.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', component: BlogList , meta: { requiresAuth: true } },
    { path: '/login', component: Login },
    { path: '/register', component: Signup },
    { path: '/create', component: CreateBlogForm, meta: { requiresAuth: true } },
    { path: '/edit/:id', name: 'edit', component: EditBlogForm, meta: { requiresAuth: true } },
    { path: '/view/:id', name: 'view', component: ViewBlog , meta: { requiresAuth: true } }
  ]
})

router.beforeEach((to, from, next) => {
  const isAuthenticated = !!store.state.users.currentUser
  const isLoginPage = to.path === '/login'
  const isRegisterPage = to.path === '/register'

  if (isAuthenticated && (isLoginPage || isRegisterPage)) {
    next('/')
  } else {
    next()
  }
})
router.beforeEach((to, from, next) => {
  const isAuthenticated = !!store.state.users.currentUser
  const requiresAuth = to.matched.some((record) => record.meta.requiresAuth)

  if (requiresAuth && !isAuthenticated) {
    next('/login')
  } else {
    // Proceed to the next route
    next()
  }
})

export default router
