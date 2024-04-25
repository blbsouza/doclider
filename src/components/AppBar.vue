<script setup>
import { useAppStore } from '@/stores/app'
import AppInfo from '@/components/AppInfo'
//
const store = useAppStore()
</script>

<template>
  <v-app-bar
    density="compact"
    class="bg-white"
  >
    <img
      src="https://firebasestorage.googleapis.com/v0/b/web-app-6280e.appspot.com/o/svg%2Fdoclider.svg?alt=media&token=f2697580-8bf4-44cd-ba93-92de33c1515b"
      :width="30"
      :height="40"
      class="ml-1"
    />
    <v-app-bar-title class="font-weight-bold text-indigo-lighten-4 ml-1">DOC<span class="text-indigo">LÍDER</span></v-app-bar-title>
    <v-spacer />
    <ProdInfo :json="store.json" />
    <AppInfo />
    <v-divider vertical />
    <div class="px-1 d-flex align-center">
      <v-img
        :src="store.json?.myLogo"
        :height="35"
        :width="35"
        class="mx-5"
      />
      <p v-if="store.json?.doclider?.version === undefined || store.json?.doclider?.version === store.version" class="text-caption text-blue-grey-lighten-3">blbtech &copy; All<br>rights reserved</p>
      <p v-else class="text-success text-caption text-center" style="line-height: 0.8rem;"><v-icon>mdi-update</v-icon>Há uma<br>atualização<br>disponível({{ store.json?.doclider?.version }})</p>
    </div>
  </v-app-bar>
</template>