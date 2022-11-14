<template>
  <div v-if="checkRole(item)"
       class="menu-item" :class="{ opened: expanded }">
    <div v-if="menu"
         :title="item.name"
         class="label"
         :class="labelClass"
         @click="toggleMenu"
         :style="close ? '' : { paddingLeft: depth * 20 + 20 + 'px' }">
      <div class="left">
        <i v-if="item.icon" class="icon bx" :class="item.icon + (close ? ' close' : '')"/>
        <span v-if="showName">{{ item.name }}</span>
      </div>
      <div class="right" :class="{'close' : close}">
        <i v-if="item.show" class='sub-link bx bx-chevron-up'/>
        <i v-else class='sub-link bx bx-chevron-down'/>
      </div>
    </div>

    <router-link v-else
                 :title="item.name"
                 :to="item.link"
                 class="label"
                 :class="labelClass"
                 @click="hideRootSub(0)"
                 :style="close ? '' : { paddingLeft: depth * 20 + 20 + 'px' }">
      <div class="left">
        <i v-if="item.icon" class="icon bx" :class="item.icon + (close ? ' close' : '')"/>
        <span v-if="showName">{{ item.name }}</span>
      </div>
    </router-link>

    <div v-if="menu"
         class="items-container sp-fadeInDown" :class="containerClass">
      <menu-item :class="{ opened: item.show }"
                 v-for="m in menu"
                 :menu="m.menu"
                 :item="m"
                 :depth="depth + 1"
                 :close="close"/>
    </div>
  </div>
</template>

<script setup>
import { computed, inject, ref } from 'vue'

const props = defineProps({
  menu: Array,
  item: Object,
  depth: Number,
  close: Boolean,
})

const expanded = ref(false)
const hideRootSub = inject('hideRootSub')

const checkRole = (item) => {
  if (item.role && item.role.length > 0) {
    return item.role.includes(user.role)
  }

  return true
}

const toggleMenu = () => {
  hideRootSub(props.depth)
  expanded.value = !expanded.value
  props.item.show = !props.item.show
}

const labelClass = computed(() => {
  let style = 'depth_' + props.depth

  if (props.close) {
    style += ' close'
  }
  return style
})

const containerClass = computed(() => {
  let style = ''

  if (props.close) {
    style += ' close'
  }

  if (props.item.show) {
    style += ' show'
  }

  return style
})

const showName = computed(() => {
  return props.close ? props.depth > 0 : true
})
</script>/