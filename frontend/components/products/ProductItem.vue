<template>
  <div class="col-span-1 bg-white rounded-md">
    <img class="w-full h-72 rounded-md" v-if="product.attributes.image"
         :src="'http://localhost:8000' + product.attributes.image">
    <img class="w-full h-72 rounded-md" v-else src="~/assets/elementor-placeholder-image.webp"/>
    <div class="mt-4 px-4 space-y-4">
      <div class="flex justify-between items-center">
        <h2 class="text-3xl font-bold">{{ product.attributes.title }}</h2>
        <p>{{ product.attributes.code }}</p>
      </div>
      <div class="flex justify-between">
        <p>{{ product.attributes.category }}</p>
        <p>{{ product.attributes.quantity }}</p>
      </div>
      <div class="flex justify-between">
        <p>{{ product.attributes.buying_price }}$</p>
        <p>{{ product.attributes.selling_price }}$</p>
      </div>
      <div v-if="product.attributes.description" class="h-36">{{
          product.attributes.description.length > 300 ? product.attributes.description.slice(0, 300) + '...' : product.attributes.description
        }}
      </div>
      <div v-else class="h-36">No Description.</div>
    </div>
    <div class="text-center space-x-20 my-4">
      <button @click="navigateTo(`/products/edit/${product.id}`)"
              class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-3 rounded font-medium w-1/3">Edit
      </button>
      <button @click="deleteProduct" class="bg-red-500 hover:bg-red-400 text-white px-4 py-3 rounded font-medium w-1/3">
        Delete
      </button>
    </div>
  </div>
</template>

<script setup>
import Swal from 'sweetalert2'

const props = defineProps({
  product: Object
})

const emit = defineEmits(['delete-product']);

const deleteProduct = () => {
  emit('delete-product', props.product.id);
};

</script>
