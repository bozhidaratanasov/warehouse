<template>
  <div class="col-span-1 bg-white rounded-md">
    <p>{{ product.attributes.title }}</p>
    <p>{{ product.attributes.description }}</p>
    <p>{{ product.attributes.code }}</p>
    <p>{{ product.attributes.category }}</p>
    <p>{{ product.attributes.buying_price }}</p>
    <p>{{ product.attributes.selling_price }}</p>
    <p>{{ product.attributes.quantity }}</p>
    <div class="text-center space-x-20 my-4">
      <button @click="navigateTo(`/products/edit/${product.id}`)" class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-3 rounded font-medium w-1/3">Edit</button>
      <button @click="deleteProduct" class="bg-red-500 hover:bg-red-400 text-white px-4 py-3 rounded font-medium w-1/3">Delete</button>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  product: Object
})

const emit = defineEmits(['delete-product']);

const deleteProduct = () => {
  emit('delete-product', props.product.id);
};

</script>
