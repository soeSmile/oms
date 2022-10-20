<template>
  <div class="sp-flex middle">
    <ui-button title="Add Root Category" icon="bx bx-plus-circle" color="primary-l"
               @click="addCategory"/>

    <div class="sp-wpx-500 sp-ml-2">
      <el-input size="large" placeholder="Search" clearable v-model="search"/>
    </div>
  </div>

  <div class="sp-mt-4">
    <el-tree :data="data"
             draggable
             :allow-drop="allowDrop"
             :allow-drag="allowDrag"
             @node-drag-end="handleDragEnd"
             ref="treeRef"
             :filter-node-method="filterNode"
             node-key="id">
      <template #default="{ node, data }">
        <div class="sp-flex middle sp-py-3 sp-pl-r">
          <div class="sp-mr-4">
            <i class='bx bx-plus sp-link sp-success' @click="addCategory(node)"/>
            <i class='bx bxs-pencil sp-link sp-primary' @click="editCategory(node)"/>
            <i class='bx bx-x sp-link sp-danger' @click="destroy(node)"/>
          </div>
          <div class="sp-fnt medium sp-dark">{{ node.label }}</div>
        </div>
      </template>
    </el-tree>
  </div>

  <ui-dialog width="wpx-600" color="primary-l"
             title="Category"
             v-model="show" @save="store">
    <div class="sp-flex col">
      <div class="sp-flex col">
        <div class="sp-mb-2">Parent</div>
        <div class="sp-mb-2 sp-fnt medium italic">{{ category.parent ?? 'Root' }}</div>
      </div>
      <div class="sp-flex col sp-mt-4">
        <div class="sp-mb-2">Category name (EN)</div>
        <el-input size="large" v-model="category.label" clearable/>
      </div>
      <div class="sp-flex col sp-mt-4">
        <div class="sp-mb-2">Code (may be empty)</div>
        <el-input size="large" v-model="category.code" clearable/>
      </div>
    </div>
  </ui-dialog>
</template>

<script setup>
import { ref, watch } from 'vue'
import { ElMessage, ElMessageBox } from 'element-plus'
import { messageToStr } from '../../../../helper/serialazeError'

const prop = defineProps({
  data: Array,
})
const emit = defineEmits(['getData'])

const search = ref('')
const treeRef = ref()
const show = ref(false)
const category = ref({
  id: null,
  label: null,
  code: null,
  parentId: null,
})

const filterNode = (value, data) => {
  if (!value) return true
  return data.label.includes(value)
}

const addCategory = (cat = {}) => {
  category.value = {}
  show.value = true

  if (cat.data) {
    category.value.parent = cat.data.label
    category.value.parentId = cat.data.id
  }
}

const editCategory = (cat) => {
  category.value = {}
  show.value = true

  if (cat.data) {
    category.value = cat.data
  }
}

const store = () => {
  let method = 'post',
      link = '/api/categories'

  if (category.value.id) {
    method = 'put'
    link = '/api/categories/' + category.value.id
  }

  axios[method](link, prepareData()).then((res) => {
    if (method === 'post') {
      category.value = res.data.data
    }
    show.value = false
    success()
  }).catch(e => error(e)).finally(() => {})
}

function prepareData () {

  return {
    id: category.value.id,
    name: category.value.label,
    parentId: category.value.parentId,
    code: category.value.code,
  }
}

const destroy = (cat) => {
  ElMessageBox.confirm(
      'Are you sure?',
      'Warning',
      {
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        type: 'error',
      },
  ).then(() => {
    axios.delete('/api/categories/' + cat.data.id).then(() => {success()}).catch(e => error(e))
  }).catch(() => {
  })
}

function success () {
  emit('getData')
  ElMessage({
    message: 'Success',
    type: 'success',
  })
}

function error (e) {
  let error = 'Error'

  if (e.response.data.errors) {
    error = messageToStr(e.response.data.errors)
  }

  ElMessage({
    dangerouslyUseHTMLString: true,
    message: error,
    type: 'error',
  })
}

const allowDrop = (draggingNode, dropNode, DropType) => {
  category.value = draggingNode.data
  return DropType !== 'after'
}
const allowDrag = () => {
  return true
}
const handleDragEnd = (draggingNode, dropNode, dropType) => {
  if (dropType === 'inner') {
    category.value.parentId = dropNode.data.id
    store()
  }

  if (dropType === 'before') {
    if (dropNode.data.parentId) {
      category.value.parentId = dropNode.data.parentId
    } else {
      category.value.parentId = null
    }
    store()
  }
}

watch(search, (val) => {
  treeRef.value.filter(val)
})
</script>