<template>
  <oms-header title="User"/>

  <div class="sp-content" v-loading="loading">

    <div class="sp-card sp-bg-white">
      <div class="head">
        <div class="sp-nav">
          <div class="item">
            <router-link to="/oms/user">
              <ui-button title="Back" class="sp-mr-2" icon="bx bx-arrow-back" color="light"/>
            </router-link>
            <ui-button v-if="user.id" title="Reload good" class="sp-mr-2" icon="bx bx-refresh" color="primary-l"
                       @click="getData"/>
            <ui-button title="Save" icon="bx bx-plus-circle" color="success-l"
                       @click="store"/>
          </div>
        </div>
      </div>

      <div class="content sp-my-6">
        <div class="sp-w-50">
          <div class="sp-flex col sp-mt-4">
            <div class="sp-mb-2">* Name</div>
            <el-input size="large" v-model="user.name" clearable/>
          </div>

          <div class="sp-flex col sp-mt-4">
            <div class="sp-mb-2">* Password</div>
            <el-input type="password" size="large" v-model="user.password" show-password clearable/>
          </div>

          <div class="sp-flex col sp-mt-4">
            <div class="sp-mb-2">Surname</div>
            <el-input size="large" v-model="user.surname" clearable/>
          </div>

          <div class="sp-flex col sp-mt-4">
            <div class="sp-mb-2">Phone</div>
            <el-input size="large" v-model="user.phone" clearable/>
          </div>

          <div class="sp-flex col sp-mt-4">
            <div class="sp-mb-2">* Email</div>
            <el-input size="large" v-model="user.email" clearable/>
          </div>

          <div class="sp-flex col sp-mt-4">
            <div class="sp-mb-2">Confirm</div>
            <el-switch size="large" v-model="user.confirm"/>
          </div>

          <div class="sp-flex col sp-mt-4">
            <div class="sp-mb-2">* Role</div>
            <el-select size="large"
                       v-model="user.role">
              <el-option :value="1" label="Admin"/>
              <el-option :value="2" label="Manager"/>
            </el-select>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import OmsHeader from '../../component/omsHeader.vue'
import { onMounted, ref } from 'vue'
import { error, success } from '../../../helper/reponse'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const loading = ref(false)
const user = ref({
  id: null,
  name: null,
  surname: null,
  phone: null,
  email: null,
  confirm: true,
  role: 2,
  password: null,
})

const getData = () => {
  if (route.params.id !== 'new') {
    loading.value = true

    axios.get('/api/users/' + route.params.id).
        then(res => {
          user.value = res.data.data
        }).
        finally(() => {loading.value = false})
  }
}

const store = () => {
  loading.value = true

  let method = 'post',
      link = '/api/users'

  if (user.value.id) {
    method = 'put'
    link = '/api/users/' + user.value.id
  }

  axios[method](link, user.value).
      then((res) => {
        if (method === 'post') {
          user.value.id = res.data.data
        }
        success()
        router.replace('/oms/user/' + user.value.id)
      }).
      catch(e => error(e)).
      finally(() => {loading.value = false})
}

onMounted(() => {
  getData()
})
</script>