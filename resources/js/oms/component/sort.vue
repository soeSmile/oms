<template>
  <div @click="sortBy"
       class="sp-sort sp-flex middle sp-link" :class="align">
    <div class="sp-flex middle sp-mx-1">
      <i v-if="sort === 'asc'" class='bx bx-caret-up'/>
      <i v-else-if="sort === 'desc'" class='bx bx-caret-down'/>
      <i v-else class='bx bxs-sort-alt'/>
    </div>
    <slot></slot>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const prop = defineProps({
  align: String,
  field: String,
  filter: Object,
})
const emit = defineEmits(['getData'])
const sort = ref(null)

const sortBy = () => {
  switch (sort.value) {
    case 'asc': {
      sort.value = 'desc'
      break
    }
    case null: {
      sort.value = 'asc'
      break
    }
    default: {
      sort.value = null
      break
    }
  }

  if (sort.value) {
    prop.filter.order[prop.field] = sort.value
  } else {
    delete prop.filter.order[prop.field]
  }
  emit('getData')
}

watch(() => prop.filter.order, () => {
  if (Object.keys(prop.filter.order).length === 0) {
    sort.value = null
  }
})

</script>