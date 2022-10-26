<template>
  <el-upload
      v-model:file-list="images"
      :action="'/api/goods/images/'+ id +'/upload'"
      :headers="headers"
      list-type="picture-card"
      :on-preview="previewImage"
      :on-remove="removeImage">
    <i class='bx bx-plus'/>
  </el-upload>

  <el-dialog v-model="showImage">
    <img w-full :src="showImageUrl" alt="Preview Image"/>
  </el-dialog>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { getCookie } from '../../../../helper/cookie'
import { useRoute } from 'vue-router'

const prop = defineProps({
  id: Number,
})
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
}

const removeImage = (image, images) => {
}

const getImages = () => {
  axios.get('/api/goods/images/' + route.params.id).
      then(res => {
        images.value = res.data.data
      })
}

onMounted(() => {
  getImages()
})

</script>