<template>
  <oms-header :title="trans.categories"/>

  <div class="sp-content">
    <div class="sp-nav shadow sp-bg-white part-2">
      <div class="start">
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

      <div class="end">
        <div class="item">
          <el-input size="large" clearable v-model="search" :placeholder="trans.search"/>
        </div>
      </div>
    </div>

    <div class="sp-card sp-bg-white sp-mt-8">
      <el-tree v-if="showTree"
               v-loading="loading" :data="data" :props="propTree"/>

      <table v-else class="sp-table" v-loading="loading">
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

      <el-pagination v-if="!showTree"
                     class="sp-mt-8"
                     background
                     @current-change="paginationHandler"
                     layout="pager"
                     :page-size="pagination.per_page"
                     :total="pagination.total"/>
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
const search = ref(null)
const pagination = ref({ total: 0 })
const page = ref(1)

const getData = () => {
  if (showTree.value) {
    getTreeData()
  } else {
    getListData()
  }
}

const getListData = () => {
  loading.value = true

  axios.get('/api/categories', { params: { paginate: true, page: page.value } }).
      then(res => {
        data.value = res.data.data
        pagination.value = res.data.meta
      }).
      finally(() => {loading.value = false})
}

/**
 * @param item
 */
const paginationHandler = (item) => {
  page.value = item
  getListData()
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