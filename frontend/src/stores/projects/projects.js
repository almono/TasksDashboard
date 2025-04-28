import { defineStore } from 'pinia'
import api from '../../api.js';

export const useProjectsStore = defineStore('projects', {
  state: () => ({
    projectsList: null,
  }),
  actions: {
    async getProjectsList() {
      try {
        const response = await api.get('/api/projects')
        this.projectsList = response.data
      } catch (error) {
        console.error('Failed to load projects: ', error)
      }
    }
  }
})