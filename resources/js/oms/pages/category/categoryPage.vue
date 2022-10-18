<template>
  <oms-header :title="trans.category"/>

  <div class="sp-content" v-loading="loading">
    <div class="sp-nav shadow sp-bg-white">
      <div class="item">
        <router-link to="/oms/category">
          <ui-button class="sp-mr-2" :title="trans.cancel" icon="bx bx-x" color="light"/>
        </router-link>
        <ui-button class="sp-mr-2" :title="trans.save" icon="bx bxs-save" color="success"
                   @click="store"/>
      </div>
    </div>

    <div class="sp-card sp-bg-white sp-mt-8">
      <div class="sp-w-50">
        <div class="sp-mb-2">{{ trans.category }}</div>
        <el-input size="large"
                  v-model="category.name"/>

        <div class="sp-mb-2 sp-mt-8">{{ trans.parent }}</div>
        <el-select size="large"
                   v-model="category.parentId">
          <el-option v-for="val in categories"
                     :label="val.name"
                     :value="val.id"/>
        </el-select>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { ElMessage } from 'element-plus'
import { messageToStr } from '../../../helper/serialazeError'
import OmsHeader from '../../component/omsHeader.vue'

const router = useRouter()
const loading = ref(false)
const category = ref({
  id: null,
})
const categories = ref([])

const store = () => {
  loading.value = true
  let method = 'post',
      link = '/api/categories'

  if (category.value.id) {
    method = 'put'
    link = '/api/categories/' + category.value.id
  }

  axios[method](link, category.value).then((res) => {
    if (method === 'post') {
      category.value = res.data.data
      router.replace('/oms/category/' + res.data.data.id)
    }
    ElMessage({
      message: 'Success',
      type: 'success',
    })
  }).catch(e => {
    let error = 'Error'

    if (e.response.data.errors) {
      error = messageToStr(e.response.data.errors)
    }

    ElMessage({
      dangerouslyUseHTMLString: true,
      message: error,
      type: 'error',
    })
  }).finally(() => {loading.value = false})
}

onMounted(() => {
  loading.value = true

  axios.get('/api/categories', { params: {} }).
      then(res => {
        categories.value = res.data.data
      }).
      finally(() => {loading.value = false})
})
</script>