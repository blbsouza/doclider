<script>
import AppAlert from './AppAlert.vue'
import { useAppStore } from '@/stores/app'
import axios from 'axios'
export default {
  components: { AppAlert },
  data() {
    return {
      dialog: false,
      rml: '',
      dsc: '',
      typ: false,
      store: useAppStore(),
      sizeLengthDsc: [
        v => !!v || 'Precisa preencher a descrição',
        v => (v && v.length <= 50) || 'Máximo de 50 caracteres atingido...'
      ]
    }
  },
  methods: {
    open(obj) {
      this.rml = obj.rml
      this.dsc = obj.dsc
      this.typ = obj.typ == 1 ? false : true

      this.dialog = true
    },
    async saveAdd() {
      if (!this.dsc) {
        this.$refs.toast.show({t: 1, m: "Preencha o campo descrição..."})
      } else {
        let tipo = this.typ ? 2 : 1
        await axios.get(this.store.url+'update.php?rml='+this.rml+'&dsc='+this.dsc+'&typ='+tipo)
        .then(() => {
          this.$refs.toast.show({m: "Atualizado com sucesso!"})
          this.dialog = false
          this.store.refresh = true
        })
        .catch(e => this.$refs.toast.show({t: 2, m:"ERRO: Não foi possível salvar no momento. ERROR: "+e}))
      }
    }
  }
}
</script>

<template>
  <app-alert ref="toast" />
  <v-dialog
    transition="dialog-bottom-transition"
    max-width="600"
    v-model="dialog"
  >
    <v-card>
      <v-toolbar
        color="deep-orange"
        flat
        density="compact"
      >
        <v-card-title>EDITAR RAMAL {{ rml }}</v-card-title>
      </v-toolbar>
      <v-card-text class="pt-2">
        <v-text-field
          v-model="rml"
          label="Ramal"
          placeholder="Digite o número do ramal (ex.: 7815)"
          type="number"
          color="deep-orange"
          :counter="15"
          clearable
          variant="outlined"
          disabled
        />
        <v-text-field
          v-model="dsc"
          label="Descrição"
          placeholder="Digite a descrição do ramal (ex.: CPD)"
          color="deep-orange"
          :counter="50"
          clearable
          variant="outlined"
          :rules="sizeLengthDsc"
        />
        <v-switch
          v-model="typ"
          :label="`Tipo: Ramal ${typ ? 'Móvel' : 'Fixo'}`"
          color="deep-orange"
        ></v-switch>
        <v-btn
          class="bg-success"
          @click="saveAdd()"
        >SALVAR</v-btn>
      </v-card-text>
      <v-card-actions class="justify-end">
        <v-btn
          variant="text"
          @click="dialog = false"
        >FECHAR</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>