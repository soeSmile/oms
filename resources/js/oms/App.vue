<template>
  <component :is="layout"/>
</template>

<script setup>
import omsLayout from './layout/omsLayout.vue'

const layout = omsLayout

</script>