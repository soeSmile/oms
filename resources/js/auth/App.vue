<template>
  <div class="sp-page sp-flex col center middle">

    <el-form class="sp-wpx-350"
             size="large"
             :model="user">
      <el-form-item prop="email">
        <el-input v-model="user.email"
                  :disabled="loading"
                  placeholder="Email"/>
      </el-form-item>
      <el-form-item prop="password">
        <el-input v-model="user.password"
                  :disabled="loading"
                  type="password"
                  placeholder="Password"/>
      </el-form-item>
      <el-form-item label="Remember"
                    prop="delivery">
        <el-switch v-model="user.remember"
                   :disabled="loading"/>
      </el-form-item>

      <el-form-item class="sp-mt-8">
        <ui-button class="sp-mr-2"
                   title="Login" color="primary" :disabled="loading"
                   @click="!loading ? login() : null"/>
        <ui-button title="Reset" color="light" :disabled="loading"
                   @click="!loading ? reset() : null"/>
      </el-form-item>

      <el-alert v-for="val in errors"
                class="sp-mt-1"
                :title="val"
                type="error"
                show-icon/>
    </el-form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { messageToArray } from '../helper/serialazeError'

const loading = ref(false)
const user = ref({
  email: null,
  password: null,
})
const errors = ref([])

const reset = () => {
  user.value = {}
  errors.value = []
}

const login = () => {
  loading.value = true

  axios.get('/sanctum/csrf-cookie').then(response => {
    axios.post('/api/login', {
      email: user.value.email,
      password: user.value.password,
      timeZone: -new Date().getTimezoneOffset() / 60 || 3,
    }).then(
        res => {
          reset()
          window.location.href = '/oms'
        },
    ).catch(e => {
      if (e.response.data.errors) {
        errors.value = messageToArray(e.response.data.errors)
        loading.value = false
      }
    })
  })
}
</script>