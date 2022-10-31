<template>
  <div class="sp-header">
    <div class="title">
      OMS {{ title }}
    </div>
    <div class="slot">
      <slot></slot>
    </div>
    <div class="wrap">
      <div class="user">
        <div class="image">
          <img src="/img/face.png" alt="">
        </div>
        <div class="name">{{ user.name + ' ' + (user.surname ?? '') }}</div>
        <div class="control">
          <i class='sp-link hover sp-mr-2 bx bx-envelope'/>
          <i class='sp-link hover sp-mr-2 bx bx-bell'/>
          <i class='sp-link hover bx bx-exit'
             @click="logout"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  title: String,
})

document.title = 'OMS | ' + props.title

const logout = () => {
  axios.post('/api/logout').then(res => {
    window.location.href = '/'
  })
}
</script>