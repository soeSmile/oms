<template>
  <oms-header title="Goods"/>

  <div class="sp-content">

    <div class="sp-card sp-bg-white" v-loading="loading">
      <div class="head">
        <div class="sp-nav sp-mb-4">
          <div class="item">
            Count goods: <span class="sp-fnt bold sp-ml-2 sp-warning">{{ numberFormat(count) }}</span>
          </div>
        </div>
        <div class="sp-nav">
          <div class="item">
            <ui-button title="Reload and clear" class="sp-mr-2" icon="bx bx-refresh" color="light"
                       @click="getData(true)"/>

            <router-link to="/oms/good/new" class="sp-mr-2">
              <ui-button title="Add good" icon="bx bx-plus-circle" color="primary-l"/>
            </router-link>

            <div class="sp-wpx-300">
              <el-input size="large" clearable v-model="filter.name" placeholder="Search"/>
            </div>
          </div>
        </div>
      </div>

      <div class="content">
        <table class="sp-table sp-mt-6">
          <thead>
          <tr>
            <th class="center id sort">
              <sort align="middle" field="id" :filter="filter" @getData="getData">
                center
              </sort>
            </th>
            <th class="left sort">
              <sort align="left" field="name" :filter="filter" @getData="getData">
                Name
              </sort>
            </th>
            <th class="left sort">
              Brand
            </th>
            <th class="center sort">
              Deposit
            </th>
            <th class="center">Count Categories</th>
            <th class="right control">Control</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="val in data" class="hover">
            <td class="center">{{ val.id }}</td>
            <td class="left">{{ val.name }}</td>
            <td class="left">{{ val.brand }}</td>
            <td class="center">{{ val.deposit }}</td>
            <td class="center">{{ val.count }}</td>
            <td class="right">
              <div class="sp-flex middle right">
                <router-link :to="'/oms/good/' + val.id">
                  <i class='bx bxs-pencil sp-link sp-primary'/>
                </router-link>
                <i class='bx bx-x sp-link sp-danger' @click="destroy(val)"/>
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
import { onMounted, ref, watch } from 'vue'
import OmsHeader from '../../component/omsHeader.vue'
import { ElMessageBox } from 'element-plus'
import { error, success } from '../../../helper/reponse'
import Sort from '../../component/sort.vue'
import { numberFormat } from '../../../helper/numberFormat'

const loading = ref(false)
const filter = ref({
  page: 1,
  paginate: true,
  name: null,
  order: {},
})
const pagination = ref({
  total: 0,
})
const data = ref([])
const count = ref(0)

const getData = (clear = false) => {
  if (clear) {
    filter.value = {
      page: 1,
      paginate: true,
      name: null,
      order: {},
    }
  }

  loading.value = true

  axios.get('/api/goods', { params: filter.value }).
      then((res => {
        data.value = res.data.data
        pagination.value = res.data.meta
        count.value = res.data.count
      })).finally(() => {loading.value = false})
}

const destroy = (brand) => {
  ElMessageBox.confirm(
      'Are you sure?',
      'Warning',
      {
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        type: 'error',
      },
  ).then(() => {
    axios.delete('/api/goods/' + brand.id).
        then(() => {
          success(null, getData)
        }).
        catch(e => error(e))
  }).catch(() => {
  })
}

/**
 * @param page
 */
const paginationHandler = (page) => {
  filter.value.page = page
  getData()
}

watch(() => filter.value.name, () => { getData() })

onMounted(() => {
  getData()
})
</script>