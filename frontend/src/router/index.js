import { createRouter, createWebHistory } from 'vue-router'
import BlogList from '@/components/BlogList.vue'
import CreateBlogForm from '@/components/CreateBlogForm.vue'
import EditBlogForm from '@/components/EditBlogForm.vue'
import Login from '@/views/UserLogin.vue'
import Signup from '@/views/UserSignup.vue'
import store from "@/stores/store";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', component: BlogList },
    { path: '/login', component: Login },
    { path: '/register', component: Signup },
    { path: '/create', component: CreateBlogForm },
    { path: '/edit/:id', name: 'edit', component: EditBlogForm }
  ]
})


router.beforeEach((to, from, next) => {
  const isAuthenticated = !!store.state.users.currentUser;
  const isLoginPage = to.path === '/login';
  const isRegisterPage = to.path === '/register';

  if (isAuthenticated && (isLoginPage || isRegisterPage)) {
    next('/');
  } else {
    next();
  }
});
export default router
