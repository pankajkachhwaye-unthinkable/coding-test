import { defineStore } from 'pinia'

export const useDashboardStore = defineStore('dashboard', {
  state: () => {
    return { 
        week_count:0,
        month_count:0,
        pending_count:0,
        users:[],
    }
  },
  actions: {
   
  },
})