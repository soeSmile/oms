<template>
  <div class="sp-content">
    <div class="sp-nav border sp-bg-white">
      <div class="item">
        <router-link class="sp-button light"
                     to="/oms/category">
          <i class='bx bx-x'/>
          <span>{{ trans.cancel }}</span>
        </router-link>

        <div class="sp-button success sp-ml-2">
          <i class='bx bxs-save'/>
          <span>{{ trans.save }}</span>
        </div>

        <ui-button class="sp-mr-2" title="Тест" icon="bx bxs-save" color="light"/>
        <ui-button title="Тест"/>
      </div>
    </div>

    <el-card class="sp-mt-4" shadow="never">

    </el-card>
  </div>
</template>

<script setup>

</script>