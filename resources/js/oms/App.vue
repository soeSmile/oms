<template>
  <component :is="layout"/>
</template>

<script>
import omsLayout from './layout/omsLayout.vue'

export default {
  name: 'App',

  components: {
    omsLayout,
  },

  setup () {

    return {
      layout: 'omsLayout',
    }
  },
}
</script>