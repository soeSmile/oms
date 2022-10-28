<template>
  <oms-header title="User"/>

  <div class="sp-content">

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
            <el-select size="large" clearable
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
import { ref } from 'vue'

const user = ref({
  name: null,
  surname: null,
  phone: null,
  email: null,
  confirm: true,
  role: 2,
})

const getData = () => {}
const store = () => {}
</script>