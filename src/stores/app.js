// Utilities
import { defineStore } from 'pinia'

export const useAppStore = defineStore('app', {
  state: () => ({
    //
    url: "https://srvsave158/Brdoc/php/",
    urlRel: "https://srvsave158/Brdoc/",
    prod: false,
    json: {},
    expand: false,
    initialLoading: true,
    refresh: false,
    search: null,
    version: 7.0
  })
})
