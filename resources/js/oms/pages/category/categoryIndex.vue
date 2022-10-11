<template>
  <div class="sp-content">
    <div class="sp-nav border sp-bg-white">
      <div class="item">
        <el-button @click="getData">
          <i class='bx bx-refresh'></i>
        </el-button>

        <el-button type="primary">
          <i class='bx bx-plus-circle sp-mr-2'></i>
          {{ trans.add }}
        </el-button>
      </div>
    </div>

    <el-card class="sp-mt-4" shadow="never">
      <el-table v-loading="loading" :data="data" style="width: 100%">
        <el-table-column prop="date" label="Date" width="180"/>
        <el-table-column prop="name" label="Name" width="180"/>
        <el-table-column prop="address" label="Address"/>
      </el-table>
    </el-card>
  </div>
</template>

<script setup>
import { onBeforeMount, ref } from 'vue'

document.title = 'OMS SpecDoc | ' + trans.categories
const loading = ref(false)
const data = ref([])

const getData = () => {
  loading.value = true

  axios.get('/api/categories', { params: {} }).
      then(res => {
        data.value = res.data.data
      }).
      finally(() => {loading.value = false})
}

onBeforeMount(() => {
  getData()
})
</script>