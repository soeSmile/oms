<template>
  <div class="menu-item" :class="{ opened: expanded }">
    <div class="label"
         @click="toggleMenu"
         :style="{ paddingLeft: depth * 20 + 20 + 'px' }">
      <div class="left">
        <i v-if="icon" class="icon bx" :class="icon"/>
        <span v-if="showName">{{ name }}</span>
      </div>
      <div v-if="menu" class="right" :class="{'close' : close}">
        <i v-if="showSub" class='sub-link bx bx-chevron-up'/>
        <i v-else class='sub-link bx bx-chevron-down'/>
      </div>
    </div>

    <div v-if="menu"
         class="items-container sp-fadeInDown" :class="containerClass">
      <menu-item :class="{ opened: showSub }"
                 v-for="item in menu"
                 :menu="item.menu"
                 :name="item.name"
                 :icon="item.icon"
                 :depth="depth + 1"
                 :close="close"/>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
  menu: Array,
  name: String,
  icon: String,
  depth: Number,
  close: Boolean,
})

const expanded = ref(false)
const showSub = ref(false)

const toggleMenu = () => {
  expanded.value = !expanded.value
  showSub.value = !showSub.value
}

const containerClass = computed(() => {
  let style = ''

  if (props.close) {
    style += ' close'
  }

  if (showSub.value) {
    style += ' show'
  }

  return style
})

const showName = computed(() => {
  return props.close ? props.depth > 0 : true
})
</script>/