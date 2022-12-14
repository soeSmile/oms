<template>
  <oms-header title="Users"/>

  <div class="sp-content">

    <div class="sp-card sp-bg-white">
      <div class="head">
        <div class="sp-nav">
          <div class="item">
            <ui-button title="Reload and clear" class="sp-mr-2" icon="bx bx-refresh" color="light"
                       @click="getData(true)"/>

            <router-link to="/oms/user/new">
              <ui-button title="Add user" class="sp-mr-2" icon="bx bx-plus-circle" color="primary-l"/>
            </router-link>

            <el-select size="large" v-model="filter.deleted" @change="getData(false)">
              <el-option :value="false" label="Active"/>
              <el-option :value="true" label="Deleted"/>
            </el-select>
          </div>
        </div>
      </div>

      <div class="content sp-mt-6">
        <table class="sp-table" v-loading="loading">
          <thead>
          <tr>
            <th class="id center">
              ID
            </th>
            <th class="left">
              <sort align="left" field="name" :filter="filter" @getData="getData">
                Name
              </sort>
            </th>
            <th class="left">
              <sort align="left" field="email" :filter="filter" @getData="getData">
                Email
              </sort>
            </th>
            <th class="center">
              Confirm
            </th>
            <th class="center">
              Role
            </th>
            <th class="center">Deleted</th>
            <th class="right control">Control</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="val in data" :class="{'sp-bg-gray' : val.deleted}">
            <td class="center">{{ val.id }}</td>
            <td class="left">{{ val.name }}</td>
            <td class="left">{{ val.email }}</td>
            <td class="center">{{ val.confirm ? 'Yes' : 'No' }}</td>
            <td class="center">{{ val.roleName }}</td>
            <td class="center">{{ val.deleted ? 'Yes' : 'No' }}</td>
            <td class="right">
              <div class="sp-flex middle right" v-if="!val.deleted">
                <router-link :to="'/oms/user/' + val.id">
                  <i class='bx bxs-pencil sp-link sp-primary sp-mr-1'/>
                </router-link>
                <i class='bx bx-shield-quarter sp-link sp-warning sp-mr-1' @click="confirm(val)"/>
                <i class='bx bx-x sp-link sp-danger' @click="destroy(val)"/>
              </div>
            </td>
          </tr>
          </tbody>
        </table>


        <el-pagination class="sp-mt-6"
                       background
                       layout="pager"
                       @current-change="paginationHandler"
                       :page-size="pagination.per_page"
                       :total="pagination.total"/>
      </div>
    </div>

  </div>
</template>

<script setup>
import OmsHeader from '../../component/omsHeader.vue'
import { onBeforeMount, ref } from 'vue'
import { ElMessageBox } from 'element-plus'
import { error, success } from '../../../helper/reponse'
import Sort from '../../component/sort.vue'

const loading = ref()
const data = ref([])
const filter = ref({
  page: 1,
  paginate: true,
  order: {},
  deleted: false,
})
const pagination = ref({
  total: 0,
})

const getData = (clear = false) => {
  if (clear) {
    filter.value = {
      page: 1,
      paginate: true,
      order: {},
      deleted: false,
    }
  }

  loading.value = true

  axios.get('/api/users', { params: filter.value }).
      then(res => {
        data.value = res.data.data
        pagination.value = res.data.meta
      }).finally(() => loading.value = false)
}

/**
 * @param page
 */
const paginationHandler = (page) => {
  filter.value.page = page
  getData()
}

const confirm = (user) => {
  ElMessageBox.confirm(
      'Are you sure you want to ' + (user.confirm ? 'block' : 'unblock') + ' user?',
      'Warning',
      {
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel',
        type: 'error',
      },
  ).then(() => {
    axios.post('/api/users/confirm', { id: user.id, confirm: !user.confirm }).
        then(() => {
          success(null, getData)
        }).
        catch(e => error(e))
  }).catch(() => {
  })
}

const destroy = (user) => {
  ElMessageBox.confirm(
      'Are you sure you want to delete user?',
      'Warning',
      {
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel',
        type: 'error',
      },
  ).then(() => {
    axios.delete('/api/users/' + user.id).
        then(() => {
          success(null, getData)
        }).
        catch(e => error(e))
  }).catch(() => {
  })
}

onBeforeMount(() => {
  getData(true)
})
</script>