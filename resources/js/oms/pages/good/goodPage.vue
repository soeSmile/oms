<template>
  <oms-header title="Good page"/>

  <div class="sp-content">

    <div class="sp-card sp-bg-white">
      <div class="head">
        <div class="sp-tabs">
          <router-link to="/oms/good" class="item">
            <i class='bx bx-arrow-back'/>
            <span>Back</span>
          </router-link>

          <div class="item" :class="tab.disabled ? 'disabled' : (tab.active ? 'active' : '')"
               @click="selectTab(tab)"
               v-for="tab in tabs">
            <i :class='tab.icon'/>
            <span>{{ tab.name }}</span>
          </div>
        </div>
      </div>

      <div class="content">
        <component :is="currentTab"/>
      </div>

    </div>

  </div>
</template>

<script setup>
import OmsHeader from '../../component/omsHeader.vue'
import goodBase from './tabs/goodBase.vue'
import goodImage from './tabs/goodImage.vue'
import { computed, markRaw, ref, shallowRef } from 'vue'
import { useRoute } from 'vue-router'
import { useStore } from 'vuex'

const store = useStore()
const tabs = ref([
  { name: 'Common data', icon: 'bx bx-list-ul', active: true, disabled: true, component: goodBase },
  { name: 'Images', icon: 'bx bx-image-alt', active: false, disabled: true, component: goodImage },
])
const route = useRoute()
const currentTab = shallowRef(goodBase)

const selectTab = (tab) => {
  if (!tab.disabled) {
    currentTab.value = markRaw(tab.component)

    tabs.value.forEach(item => {
      item.active = (item.name === tab.name)
    })
  }
}

</script>