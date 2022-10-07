<template>
  <div class="sp-content">
    <div class="sp-nav border sp-bg-white">
      <div class="item">
        <el-button>
          <i class='bx bx-refresh'></i>
        </el-button>

        <el-button type="primary">
          <i class='bx bx-plus-circle sp-mr-2'></i>
          {{ trans.add }}
        </el-button>
      </div>
    </div>

    <el-card class="sp-mt-4" shadow="never">
      <el-table :data="tableData" style="width: 100%">
        <el-table-column prop="date" label="Date" width="180"/>
        <el-table-column prop="name" label="Name" width="180"/>
        <el-table-column prop="address" label="Address"/>
      </el-table>
    </el-card>
  </div>
</template>

<script setup>
document.title = 'OMS SpecDoc | ' + trans.offer

const tableData = [
  {
    date: '2016-05-03',
    name: 'Tom',
    address: 'No. 189, Grove St, Los Angeles',
  },
  {
    date: '2016-05-02',
    name: 'Tom',
    address: 'No. 189, Grove St, Los Angeles',
  },
  {
    date: '2016-05-04',
    name: 'Tom',
    address: 'No. 189, Grove St, Los Angeles',
  },
  {
    date: '2016-05-01',
    name: 'Tom',
    address: 'No. 189, Grove St, Los Angeles',
  },
]
</script>