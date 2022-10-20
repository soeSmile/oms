<template>
  <oms-header title="Categories"/>

  <div class="sp-content">
    <div class="sp-card sp-bg-white">
      <div class="head">
        <div class="sp-nav">
          <div class="item">
            <ui-button title="Reload" class="sp-mr-2" icon="bx bx-refresh" color="success-l"
                       @click="getData"/>
            <ui-button title="Show list" class="sp-mr-2" icon="bx bx-list-ul"/>
            <ui-button title="Upload from file" class="sp-mr-2" icon="bx bx-cloud-upload" color="info-l"/>
            <ui-button title="Download" icon="bx bx-cloud-download" color="info-l"/>
          </div>
        </div>
      </div>

      <div class="content" v-loading="loading">
        <tree :data="data" @getData="getData"/>
      </div>
    </div>
  </div>
</template>

<script setup>
import OmsHeader from '../../component/omsHeader.vue'
import { onMounted, ref } from 'vue'
import Tree from './component/tree.vue'

const loading = ref(false)
const data = ref([])
const showTree = ref(true)

const getData = () => {
  loading.value = true
  let url = showTree.value ? '/api/categories/tree' : '/api/categories'

  axios.get(url).then(res => {data.value = res.data.data}).finally(() => {loading.value = false})
}

onMounted(() => {
  getData()
})
</script>