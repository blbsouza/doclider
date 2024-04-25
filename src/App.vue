<script setup>
import { useAppStore } from '@/stores/app'
import axios from 'axios'
import { ref, watch } from 'vue'
import { storeToRefs } from 'pinia'
//
const store = useAppStore()
const relatorios = ref([])
const title = ref('')
const lido = ref('')
const ca = ref(0)
const trow = ref(0)
const tcol = ref(0)
const letterf = ref(0)
const altf = ref(11)
const sizef = ref(11)
const fontf = ref('Consolas')
const sizes = [
  { size: 8 },
  { size: 9 },
  { size: 10 },
  { size: 11 },
  { size: 12 },
  { size: 13 },
  { size: 14 },
  { size: 15 },
  { size: 16 },
  { size: 17 },
  { size: 18 },
  { size: 19 },
  { size: 20 }
]
const fonts = [
  { font: 'Consolas' },
  { font: 'Courier New' },
  { font: 'Lucida Console' },
  { font: 'MingLiU-ExtB' },
  { font: 'MS Gothic' },
  { font: 'SimSun' }
]
const { search } = storeToRefs(store)
//
const getRelatorios = async (v) => {
  await axios.get(store.url+`${v ? 'load_docs.php?search='+v : 'load_docs.php'}`)
    .then(r => {
      relatorios.value = r.data
    })
}

const changedRelat = async ( t, a ) => {
  title.value = t
  await axios.get(store.url+"pre_visu.php?arq="+a)
    .then(r => {
      lido.value = r.data
      textareaFormat()
    })
    .catch(() => lido.value = "ERRO")
}

const textareaFormat = () => {
  ca.value = (lido.value).length;
  let arr = (lido.value).split("\n"); // array
  trow.value = arr.length - 1; // numero de linhas
  
  let co = 0;
  for (var i = 0; i < trow.value; i++) {
    var item = arr[i].length;
    if ( item > co ) {
      co = item;
    }
  }

  tcol.value = co
}

const openPdf = (a) => {
  window.open(store.urlRel+"relatorios/"+a)
}

const btnOp = (i) => {
  let d, t
  d = document.querySelector("#"+i).checked;
  t = document.querySelector("#textarea");

  if ( d ) {
    switch ( i ) {
      case 'estilo1' : t.style.fontWeight = 'bold';         break;
      case 'estilo2' : t.style.fontStyle = 'italic';        break;
      case 'estilo3' : t.style.textDecoration = 'underline';break;
      case 'align1'  : t.style.textAlign = 'left';          break;
      case 'align2'  : t.style.textAlign = 'center';        break;
      case 'align3'  : t.style.textAlign = 'right';         break;
    }
  } else {
    switch ( i ) {
      case 'estilo1' : t.style.fontWeight = 'normal';       break;
      case 'estilo2' : t.style.fontStyle = 'normal';        break;
      case 'estilo3' : t.style.textDecoration = 'none';     break;
    }
  }
}

const fontOp = (v, n) => {
  if ( n == 1 ) {
    document.querySelector("#textarea").style.fontFamily = v
  } else {
    document.querySelector("#textarea").style.fontSize = `${v}px`;
    altf.value = sizef.value;
    altOp()
  }
}

const altOp = () => {
  document.querySelector("#textarea").style.lineHeight = `${altf.value}px`
}

const letterOp = () => {
  document.querySelector("#textarea").style.letterSpacing = `${letterf.value}px`
}
    //IMPRESSÃO RELAT
const print = () => {
  let t, weight, style, decora, family, size, align, line, ls, tela_impressao

  t = document.querySelector("#textarea");
  //
  weight = t.style.fontWeight;
  style = t.style.fontStyle;
  decora = t.style.textDecoration;
  family = t.style.fontFamily;
  size = t.style.fontSize;
  align = t.style.textAlign;
  line = t.style.lineHeight;
  ls = t.style.letterSpacing;

  tela_impressao = window.open("about:blank");

  tela_impressao.document.write(`<pre style='font-size:${size};font-weight:${weight};font-style:${style};text-decoration:${decora};font-family:${family};text-align:${align};line-height:${line};letter-spacing: ${ls}'>${lido.value}</pre>`);

  tela_impressao.window.print();
  tela_impressao.window.close();
}
// watchers
watch(lido, () => {
  ca.value = (lido.value).length
  //
  let arr = (lido.value).split("\n"); // array
  trow.value = arr.length - 1; // numero de linhas
  //
  let co = 0;
  let arr2 = (lido.value).split("\n"); // array
  for (var i = 0; i < trow.value; i++) {
    var item = arr2[i].length;
    if ( item > co ) {
      co = item;
    }
  }

  tcol.value = co
})

watch(search, () => {
  getRelatorios(store.search)
})

const getJson = async () => {
  await axios.get('https://cdn.statically.io/gh/blbsouza/cdn/main/json/web-app.json')
    .then(r => {
      store.json = r.data
      getRelatorios()
      setTimeout(() => {
        store.initialLoading = false
      },2000)
    })
}

getJson()
</script>

<style>
@import './styles/style.css';
</style>

<template>
  <v-app class="overflow-auto h-screen">
    <app-bar v-if="!store.initialLoading" />
    <home-loading />
    <v-main class="bg-indigo-lighten-3 overflow-hidden">
      <v-row
        class="main-border mt-2 mx-2 mb-0 flex-sm-column flex-md-row overflow-auto bg-indigo-lighten-4"
        v-if="!store.initialLoading"
      >
        <v-col
          class="d-flex flex-column h-p pa-0"
          cols="12"
          :md="store.expand ? 3 : 12"
          sm="12"
        >
          <toolbar-view />
          <!-- relat box -->
          <v-row class="justify-start align-start ma-0 pa-1 h-100 overflow-y-auto" v-if="relatorios.length > 0">
            <label
              class="rounded-lg"
              :class="`${store.expand ? 'mx-1 my-1 flex-grow-1' : 'my-2 mx-auto'}`"
              v-for="v in relatorios"
              :key="v.tit"
              style="position: relative"
            >
              <input
                type="radio"
                name="btnchange"
                class="btnchange"
                @change="v.tipo!='pdf' ? changedRelat(v.title, v.arquivo) : openPdf(v.arquivo)"
                @click="v.tipo!='pdf' ? store.expand = true : null"
              />
              <div
                class="rounded-lg box"
                :style="`width: ${store.expand ? '70px' : '200px'};height: 100%`"
              >
                <v-col
                  class="py-1 text-center"
                >
                  <p
                    id="pbox-1"
                    class="ma-0 text-caption text-center"
                  >{{v.tit}}</p>
                  <v-icon class="ma-1">mdi-{{ v.tipo == "pdf" ? "file-pdf-box" : "file-document"}}</v-icon>
                  <p
                    v-if="!store.expand"
                    class="text-caption text-center mt-1"
                    style="line-height: 1em"
                  >{{v.title}}</p>
                </v-col>
              </div>
            </label>
          </v-row>
          <v-row
            v-else
            class="justify-center align-center ma-0 pa-1 h-100"
          >
            <p class="text-body-1">Nenhum relatório encontrado...</p>
          </v-row>
        </v-col>

        <!-- divisão -->
        <v-divider v-if="store.expand" vertical />

        <v-col
          class="d-flex flex-column h-p pa-0"
          v-if="store.expand"
          cols="12"
          :md="store.expand ? 9 : 12"
          sm="12"
        >
          <!-- title box -->
          <v-row
            class="ma-0"
          >
            <p class="pa-0 my-0 text-body-2 flex-grow-1 text-center" v-if="store.expand">{{title}}</p>
            <v-btn
              size="small"
              density="compact"
              icon
              @click="store.expand = false"
              color="rgba(0, 0, 0, 0.1)"
              class="ma-1"
              flat
            >
              <v-icon size="small">mdi-close</v-icon>
            </v-btn>
          </v-row>
          <!-- commands box -->
          <v-row
            class="ma-0 pt-1 pb-3 px-2 justify-space-between"
            style="border-bottom: 1px solid rgba(255,255,255,0.5)"
          >
            <label
              v-for="(v, i) in ['bold', 'italic', 'underline']"
              :key="v"
            >
              <input
                type="checkbox"
                class="checkbox"
                :id="`estilo${i+1}`"
                @click="btnOp('estilo'+(i+1))"
              >
              <div>
                <div class="btn">
                  <v-icon
                    size="small"
                  >mdi-format-{{v}}</v-icon>
                </div>
              </div>
            </label>

            <label
              v-for="(v, i) in ['left', 'center', 'right']"
              :key="i"
            >
              <input
                type="radio"
                class="checkbox"
                name="align"
                :id="`align${i+1}`"
                @click="btnOp('align'+(i+1))"
              >
              <div>
                <div class="btn">
                  <v-icon size="small">mdi-format-align-{{v}}</v-icon>
                </div>
              </div>
            </label>

            <v-select
              class="rounded-0 text-caption ma-0"
              style="max-width: 110px"
              prepend-inner-icon="mdi-format-font"
              hide-details
              title="Família da fonte"
              :items="fonts"
              item-title="font"
              item-color="#3F51B5"
              color="#3F51B5"
              density="compact"
              variant="underlined"
              v-model="fontf"
            >
              <template v-slot:item="{ props }">
                <v-list-item v-bind="props" @click="fontOp(fontf, 1)"></v-list-item>
              </template>
            </v-select>

            <v-select
              class="rounded-0 text-caption ma-0"
              style="max-width: 110px"
              prepend-inner-icon="mdi-format-size"
              hide-details
              title="Tamanho da fonte"
              :items="sizes"
              item-title="size"
              item-color="#3F51B5"
              color="#3F51B5"
              density="compact"
              variant="underlined"
              v-model="sizef"
            >
              <template v-slot:item="{ props }">
                <v-list-item v-bind="props" @click="fontOp(sizef, 2)"></v-list-item>
              </template>
            </v-select>

            <input
              type="number"
              min="6"
              max="50"
              maxlength="2"
              @change="altOp"
              v-model="altf"
              title="Altura da linha"
            />

            <input
              type="number"
              min="-1"
              max="1"
              maxlength="1"
              title="Espaço entre letras"
              @input="letterOp"
              v-model="letterf"
            />
          </v-row>
          <!-- textarea, printer, footer box -->
          <v-row
            class="flex-md-row flex-sm-column ma-0 h-100 overflow-hidden"
          >
            <v-col
              cols="12"
              md="1"
              sm="12"
            >
              <v-row class="ma-0 align-center justify-center">
                <v-btn
                  color="#7266fa"
                  @click="print"
                >
                  <v-icon size="x-large">mdi-printer</v-icon>
                  <v-tooltip activator="parent">Imprimir o relatório {{ title }}</v-tooltip>
                </v-btn>
              </v-row>
            </v-col>
            <v-col
              cols="12"
              md="11"
              sm="12"
              class="d-flex flex-column pa-0 overflow-hidden h-100 w-100"
            >
              <!-- textarea box -->
              <v-row class="ma-0 h-100 w-100 overflow-auto py-1 pr-1">
                 <div>
                  <textarea
                    v-model="lido"
                    id="textarea"
                    :cols="tcol"
                    :rows="trow"
                    class="pa-2
                    elevation-4"
                  ></textarea>
                 </div>
              </v-row>
              <!-- footer box -->
              <v-row class="ma-0">
                <p class="text-caption ma-0">caracteres: {{ca}}</p>
                <p class="text-caption ma-0">&emsp;</p>
                <p class="text-caption ma-0">linhas: {{trow}}</p>
                <p class="text-caption ma-0">&emsp;</p>
                <p class="text-caption ma-0">colunas: {{tcol}}</p>
              </v-row>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-main>
  </v-app>
</template>
