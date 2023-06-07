import api from "@/axios";
import store from "@/stores/store";

const blogs = {
    namespaced: true,
    state: {
        blogs: [],
        pagination:{
            total:0,
            next:null,
        }
    },
    getters: {
        getAllBlogs: (state) => state.blogs,
        getBlogById: (state) => (id) => state.blogs.find((blog) => blog.id.toString() === id.toString())
    },
    actions: {
        async fetchAllBlogs({commit}) {
            return api.get('/api/blogs', {
                headers: {
                    "Authorization": `Bearer ${store.getters["users/token"]}`
                }
            })
                .then(response => {
                    const blogs = response.data;
                    commit('setBlogs', blogs.data);
                    commit('setPagination', blogs);
                })
                .catch(error => {
                    console.error('Error fetching blogs:', error);
                });
        },
        async addBlog({commit}, blog) {
            const formData = new FormData();
            formData.append('title', blog.title)
            formData.append('body', blog.body)
            formData.append('image', blog.image[0] || null)
            await api.post('/api/blogs', formData, {
                headers: {
                    "Authorization": `Bearer ${store.getters["users/token"]}`
                }
            })
        },
        async updateBlog({commit}, updatedBlog) {
            const formData = new FormData();
            formData.append('title', updatedBlog.title)
            formData.append('body', updatedBlog.body)
            if (updatedBlog.image?.length){
                formData.append('image',  updatedBlog.image[0])
            }
            await api.post('/api/blogs/'+updatedBlog.id, formData, {
                headers: {
                    "Authorization": `Bearer ${store.getters["users/token"]}`
                }
            })
        },
        deleteBlog({commit, state}, blogId) {
            const index = state.blogs.findIndex((blog) => blog.id.toString() === blogId.toString())
            if (index !== -1) {
                commit('deleteBlog', index)
                return true
            }
            return false
        }
    },
    mutations: {
        setBlogs(state,blogs){
            state.blogs = blogs
        },
        setPagination(state,pagination){
            state.pagination = pagination
        }
    }
}
export default blogs
