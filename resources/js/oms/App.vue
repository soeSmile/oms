<template>
  <main>
    <aside class="sp-menu">
      <i class="bx bx-abacus"/>
    </aside>
  </main>
</template>

<script>
import { ref } from 'vue'

export default {
  name: 'App',

  setup () {
    const menu = ref([
      {
        name: 'Товары', icon: 'mdi-store', link: null, menu: [
          { name: 'Номенклатура', icon: 'mdi-view-list', link: '#' },
        ],
      },
      {
        name: 'Поставщики', icon: 'mdi-handshake', link: null, menu: [
          { name: 'Список', icon: 'mdi-view-list', link: '#' },
        ],
      },
      {
        name: 'Логистика', icon: 'mdi-train-car', link: '#', menu: null,
      },
    ])

    return {
      menu,
    }
  },
}
</script>