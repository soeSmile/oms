<template>
  <el-upload
      v-model:file-list="images"
      :action="'/api/goods/images/'+ good.id +'/upload'"
      :headers="headers"
      list-type="picture-card"
      :on-preview="previewImage"
      :before-remove="beforeRemove">
    <i class='bx bx-plus'/>
  </el-upload>

  <el-dialog v-model="showImage">
    <img class="sp-good-img-show" :src="showImageUrl" alt="Preview Image"/>
  </el-dialog>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { getCookie } from '../../../../helper/cookie'
import { useRoute } from 'vue-router'
import { ElMessageBox } from 'element-plus'

const prop = defineProps(['good'])
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

const beforeRemove = async (image, images) => {
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
    console.log(image)
  } catch (e) {
    return false
  }
}

const getImages = () => {
  axios.get('/api/goods/images/' + prop.good.id).
      then(res => {
        images.value = res.data.data
      })
}

onMounted(() => {
  getImages()
})

</script>