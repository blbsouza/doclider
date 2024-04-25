<script setup>
import { useAppStore } from '@/stores/app'
//
const store = useAppStore()
</script>

<template>
  <v-row
    dense
    class="ma-0 align-center justify-space-between w-100"
    style="border-bottom: 0.5px solid rgba(255,255,255,0.3)"
  >
    <v-col
      cols="12"
      :md="store.expand ? 12 : 6"
      sm="12"
      class="pa-0 px-2"
    >
      <v-toolbar-title
        class="text-overline"
        :class="store.expand ? 'text-center' : 'text-sm-center text-md-left'"
      >RELATÓRIOS</v-toolbar-title>
    </v-col>
    <v-col
      cols="12"
      :md="store.expand ? 12 : 3"
      sm="12"
      class="d-flex justify-sm-center justify-md-end"
    >
      <v-text-field
        placeholder="Pesquisar Relatório..."
        density="compact"
        color="indigo"
        variant="outlined"
        :prepend-inner-icon="!store.expand ? 'mdi-magnify' : null"
        clearable
        hide-details
        @click:clear="store.refresh = true"
        v-model="store.search"
        :class="store.expand ? 'text-caption' : null"
      />
    </v-col>
  </v-row>
</template>