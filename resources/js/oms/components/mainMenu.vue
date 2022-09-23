<template>
  <div class="sp-menu">
    <div class="head">
      <div class="logo">
        <img src="/img/logo.png" alt="">
        <div class="title">OMS SpecDoc</div>
      </div>
    </div>
    <div class="content">
      <ul class="links">
        <li v-for="(val,idx) in menu">
          <router-link class="link"
                       v-if="val.link"
                       :to="val.link">
            <i class="icon bx" :class="val.icon"/>
            <span class="title">{{ val.name }}</span>
          </router-link>

          <div class="link"
               @click="subShow(idx)"
               v-else>
            <i class="icon bx" :class="val.icon"/>
            <span class="title">{{ val.name }}</span>
            <i v-if="val.show" class='sub-link bx bx-chevron-up'/>
            <i v-else class='sub-link bx bx-chevron-down'/>
          </div>

          <ul class="sub" :class="val.show ? 'show' : ''"
              v-if="val.menu">
            <li v-for="sub in val.menu">
              <router-link class="link"
                           :to="sub.link">
                <i class="icon bx" :class="sub.icon"/>
                <span class="title">{{ sub.name }}</span>
              </router-link>
            </li>
          </ul>

        </li>
      </ul>
    </div>
    <div class="footer"></div>
  </div>
</template>

<script>
import { ref } from 'vue'

export default {
  name: 'mainMenu',

  setup () {
    const menu = ref([
      {
        name: 'Главная', icon: 'bxs-grid-alt', link: '/oms',
        show: false, menu: null,
      },
      {
        name: 'Товары', icon: 'bxs-store', link: null,
        show: false,
        menu: [
          { name: 'Номенклатура товаров', icon: 'bx-list-ul', link: '/oms/index' },
          { name: 'Номенклатура', icon: 'bx-list-ul', link: '/oms/index' },
          { name: 'Номенклатура', icon: 'bx-list-ul', link: '/oms/index' },
          { name: 'Номенклатура', icon: 'bx-list-ul', link: '/oms/index' },
        ],
      },
      {
        name: 'Поставщики', icon: 'bxs-user-detail', link: null,
        show: false,
        menu: [
          { name: 'Список', icon: 'bx-list-ul', link: '/oms/index' },
        ],
      },
      {
        name: 'Логистика', icon: 'bxs-plane-alt', link: '/oms/index',
        show: false, menu: null,
      },
    ])

    const subShow = (idx) => {
      menu.value[idx].show = !menu.value[idx].show
    }

    return {
      menu,
      subShow,
    }
  },
}
</script>