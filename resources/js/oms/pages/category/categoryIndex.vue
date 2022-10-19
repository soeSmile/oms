<template>
  <oms-header :title="trans.categories"/>

  <div class="sp-content">
    <div class="sp-card sp-bg-white sp-mt-8">
      <div class="head">
        <div class="sp-nav part-2">
          <div class="start">
            <div class="item">
              <ui-button class="sp-mr-2" icon="bx bx-refresh" color="success-l"
                         @click="getData"/>

              <ui-button :title="trans.add + ' ' + trans.category" icon="bx bx-plus-circle" color="primary-l"
                         @click="addCategory"/>
            </div>
          </div>
          <div class="end">
            <div class="item">
              <el-input size="large" clearable v-model="search" :placeholder="trans.search"/>
            </div>
          </div>
        </div>
      </div>

      <div class="content">

      </div>


    </div>
  </div>

  <ui-dialog width="wpx-600" color="success-l"
             :title="trans.category"
             v-model="show" @save="store">
    <div class="sp-flex col">
      <div class="sp-flex col">
        <div class="sp-mb-2">{{ trans.category }}</div>
        <el-input size="large" v-model="category.name"/>
      </div>
      <div class="sp-flex col sp-mt-4">
        <div class="sp-mb-2">{{ trans.code + ' ' + trans.mbn }}</div>
        <el-input size="large" v-model="category.code"/>
      </div>
    </div>
  </ui-dialog>
</template>

<script setup>
import { onBeforeMount, ref } from 'vue'
import OmsHeader from '../../component/omsHeader.vue'

const loading = ref(false)
const data = ref([])
const search = ref(null)
const show = ref(false)
const category = ref({})

const addCategory = () => {
  show.value = true
}

const getData = () => {
  loading.value = true

  axios.get('/api/categories', { params: { order: 'id' } }).
      then(res => {
        data.value = res.data.data
      }).
      finally(() => {loading.value = false})
}

const store = () => {
  show.value = false
}

onBeforeMount(() => {
  getData()
})
</script>