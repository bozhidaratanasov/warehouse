<template>
  <div class="px-10">
    <div class="mb-10 flex justify-between">
      <div class="space-x-6">
        <select class="border-2 p-1 rounded-lg">
          <option>Всички</option>
          <option>Хранителни стоки</option>
          <option>Канцеларски материали</option>
          <option>Строителни материали</option>
        </select>

        <input type="text" class="border-2 p-1 rounded-lg">
        <button class="bg-blue-500 hover:bg-blue-400 text-white p-1 rounded font-medium">Search</button>
      </div>
      <div>
        <nuxt-link to="/products/create" class="bg-blue-500 hover:bg-blue-400 text-white p-2 rounded font-medium">Add New</nuxt-link>
      </div>


    </div>
    <div class="grid grid-cols-3 gap-10">

      <ProductItem
          v-for="product in products"
          :key="product.id"
          :product="product"
          @delete-product="deleteProduct"/>
    </div>
  </div>
</template>

<script setup>
import ProductItem from "../../components/products/ProductItem";
useHead({
  title: 'Products'
})

const token = useState('token');

if (!token.value)
  navigateTo('/login');

const products = ref([]);

const getProducts = async () => {
  await $fetch('http://localhost:8000/api/products', {
    method: 'GET',
    headers: {
      'Authorization': 'Bearer ' + token.value
    }
  }).then(res => {
    products.value = res.data;
  })
};

await getProducts();

const deleteProduct = async (productId) => {
  await $fetch(`http://localhost:8000/api/products/${productId}`, {
    method: 'DELETE',
    headers: {
      'Authorization': 'Bearer ' + token.value
    }
  }).then(async () => {
    await getProducts();
  })
};

</script>
