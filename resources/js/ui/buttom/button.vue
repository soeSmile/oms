<template>
  <div class="sp-button" :class="btnClass">
    <i v-if="icon" :class='icon'/>
    <span v-if="title">{{ title }}</span>
  </div>
</template>

<script setup>

import { computed } from 'vue'

const props = defineProps({
  title: String,
  icon: String,
  color: String,
  disable: Boolean,
})

const btnClass = computed(() => {
  let style = 'primary'

  if (props.color) {
    style = props.color
  }

  if (props.disable) {
    style += ' disable'
  }

  return style
})

</script>