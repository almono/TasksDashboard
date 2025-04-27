import { defineStore } from 'pinia';
import api from '../../api.js';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: null
  }),
  actions: {
    async login(credentials) {
      try {
        await api.get('/sanctum/csrf-cookie') // CSRF protection
        const response = await api.post('/api/auth/login', credentials)

        if(response.status === 200) {
          this.token = response.data.accessToken
          api.defaults.headers.common["Authorization"] = `Bearer ${this.token}`
          await this.fetchUser()
        }

        return response
      } catch (err) {
        return err.response
      }
    },

    async register(data) {
      try {
        const response = await api.post('/api/auth/register', { ...data })
        this.user = response.data
        return response
      } catch (err) {
        this.user = null
        return err.response
      }
    },

    async fetchUser() {
      try {
        const response = await api.get('/api/auth/user')
        this.user = response.data
      } catch (err) {
        this.user = null
        return err.response
      }
    },

    async logout() {
      await api.post('/logout')
      this.user = null
      this.token = null

      // Remove token from Axios
      delete axios.defaults.headers.common["Authorization"]
    },
  },
});
