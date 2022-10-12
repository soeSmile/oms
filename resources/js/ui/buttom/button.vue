<template>
  <div class="sp-button" :class="color || 'primary'">
    <i v-if="icon" :class='icon'/>
    <span>{{ title }}</span>
  </div>
</template>

<script setup>

defineProps({
  title: String,
  icon: String,
  color: String,
})

</script>