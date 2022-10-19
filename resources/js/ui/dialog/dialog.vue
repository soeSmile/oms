<template>

  <div v-if="modelValue"
       @click="updateValue(false)"
       class="sp-dialog-bg"></div>

  <div v-if="modelValue"
       class="sp-dialog" :class="width">
    <div class="head" :class="color">
      <div class="title">{{ title || '' }}</div>
      <div class="control">
        <i class='bx bx-save' @click="$emit('save')"/>
        <i class='bx bx-x' @click="updateValue(false)"/>
      </div>
    </div>
    <div class="content">
      <slot/>
    </div>
    <div class="foot"></div>
  </div>

</template>

<script setup>
const props = defineProps({
  title: String,
  width: String,
  color: String,
  modelValue: Boolean,
})

const emit = defineEmits(['update:modelValue', 'save'])

const updateValue = (value) => {
  emit('update:modelValue', value)
}

</script>