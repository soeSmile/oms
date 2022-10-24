<template>
  <oms-header title="Good page"/>

  <div class="sp-content">

    <div class="sp-card sp-bg-white">
      <div class="head">
        <div class="sp-nav">
          <div class="item">
            <router-link to="/oms/good">
              <ui-button title="Cancel" icon="bx bx-plus-circle" color="primary-l" class="sp-mr-2"/>
            </router-link>
            <ui-button title="Save" icon="bx bx-plus-circle" color="success-l"/>
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
                         v-model="good.brand">
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
              <div class="sp-mb-2">Deposit</div>
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
          </div>
        </div>

      </div>

    </div>

  </div>
</template>

<script setup>
import OmsHeader from '../../component/omsHeader.vue'
import { onMounted, ref } from 'vue'

const good = ref({})
const brands = ref([])
const categories = ref([])

const getBrands = () => {
  axios.get('/api/brands').then(res => { brands.value = res.data.data })
}

const getCategories = () => {
  axios.get('/api/categories').then(res => { categories.value = res.data.data })
}

onMounted(() => {
  getBrands()
  getCategories()
})
</script>