import { defineStore } from 'pinia'
import api from '../../api.js';

export const useSettingsStore = defineStore('settings', {
  state: () => ({
    settings: null,
  }),
  actions: {
    async getApplicationSettings() {
      try {
        const response = await api.get('/api/settings')
        this.settings = response.data
      } catch (error) {
        console.error('Failed to load settings: ', error)
      }
    }
  }
})