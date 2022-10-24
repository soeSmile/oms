<template>
  <oms-header title="Good page"/>

  <div class="sp-content">

    <div class="sp-card sp-bg-white" v-loading="loading">
      <div class="head">
        <div class="sp-nav">
          <div class="item">
            <router-link to="/oms/good">
              <ui-button title="Cancel" icon="bx bx-plus-circle" color="primary-l" class="sp-mr-2"/>
            </router-link>
            <ui-button v-if="good.id" title="Reload" class="sp-mr-2" icon="bx bx-refresh" color="light"
                       @click="getData"/>
            <ui-button title="Save" icon="bx bx-plus-circle" color="success-l"
                       @click="store"/>
          </div>
        </div>
      </div>

      <div class="content">

        <div class="sp-good sp-flex top left wrap">
          <div class="block">
            <div class="sp-flex col">
              <div class="sp-mb-2">Name</div>
              <el-input size="large" v-model="good.name" clearable/>
            </div>

            <div class="sp-flex col sp-mt-4">
              <div class="sp-mb-2">Brand</div>
              <el-select size="large"
                         clearable
                         filterable
                         v-model="good.brandId">
                <el-option v-for="brand in brands"
                           :value="brand.id"
                           :label="brand.name"/>
              </el-select>
            </div>

            <div class="sp-flex wrap middle">
              <div class="sp-flex col sp-mr-2 sp-mt-4">
                <div class="sp-mb-2">Width in box</div>
                <el-input size="large" v-model="good.widthBox"/>
              </div>

              <div class="sp-flex col sp-mr-2 sp-mt-4">
                <div class="sp-mb-2">Height in box</div>
                <el-input size="large" v-model="good.heightBox"/>
              </div>

              <div class="sp-flex col sp-mr-2 sp-mt-4">
                <div class="sp-mb-2">Length in box</div>
                <el-input size="large" v-model="good.lengthBox"/>
              </div>

              <div class="sp-flex col sp-mr-2 sp-mt-4">
                <div class="sp-mb-2">Gross weight</div>
                <el-input size="large" v-model="good.weightGross"/>
              </div>

              <div class="sp-flex col sp-mt-4">
                <div class="sp-mb-2">Volume</div>
                <el-input size="large" v-model="good.volume"/>
              </div>
            </div>

            <div class="sp-flex col sp-mt-2">
              <div class="sp-mb-2">Pledge goods</div>
              <el-switch v-model="good.deposit"/>
            </div>
          </div>

          <div class="block">
            <div class="sp-flex col">
              <div class="sp-mb-2">Category</div>
              <el-select size="large"
                         clearable
                         filterable
                         multiple
                         collapse-tags
                         collapse-tags-tooltip
                         v-model="good.category">
                <el-option v-for="brand in categories"
                           :value="brand.id"
                           :label="brand.name"/>
              </el-select>
            </div>

            <div class="sp-flex col sp-mt-4">
              <div class="sp-flex middle sp-p-1"
                   v-for="(val,key) in good.category">
                <i class='bx bx-x sp-mr-2 sp-link sp-danger' @click="removeCategory(key)"/>
                <span>{{ viewCategoryName(val) }}</span>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
</template>

<script setup>
import OmsHeader from '../../component/omsHeader.vue'
import { onMounted, ref } from 'vue'
import { error, success } from '../../../helper/reponse'
import { useRoute, useRouter } from 'vue-router'

const loading = ref(false)
const router = useRouter()
const route = useRoute()
const good = ref({
  id: null,
  category: [],
})
const brands = ref([])
const categories = ref([])

const viewCategoryName = (id) => {
  const cat = categories.value.filter((item) => item.id === id)

  return cat.length > 0 ? cat[0].name : ''
}

const removeCategory = (key) => {
  good.value.category.splice(key, 1)
}

const store = () => {
  loading.value = true

  let method = 'post',
      link = '/api/goods'

  if (good.value.id) {
    method = 'put'
    link = '/api/goods/' + good.value.id
  }

  axios[method](link, good.value).then((res) => {
    good.value.id = res.data.data
    success()
    router.replace('/oms/good/' + good.value.id)
  }).catch(e => error(e)).finally(() => {loading.value = false})
}

const getData = () => {
  loading.value = true
  let request = null

  if (route.params.id !== 'new') {
    request = axios.get('/api/goods/' + route.params.id)
  }

  Promise.all([axios.get('/api/brands'), axios.get('/api/categories'), request]).
      then((res) => {
        brands.value = res[0].data.data
        categories.value = res[1].data.data

        if (res[2]) {
          good.value = res[2].data.data
        }
      }).
      finally(() => {loading.value = false})
}

onMounted(() => {
  getData()
})
</script>