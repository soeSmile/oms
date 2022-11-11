<template>
  <div class="menu-item" :class="{ opened: expanded }">
    <div v-if="menu"
         class="label"
         @click="toggleMenu"
         :style="{ paddingLeft: depth * 20 + 20 + 'px' }">
      <div class="left">
        <i v-if="item.icon" class="icon bx" :class="item.icon"/>
        <span v-if="showName">{{ item.name }}</span>
      </div>
      <div class="right" :class="{'close' : close}">
        <i v-if="showSub" class='sub-link bx bx-chevron-up'/>
        <i v-else class='sub-link bx bx-chevron-down'/>
      </div>
    </div>

    <router-link v-else
                 :to="item.link"
                 class="label"
                 :style="{ paddingLeft: depth * 20 + 20 + 'px' }">
      <div class="left">
        <i v-if="item.icon" class="icon bx" :class="item.icon"/>
        <span v-if="showName">{{ item.name }}</span>
      </div>
    </router-link>

    <div v-if="menu"
         class="items-container sp-fadeInDown" :class="containerClass">
      <menu-item :class="{ opened: showSub }"
                 v-for="m in menu"
                 :menu="m.menu"
                 :item="m"
                 :depth="depth + 1"
                 :close="close"/>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
  menu: Array,
  item: Object,
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