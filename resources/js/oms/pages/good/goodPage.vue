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

        <el-tabs v-model="tabs">
          <el-tab-pane name="Base">
            <template #label>
              <div class="sp-flex middle">
                <i class='bx bx-list-ul sp-mr-2'/>
                <span>Common data</span>
              </div>
            </template>
            <div class="sp-mt-6 sp-good sp-flex top left wrap">
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

                <div class="sp-flex wrap middle wide">
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

                <div class="sp-flex col sp-mt-4">
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
                <div class="sp-flex col sp-mt-2">
                  <div class="sp-flex middle sp-p-1"
                       v-for="(val,key) in good.category">
                    <i class='bx bx-x sp-mr-2 sp-link sp-danger' @click="removeCategory(key)"/>
                    <span>{{ viewCategoryName(val) }}</span>
                  </div>
                </div>

                <div class="sp-w-100 sp-flex wrap wide sp-mt-6">
                  <div class="block">
                    <div class="sp-mb-2">Catalogue number</div>
                    <div class="sp-flex middle">
                      <el-input size="large" v-model="number"/>
                      <ui-button icon="bx bx-plus" @click="addNumber"/>
                    </div>
                    <div class="sp-flex middle sp-p-1 sp-mt-2"
                         v-for="(val,key) in good.number">
                      <i class='bx bx-x sp-mr-2 sp-link sp-danger' @click="removeNumber(key)"/>
                      <span>{{ val }}</span>
                    </div>
                  </div>
                  <div class="block">
                    <div class="sp-mb-2">ОЕ/ОЕМ</div>
                    <div class="sp-flex middle">
                      <el-input size="large" v-model="oe"/>
                      <ui-button icon="bx bx-plus" @click="addOe"/>
                    </div>
                    <div class="sp-flex middle sp-p-1 sp-mt-2"
                         v-for="(val,key) in good.oe">
                      <i class='bx bx-x sp-mr-2 sp-link sp-danger' @click="removeOe(key)"/>
                      <span>{{ val }}</span>
                    </div>
                  </div>
                </div>

                <div class="sp-w-100 sp-flex wrap wide sp-mt-6">
                  <div class="block">
                    <div class="sp-mb-2">TNVED</div>
                    <div class="sp-flex middle">
                      <el-input size="large" v-model="tnved"/>
                      <ui-button icon="bx bx-plus" @click="addOTnved"/>
                    </div>
                    <div class="sp-flex middle sp-p-1 sp-mt-2"
                         v-for="(val,key) in good.tnved">
                      <i class='bx bx-x sp-mr-2 sp-link sp-danger' @click="removeTnved(key)"/>
                      <span>{{ val }}</span>
                    </div>
                  </div>
                  <div class="block">
                    <div class="sp-mb-2">HS Code</div>
                    <div class="sp-flex middle">
                      <el-input size="large" v-model="hscode"/>
                      <ui-button icon="bx bx-plus" @click="addHsCode"/>
                    </div>
                    <div class="sp-flex middle sp-p-1 sp-mt-2"
                         v-for="(val,key) in good.hscode">
                      <i class='bx bx-x sp-mr-2 sp-link sp-danger' @click="removeHsCode(key)"/>
                      <span>{{ val }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </el-tab-pane>
          <el-tab-pane name="Images" :disabled="!good.id">
            <template #label>
              <div class="sp-flex middle">
                <i class='bx bx-image-alt sp-mr-2'/>
                <span>Images</span>
              </div>
            </template>
            <div class="sp-mt-6">
              Images
            </div>
          </el-tab-pane>
        </el-tabs>

      </div>

    </div>

  </div>
</template>

<script setup>
import OmsHeader from '../../component/omsHeader.vue'
import { onMounted, ref } from 'vue'
import { error, success } from '../../../helper/reponse'
import { useRoute, useRouter } from 'vue-router'

const tabs = ref('Base')
const loading = ref(false)
const router = useRouter()
const route = useRoute()
const good = ref({
  id: null,
  category: [],
  number: [],
  oe: [],
  tnved: [],
  hscode: [],
})
const brands = ref([])
const categories = ref([])
const number = ref()
const oe = ref()
const tnved = ref()
const hscode = ref()

const store = () => {
  loading.value = true

  let method = 'post',
      link = '/api/goods'

  if (good.value.id) {
    method = 'put'
    link = '/api/goods/' + good.value.id
  }

  axios[method](link, good.value).then((res) => {
    if (method === 'post') {
      good.value.id = res.data.data
    }
    success(null, getData)
    router.replace('/oms/good/' + good.value.id)
  }).catch(e => error(e)).finally(() => {loading.value = false})
}

const getData = () => {
  loading.value = true
  let request = null

  if (route.params.id !== 'new' || good.value.id) {
    const id = good.value.id ?? route.params.id

    request = axios.get('/api/goods/' + id)
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

const viewCategoryName = (id) => {
  const cat = categories.value.filter((item) => item.id === id)

  return cat.length > 0 ? cat[0].name : ''
}

const removeCategory = (key) => {
  good.value.category.splice(key, 1)
}

const addNumber = () => {
  if (number.value) {
    good.value.number.push(number.value)
    number.value = null
  }

}

const removeNumber = (key) => {
  good.value.number.splice(key, 1)
}

const addOe = () => {
  if (oe.value) {
    good.value.oe.push(oe.value)
    oe.value = null
  }
}

const removeOe = (key) => {
  good.value.oe.splice(key, 1)
}

const addOTnved = () => {
  if (tnved.value) {
    good.value.tnved.push(tnved.value)
    tnved.value = null
  }
}

const removeTnved = (key) => {
  good.value.tnved.splice(key, 1)
}

const addHsCode = () => {
  if (hscode.value) {
    good.value.hscode.push(hscode.value)
    hscode.value = null
  }
}

const removeHsCode = (key) => {
  good.value.hscode.splice(key, 1)
}

onMounted(() => {
  getData()
})
</script>