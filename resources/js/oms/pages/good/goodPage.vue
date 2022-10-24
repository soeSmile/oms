<template>
  <oms-header title="Good page"/>

  <div class="sp-content">

    <div class="sp-card sp-bg-white">
      <div class="head">
        <div class="sp-nav">
          <div class="item">
            <router-link to="/oms/good">
              <ui-button title="Cancel" icon="bx bx-plus-circle" color="primary-l" class="sp-mr-2"/>
            </router-link>
            <ui-button title="Save" icon="bx bx-plus-circle" color="success-l"/>
          </div>
        </div>
      </div>

      <div class="content">

      </div>
    </div>

  </div>
</template>

<script setup>

import OmsHeader from '../../component/omsHeader.vue'
</script>