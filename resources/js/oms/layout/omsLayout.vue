<template>
  <div class="sp-main">
    <main-menu/>

    <router-view/>
  </div>
</template>

<script>
import MainMenu from '../components/mainMenu.vue'

export default {
  name: 'omsLayout',

  components: { MainMenu },

  setup () {
    return {}
  },
}
</script>