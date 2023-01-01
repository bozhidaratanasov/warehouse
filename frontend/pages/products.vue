<template>
  <div class="grid grid-cols-3 gap-10 px-10">
    <ProductItem
        v-for="product in products"
        :key="product.id"
        :product="product"/>
    <button @click="products.pop()">cloc</button>
  </div>
</template>

<script setup>
import ProductItem from "../components/products/ProductItem";

const token = useState('token');

if (!token.value)
  navigateTo('/login');

const products = ref([]);

await $fetch('http://localhost:8000/api/products', {
  method: 'GET',
  headers: {
    'Authorization': 'Bearer ' + token.value
  }
}).then(res => {
  products.value = res.data;
})

// console.log(products)
// const getProducts = async () => {
//   console.log(products)
// }
//
// await getProducts()

</script>
