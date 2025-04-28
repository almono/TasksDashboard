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
    async createTask(data) {
      try {
        const response = await api.post('/api/tasks', data)
      } catch (error) {
        console.error('Failed to create task: ', error)
      }
    },
    async updateTask(taskId, updatedTask) {
      try {
        const response = await api.patch(`/api/tasks/${taskId}`, updatedTask)
      } catch (error) {
        console.error('Failed to edit task: ', error)
      }
    },
    async deleteTask(taskId) {
      try {
        const response = await api.delete(`/api/tasks/${taskId}`)
      } catch (error) {
        console.error('Failed to delete task: ', error)
      }
    }
  }
})