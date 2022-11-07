<template>
  <el-upload
      v-model:file-list="images"
      :action="'/api/products/images/'+ product.id +'/upload'"
      :headers="headers"
      list-type="picture-card"
      :on-preview="previewImage"
      :before-remove="beforeRemove"
      :on-success="afterUpload">
    <i class='bx bx-plus'/>
  </el-upload>

  <el-dialog v-model="showImage">
    <img class="sp-product-img-show" :src="showImageUrl" alt="Preview Image"/>
  </el-dialog>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { getCookie } from '../../../../helper/cookie'
import { useRoute } from 'vue-router'
import { ElMessageBox } from 'element-plus'
import { success } from '../../../../helper/reponse'

const prop = defineProps(['product'])
const images = ref([])
const showImage = ref(false)
const showImageUrl = ref()
const headers = {
  'X-Requested-With': 'XMLHttpRequest',
  'Accept': 'application/json, text/plain, */*',
  'X-XSRF-TOKEN': getCookie('XSRF-TOKEN'),
}
const route = useRoute()

const previewImage = (image) => {
  showImageUrl.value = image.url
  showImage.value = true
}

const beforeRemove = async (image) => {
  try {
    await ElMessageBox.confirm(
        'Are you sure?',
        'Warning',
        {
          confirmButtonText: 'Delete',
          cancelButtonText: 'Cancel',
          type: 'error',
        },
    )
    axios.delete('/api/products/images/' + image.id).then(() => {
      success()
    })
  } catch (e) {
    return false
  }
}

const afterUpload = (response, file, files) => {
  files[files.length - 1].id = response.data.id
}

const getImages = () => {
  axios.get('/api/products/images/' + prop.product.id).
      then(res => {
        images.value = res.data.data
      })
}

onMounted(() => {
  getImages()
})

</script>