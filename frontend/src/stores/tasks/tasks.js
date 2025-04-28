import { defineStore } from 'pinia'
import api from '../../api.js';

export const useTasksStore = defineStore('tasks', {
  state: () => ({
    tasks: null,
  }),
  actions: {
    async getTasksList(filters = {}) {
      try {
        const response = await api.get('/api/tasks', { params: filters })
        this.tasks = response.data
      } catch (error) {
        console.error('Failed to load tasks: ', error)
      }
    },
    async updateTaskOrder(taskList) {
      this.tasks = taskList
    },
    async createTask() {
      try {
        const response = await api.get('/api/settings')
        this.settings = response.data
      } catch (error) {
        console.error('Failed to load settings: ', error)
      }
    },
    async editTask() {
      try {
        const response = await api.get('/api/settings')
        this.settings = response.data
      } catch (error) {
        console.error('Failed to load settings: ', error)
      }
    },
    async deleteTask() {
      try {
        const response = await api.get('/api/settings')
        this.settings = response.data
      } catch (error) {
        console.error('Failed to load settings: ', error)
      }
    },
    async updateTasksOrder() {
      try {
        const response = await api.get('/api/settings')
        this.settings = response.data
      } catch (error) {
        console.error('Failed to load settings: ', error)
      }
    },
  }
})