<template>
  <div class="col-span-1 bg-white rounded-md">
    <p>{{ product.attributes.title }}</p>
    <p>cat</p>
  </div>
</template>

<script setup>
const props = defineProps({
  product: Object
})


</script>
