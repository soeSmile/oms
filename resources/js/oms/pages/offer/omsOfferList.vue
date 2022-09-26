<template>
  <div class="sp-content">
    <div class="sp-nav sp-bg-white">
      <div class="item">
        <el-button type="primary">
          <i class='bx bx-plus-circle sp-mr-2'></i>
          {{ trans.add }}
        </el-button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'omsOfferList',

  setup () {
    document.title = 'OMS SpecDoc | ' + trans.offer

    return {}
  },
}
</script>