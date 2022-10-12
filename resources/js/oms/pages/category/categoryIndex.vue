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

        <el-button type="info" @click="makeTree">
          <i class='bx bx-sitemap sp-mr-2'></i>
          {{ showTree ? trans.list : trans.tree }}
        </el-button>
      </div>
    </div>

    <el-card class="sp-mt-4" shadow="never">

      <el-tree v-if="showTree"
               v-loading="loading" :data="data" :props="propTree"/>

      <el-table v-else
                v-loading="loading" stripe :data="data" style="width: 100%">
        <el-table-column prop="id" label="ID" width="180"/>
        <el-table-column prop="name.name" :label="trans.name"/>
        <el-table-column prop="parent.name" :label="trans.parent"/>
        <el-table-column :label="trans.control" width="180">
          <template #default="scope">
            <div class="sp-flex middle center">
              <i class='bx bxs-edit sp-i sp-link sp-info'></i>
              <i class='bx bx-trash sp-i sp-link sp-danger'></i>
            </div>
          </template>
        </el-table-column>
      </el-table>

    </el-card>
  </div>
</template>

<script setup>
import { onBeforeMount, ref } from 'vue'

document.title = 'OMS SpecDoc | ' + trans.categories
const loading = ref(false)
const data = ref([])
const showTree = ref(false)
const propTree = {
  label: 'label',
  children: 'child',
}

const getData = () => {
  loading.value = true

  axios.get('/api/categories', { params: {} }).
      then(res => {
        data.value = res.data.data
      }).
      finally(() => {loading.value = false})
}

const getTreeData = () => {
  loading.value = true

  axios.get('/api/categories/tree', { params: {} }).
      then(res => {
        data.value = res.data.data
      }).
      finally(() => {loading.value = false})
}

const makeTree = () => {
  if (!showTree.value) {
    getTreeData()
  } else {
    getData()
  }

  showTree.value = !showTree.value
}

onBeforeMount(() => {
  getData()
})
</script>