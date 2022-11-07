<template>
  <oms-header title="Product page"/>

  <div class="sp-content" v-loading="loading">

    <div class="sp-card sp-bg-white">
      <div class="head">
        <div class="sp-nav">
          <div class="item">
            <router-link to="/oms/product">
              <ui-button title="Back" class="sp-mr-2" icon="bx bx-arrow-back" color="light"/>
            </router-link>
            <ui-button v-if="product.id" title="Reload product" class="sp-mr-2" icon="bx bx-refresh" color="primary-l"
                       @click="getData"/>
            <ui-button title="Save" icon="bx bx-plus-circle" color="success-l"
                       @click="store"/>
          </div>
        </div>

        <div class="sp-tabs sp-mt-6">
          <div class="item" :class="tab.disabled ? 'disabled' : (tab.active ? 'active' : '')"
               @click="selectTab(tab)"
               v-for="tab in tabs">
            <i :class='tab.icon'/>
            <span>{{ tab.name }}</span>
          </div>
        </div>
      </div>

      <div class="content sp-mt-6">
        <product-base v-if="active === 'base'" :product="product" :brands="brands" :categories="categories"/>
        <product-image v-if="active === 'image'" :product="product"/>
      </div>

    </div>

  </div>
</template>

<script setup>
import OmsHeader from '../../component/omsHeader.vue'
import ProductBase from './tabs/productBase.vue'
import ProductImage from './tabs/productImage.vue'
import { onBeforeMount, ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { error, success } from '../../../helper/reponse'

const loading = ref(false)
const tabs = ref([
  { name: 'Common data', icon: 'bx bx-list-ul', active: true, disabled: false, show: 'base' },
  { name: 'Images', icon: 'bx bx-image-alt', active: false, disabled: true, show: 'image' },
])
const router = useRouter()
const route = useRoute()
const active = ref('base')
const product = ref({
  id: null,
  category: [],
  number: [],
  oe: [],
  tnved: [],
  hscode: [],
})
const brands = ref([])
const categories = ref([])

const selectTab = (tab) => {
  if (!tab.disabled) {
    active.value = tab.show

    tabs.value.forEach(item => {
      item.active = (item.name === tab.name)
    })
  }
}

const setActiveTab = () => {
  tabs.value.forEach(item => {
    item.disabled = false
  })
}

const store = () => {
  loading.value = true

  let method = 'post',
      link = '/api/products'

  if (product.value.id) {
    method = 'put'
    link = '/api/products/' + product.value.id
  }

  axios[method](link, product.value).then((res) => {
    if (method === 'post') {
      product.value.id = res.data.data
    }
    success(null, getData)
    router.replace('/oms/product/' + product.value.id)
  }).catch(e => error(e)).finally(() => {loading.value = false})
}

const getData = () => {
  loading.value = true
  let request = null
  if (route.params.id !== 'new' || product.value.id) {
    const id = product.value.id ?? route.params.id
    request = axios.get('/api/products/' + id)
  }
  Promise.all([axios.get('/api/brands'), axios.get('/api/categories'), request]).
      then((res) => {
        brands.value = res[0].data.data
        categories.value = res[1].data.data
        if (res[2]) {
          product.value = res[2].data.data
        }
      }).
      finally(() => {loading.value = false})
}

onBeforeMount(() => {
  getData()
})

watch(() => product.value.id, () => { setActiveTab() })

</script>