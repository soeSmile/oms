<template>
  <div class="sp-content sp-flex col center middle">
    <div class="sp-flex center middle sp-mb-8">
      <el-image class="sp-wpx-200"
                src="/img/logo.png"
                fit="cover"/>
    </div>

    <el-form class="sp-wpx-350"
             size="large"
             :model="user">
      <el-form-item prop="email">
        <el-input v-model="user.email"
                  placeholder="E-mail"/>
      </el-form-item>
      <el-form-item prop="password">
        <el-input v-model="user.password"
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
    </el-form>
  </div>
</template>

<script>
import { ref } from 'vue'

export default {
  name: 'App',

  setup () {
    const user = ref({})

    const reset = () => {
      user.value = {}
    }

    const login = () => {
      axios.post('/api/login', user.value).then(res => {})
    }

    return {
      user,
      reset,
      login,
    }
  },
}
</script>