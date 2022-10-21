<template>
  <oms-header title="Goods"/>

  <div class="sp-content">

    <div class="sp-card sp-bg-white">
      <div class="head">
        <div class="sp-nav">
          <div class="item">
            <ui-button title="Reload" class="sp-mr-2" icon="bx bx-refresh" color="success-l"
                       @click="getData"/>

            <ui-button title="Add Brand" icon="bx bx-plus-circle" color="primary-l"
                       @click="addBrand({})"/>

            <div class="sp-wpx-300 sp-ml-2">
              <el-input size="large" clearable v-model="filter.name" placeholder="Search"/>
            </div>
          </div>
        </div>
      </div>

      <div class="content">
        <table class="sp-table" v-loading="loading">
          <thead>
          <tr>
            <th class="id">ID</th>
            <th class="left">Name</th>
            <th class="right control">Control</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="val in data">
            <td class="center">{{ val.id }}</td>
            <td class="left">{{ val.name }}</td>
            <td class="right">
              <div class="sp-flex middle right">
                <i class='bx bxs-pencil sp-link sp-primary' @click="addBrand(val)"/>
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

  <ui-dialog width="wpx-600" color="primary-l"
             title="Brand"
             v-model="show" @save="store">
    <div class="sp-flex col">
      <div class="sp-flex col sp-mt-4">
        <div class="sp-mb-2">Brand name (EN)</div>
        <el-input size="large" v-model="brand.name" clearable/>
      </div>
    </div>
  </ui-dialog>
</template>

<script setup>
import { onBeforeMount, ref, watch } from 'vue'
import OmsHeader from '../../component/omsHeader.vue'
import { success, error } from '../../../helper/reponse'
import { ElMessageBox } from 'element-plus'

const loading = ref(false)
const filter = ref({
  page: 1,
  paginate: true,
  name: null,
})
const pagination = ref({
  total: 0,
})
const data = ref([])
const show = ref(false)
const brand = ref({
  name: null,
  id: null,
})

const getData = () => {
  loading.value = true

  axios.get('/api/brands', { params: filter.value }).
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

const store = () => {
  let method = 'post',
      link = '/api/brands'

  if (brand.value.id) {
    method = 'put'
    link = '/api/brands/' + brand.value.id
  }

  axios[method](link, brand.value).then(() => {
    show.value = false
    success(null, getData)
  }).catch(e => error(e)).finally(() => {})
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
    axios.delete('/api/brands/' + brand.id).
        then(() => {
          success(null, getData)
        }).
        catch(e => error(e))
  }).catch(() => {
  })
}

const addBrand = (item) => {
  show.value = true
  brand.value = item
}

watch(() => filter.value.name, () => { getData() })

onBeforeMount(() => {
  getData()
})
</script>