<template>
  <div class="sp-flex middle sp-mx-2">
    <i v-if="sort === 'asc'" class='bx bx-caret-up'/>
    <i v-else-if="sort === 'desc'" class='bx bx-caret-down'/>
    <i v-else class='bx bxs-sort-alt'/>
  </div>
</template>

<script setup>
defineProps({
  sort: String,
})
</script>