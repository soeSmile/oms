<template>
  <div class="sp-product sp-flex top left wrap">
    <div class="block">
      <div class="sp-flex col">
        <div class="sp-mb-2">Name</div>
        <el-input size="large" v-model="product.name" clearable/>
      </div>

      <div class="sp-flex col sp-mt-4">
        <div class="sp-mb-2">Brand</div>
        <el-select size="large"
                   clearable
                   filterable
                   v-model="product.brandId">
          <el-option v-for="brand in brands"
                     :value="brand.id"
                     :label="brand.name"/>
        </el-select>
      </div>

      <div class="sp-flex wrap middle wide">
        <div class="sp-flex col sp-mr-2 sp-mt-4">
          <div class="sp-mb-2">Width in box</div>
          <el-input size="large" v-model="product.widthBox"/>
        </div>

        <div class="sp-flex col sp-mr-2 sp-mt-4">
          <div class="sp-mb-2">Height in box</div>
          <el-input size="large" v-model="product.heightBox"/>
        </div>

        <div class="sp-flex col sp-mr-2 sp-mt-4">
          <div class="sp-mb-2">Length in box</div>
          <el-input size="large" v-model="product.lengthBox"/>
        </div>

        <div class="sp-flex col sp-mr-2 sp-mt-4">
          <div class="sp-mb-2">Gross weight</div>
          <el-input size="large" v-model="product.weightGross"/>
        </div>

        <div class="sp-flex col sp-mt-4">
          <div class="sp-mb-2">Volume</div>
          <el-input size="large" v-model="product.volume"/>
        </div>
      </div>

      <div class="sp-flex col sp-mt-4">
        <div class="sp-mb-2">Pledge products</div>
        <el-switch v-model="product.deposit"/>
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
                   v-model="product.category">
          <el-option v-for="brand in categories"
                     :value="brand.id"
                     :label="brand.name"/>
        </el-select>
      </div>
      <div class="sp-flex col sp-mt-2">
        <div class="sp-flex middle sp-p-1"
             v-for="(val,key) in product.category">
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
               v-for="(val,key) in product.number">
            <i class='bx bx-x sp-mr-2 sp-link sp-danger' @click="removeNumber(key)"/>
            <span>{{ val }}</span>
          </div>
        </div>
        <div class="block">
          <div class="sp-mb-2">????/??????</div>
          <div class="sp-flex middle">
            <el-input size="large" v-model="oe"/>
            <ui-button icon="bx bx-plus" @click="addOe"/>
          </div>
          <div class="sp-flex middle sp-p-1 sp-mt-2"
               v-for="(val,key) in product.oe">
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
               v-for="(val,key) in product.tnved">
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
               v-for="(val,key) in product.hscode">
            <i class='bx bx-x sp-mr-2 sp-link sp-danger' @click="removeHsCode(key)"/>
            <span>{{ val }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const prop = defineProps(['product', 'brands', 'categories'])

const number = ref()
const oe = ref()
const tnved = ref()
const hscode = ref()

const viewCategoryName = (id) => {
  const cat = prop.categories.filter((item) => item.id === id)

  return cat.length > 0 ? cat[0].name : ''
}

const removeCategory = (key) => {
  prop.product.category.splice(key, 1)
}

const addNumber = () => {
  if (number.value) {
    prop.product.number.push(number.value)
    number.value = null
  }
}

const removeNumber = (key) => {
  prop.product.number.splice(key, 1)
}

const addOe = () => {
  if (oe.value) {
    prop.product.oe.push(oe.value)
    oe.value = null
  }
}

const removeOe = (key) => {
  prop.product.oe.splice(key, 1)
}

const addOTnved = () => {
  if (tnved.value) {
    prop.product.tnved.push(tnved.value)
    tnved.value = null
  }
}

const removeTnved = (key) => {
  prop.product.tnved.splice(key, 1)
}

const addHsCode = () => {
  if (hscode.value) {
    prop.product.hscode.push(hscode.value)
    hscode.value = null
  }
}

const removeHsCode = (key) => {
  prop.product.hscode.splice(key, 1)
}
</script>