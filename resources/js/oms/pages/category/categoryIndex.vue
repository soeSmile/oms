<template>
  <oms-header :title="trans.categories"/>

  <div class="sp-content">
    <div class="sp-nav shadow sp-bg-white">
      <div class="item">
        <ui-button class="sp-mr-2"
                   icon="bx bx-refresh" color="light"
                   @click="getData"/>

        <router-link class="sp-mr-2" to="/oms/category/new">
          <ui-button :title="trans.add + ' ' + trans.category"
                     icon="bx bx-plus-circle" color="secondary"/>
        </router-link>

        <ui-button :title="trans.show + ' ' + (showTree ? trans.list : trans.tree)"
                   icon="bx bx-sitemap" color="info"
                   @click="switchTree"/>
      </div>
    </div>

    <div class="sp-card sp-bg-white sp-mt-6">
      <el-tree v-if="showTree"
               v-loading="loading" :data="data" :props="propTree"/>

      <table v-else class="sp-table">
        <thead>
        <tr>
          <th class="center id">ID</th>
          <th class="left">{{ trans.category }}</th>
          <th class="left">{{ trans.parent + ' ' + trans.category }}</th>
          <th class="right">{{ trans.control }}</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="val in data">
          <td class="center">{{ val.id }}</td>
          <td class="left">{{ val.name }}</td>
          <td class="left">{{ val.parent.name }}</td>
          <td class="right">
            <i class='bx bxs-edit sp-i sp-link sp-info'></i>
            <i class='bx bx-trash sp-i sp-link sp-danger'></i>
          </td>
        </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>

<script setup>
import { onBeforeMount, ref } from 'vue'
import OmsHeader from '../../component/omsHeader.vue'

const loading = ref(false)
const data = ref([])
const showTree = ref(false)
const propTree = {
  label: 'label',
  children: 'child',
}

const getData = () => {
  if (showTree.value) {
    getTreeData()
  } else {
    getListData()
  }
}

const getListData = () => {
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

const switchTree = () => {
  if (!showTree.value) {
    getTreeData()
  } else {
    getListData()
  }

  showTree.value = !showTree.value
}

onBeforeMount(() => {
  getData()
})
</script>