<template>
  <oms-header title="Events"/>

  <div class="sp-content">

    <div class="sp-card sp-bg-white" v-loading="loading">
      <div class="head">
        <div class="sp-nav">
          <div class="item">
            <ui-button title="Reload and clear" class="sp-mr-2" icon="bx bx-refresh" color="light"
                       @click="getData(true)"/>
          </div>
        </div>
      </div>

      <div class="content">
        <table class="sp-table sp-mt-6">
          <thead>
          <tr>
            <th class="icon left"></th>
            <th class="id center">ID</th>
            <th class="left">Event</th>
            <th class="left">User</th>
            <th class="center">IP</th>
            <th class="center">Date</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(val,key) in data" class="link">
            <template v-if="!val.expand">
              <td class="left">
                <i class='bx bx-chevrons-right' @click="showExpand(key)"/>
              </td>
              <td class="center">{{ val.id }}</td>
              <td>{{ val.eventName }}</td>
              <td>{{ val.name }}</td>
              <td class="center">{{ val.ip }}</td>
              <td class="center">{{ val.date }}</td>
            </template>
            <template v-else>
              <td colspan="6">
                {{ expandData }}
              </td>
            </template>
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
import OmsHeader from '../../component/omsHeader.vue'
import { onBeforeMount, ref } from 'vue'

const loading = ref()
const filter = ref({
  page: 1,
  paginate: true,
  name: null,
})
const pagination = ref({
  total: 0,
})
const data = ref([])
const expandKey = ref(null)
const expandShow = ref(null)
const expandData = ref([])

const showExpand = (key) => {
  if (expandKey.value) {
    data.value.splice(expandKey.value, 1)
    expandKey.value = null
  }
  expandKey.value = key + 1
  expandShow.value = true
  expandData.value = data.value[key].data
  data.value.splice(key + 1, 0, { expand: true })
}

const getData = (clear = false) => {
  if (clear) {
    filter.value = {
      page: 1,
      paginate: true,
      name: null,
    }
  }

  loading.value = true

  axios.get('/api/events', { params: filter.value }).
      then(res => {
        data.value = res.data.data
        pagination.value = res.data.meta
      }).finally(() => loading.value = false)
}

/**
 * @param page
 */
const paginationHandler = (page) => {
  filter.value.page = page
  getData()
}

onBeforeMount(() => {
  getData()
})
</script>