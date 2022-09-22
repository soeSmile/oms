<template>
  <main>
    <aside class="sp-menu">
      <el-menu router>
        <el-sub-menu v-for="(val,key) in menu"
                     :index="key">
          <template #title>
            <i class="mdi" :class="val.icon"/>
            <span>{{ val.name }}</span>
          </template>
          <el-menu-item-group v-if="val.menu">
            <el-menu-item v-for="(item,k) in val.menu"
                          :index="key + '-' + k">
              <template #title>
                <i class="mdi" :class="item.icon"/>
                <span>{{ item.name }}</span>
              </template>
            </el-menu-item>
          </el-menu-item-group>
        </el-sub-menu>
      </el-menu>
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