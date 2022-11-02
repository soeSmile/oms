<template>
  <oms-header title="Events"/>

  <div class="sp-content">

    <div class="sp-card sp-bg-white" v-loading="loading">
      <div class="head">
        <div class="sp-nav">
          <div class="item">
            <ui-button title="Reload and clear" class="sp-mr-2" icon="bx bx-refresh" color="light"
                       @click="getData(true)"/>
            <el-select class="sp-wpx-300" size="large" clearable filterable
                       v-model="filter.event">
              <el-option v-for="event in events"
                         :label="event.name"
                         :value="event.value"/>
            </el-select>
          </div>
        </div>
      </div>

      <div class="content">
        <table class="sp-table sp-mt-6">
          <thead>
          <tr>
            <th class="icon left"></th>
            <th class="id center">
              <sort align="center" field="id" :filter="filter" @getData="getData">
                ID
              </sort>
            </th>
            <th class="left">Event</th>
            <th class="left">
              <sort align="left" field="user" :filter="filter" @getData="getData">
                User
              </sort>
            </th>
            <th class="center">IP</th>
            <th class="center">
              <sort align="center" field="date" :filter="filter" @getData="getData">
                Date
              </sort>
            </th>
          </tr>
          </thead>
          <tbody>
          <template v-for="(val,key) in data">
            <tr class="link" @click="showExpand(key)">
              <td class="left">
                <i class="sp-warning"
                   :class="expandRows.includes(key) ? 'bx bx-chevrons-down' : 'bx bx-chevrons-right'"/>
              </td>
              <td class="center">{{ val.id }}</td>
              <td>{{ val.eventName }}</td>
              <td>{{ val.name }}</td>
              <td class="center">{{ val.ip }}</td>
              <td class="center">{{ val.date }}</td>
            </tr>
            <tr v-if="expandRows.includes(key)" class="sp-fadeInDown">
              <td colspan="6">
                <div class="sp-p-1 sp-flex middle" v-for="(item,k) in expandData[key]">
                  <div class="sp-wpx-200">{{ k }} :</div>
                  <div>{{ item }}</div>
                </div>
              </td>
            </tr>
          </template>
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
import { onBeforeMount, ref, watch } from 'vue'
import Sort from '../../component/sort.vue'

const loading = ref()
const filter = ref({
  page: 1,
  paginate: true,
  name: null,
  event: null,
  order: {},
})
const pagination = ref({
  total: 0,
})
const data = ref([])
const expandRows = ref([])
const expandData = ref({})
const events = ref([])

const showExpand = (key) => {
  const index = expandRows.value.indexOf(key)
  if (index > -1) {
    expandRows.value.splice(index, 1)
    delete expandData.value[key]
  } else {
    expandRows.value.push(key)
    expandData.value[key] = data.value[key].data
  }
}

const getData = (clear = false) => {
  if (clear) {
    filter.value = {
      page: 1,
      paginate: true,
      name: null,
      event: null,
      order: {},
    }
  }

  loading.value = true

  axios.get('/api/events', { params: filter.value }).
      then(res => {
        data.value = res.data.data
        pagination.value = res.data.meta
        events.value = res.data.events
      }).
      finally(() => loading.value = false)
}

/**
 * @param page
 */
const paginationHandler = (page) => {
  filter.value.page = page
  getData()
}

watch(() => filter.value.event, () => { getData() })

onBeforeMount(() => {
  getData()
})
</script>