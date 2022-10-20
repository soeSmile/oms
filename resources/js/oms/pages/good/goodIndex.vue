<template xmlns="http://www.w3.org/1999/html">
  <oms-header title="Goods"/>

  <div class="sp-content">

    <div class="sp-card sp-bg-white">
      <div class="head">
        <div class="sp-nav">
          <div class="item">
            <ui-button title="Reload" class="sp-mr-2" icon="bx bx-refresh" color="success-l"
                       @click="getData"/>
          </div>
        </div>
      </div>

    </div>

  </div>
</template>

<script setup>
import { ref } from 'vue'
import OmsHeader from '../../component/omsHeader.vue'

const loading = ref(false)
const data = ref([])

const getData = () => {

}
</script>