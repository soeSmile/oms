<template>
  <oms-header title="Goods"/>

  <div class="sp-content">

    <div class="sp-card sp-bg-white">
      <div class="head">
        <div class="sp-nav">
          <div class="item">
            <ui-button title="Reload" class="sp-mr-2" icon="bx bx-refresh" color="success-l"
                       @click="getData"/>
          </div>
        </div>
      </div>

      <div class="content">
        <table class="sp-table" v-loading="loading">
          <thead>
          <tr>
            <th class="center id">ID</th>
            <th class="left w30">Name</th>
            <th class="left w30">Brand</th>
            <th class="center w30">Deposit</th>
            <th class="right control">Control</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="val in data">
            <td class="center">{{ val.id }}</td>
            <td class="left">{{ val.name }}</td>
            <td class="left">{{ val.brand }}</td>
            <td class="center">{{ val.deposit }}</td>
            <td class="right">
              <div class="sp-flex middle right">
                <i class='bx bxs-pencil sp-link sp-primary'/>
                <i class='bx bx-x sp-link sp-danger'/>
              </div>
            </td>
          </tr>
          </tbody>
        </table>

        <el-pagination class="sp-mt-6"
                       background
                       layout="pager"
                       @current-change="paginationHandler"
                       :page-size="pagination.per_page"
                       :total="pagination.total"/>
      </div>

    </div>

  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import OmsHeader from '../../component/omsHeader.vue'

const loading = ref(false)
const filter = ref({
  page: 1,
  paginate: true,
})
const pagination = ref({
  total: 0,
})
const data = ref([])

const getData = () => {
  loading.value = true

  axios.get('/api/goods', { params: filter.value }).
      then((res => {
        data.value = res.data.data
        pagination.value = res.data.meta
      })).finally(() => {loading.value = false})
}
/**
 * @param page
 */
const paginationHandler = (page) => {
  filter.value.page = page
  getData()
}

onMounted(() => {
  getData()
})
</script>