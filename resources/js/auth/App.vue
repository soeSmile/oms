<template>
  <div class="sp-wrap sp-flex col center middle">
    <div class="sp-flex center middle sp-mb-8">
      <el-image class="sp-wpx-200"
                src="/img/logo.png"
                fit="cover"/>
    </div>

    <el-form v-loading="loading"
             class="sp-wpx-350"
             size="large"
             :model="user">
      <el-form-item prop="email">
        <el-input v-model="user.email"
                  placeholder="E-mail"/>
      </el-form-item>
      <el-form-item prop="password">
        <el-input v-model="user.password"
                  type="password"
                  placeholder="Пароль"/>
      </el-form-item>
      <el-form-item label="Запомнить"
                    prop="delivery">
        <el-switch v-model="user.remember"/>
      </el-form-item>

      <el-form-item class="sp-mt-8">
        <el-button type="primary"
                   @click="login">
          Войти
        </el-button>
        <el-button @click="reset">
          Сброс
        </el-button>
      </el-form-item>

      <el-alert v-for="val in errors"
                class="sp-mt-1"
                :title="val"
                type="error"
                show-icon/>
    </el-form>
  </div>
</template>

<script>
import { ref } from 'vue'
import { messageToArray } from '../helper/serialazeError'

export default {
  name: 'App',

  setup () {
    const loading = ref(false)
    const user = ref({})
    const errors = ref([])

    const reset = () => {
      user.value = {}
      errors.value = []
    }

    const login = () => {
      loading.value = true

      axios.get('/sanctum/csrf-cookie').then(response => {
        axios.post('/api/login', user.value).then(
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

    return {
      loading,
      user,
      reset,
      login,
      errors,
    }
  },
}
</script>