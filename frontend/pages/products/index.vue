<template>
  <div class="px-10">
    <div class="mb-10 flex justify-between">
      <div v-if="products.length > 0 || filtered" class="space-x-6">
        <select v-model="category" class="border-2 p-1 rounded-lg">
          <option>Всички</option>
          <option>Хранителни стоки</option>
          <option>Канцеларски материали</option>
          <option>Строителни материали</option>
        </select>

        <input v-model="code" type="text" placeholder="Code" class="border-2 p-1 rounded-lg">
        <button @click="filterProducts" class="bg-blue-500 hover:bg-blue-400 text-white p-1 rounded font-medium">
          Search
        </button>
        <button v-if="filtered" @click="clearFilter"
                class="bg-red-500 hover:bg-red-400 text-white p-1 rounded font-medium">
          Clear
        </button>
      </div>
      <div v-else></div>
      <div>
        <nuxt-link to="/products/create" class="bg-blue-500 hover:bg-blue-400 text-white p-2 rounded font-medium">Add
          New
        </nuxt-link>
      </div>


    </div>
    <div v-if="products.length > 0" class="grid grid-cols-3 gap-10">
      <ProductItem
          v-for="product in products"
          :key="product.id"
          :product="product"
          @delete-product="deleteProduct"/>
    </div>
    <div v-else class="text-center text-4xl font-bold">No products</div>
  </div>
</template>

<script setup>
import ProductItem from "../../components/products/ProductItem";
import Swal from "sweetalert2";

useHead({
  title: 'Products'
})

const token = useState('token');

if (!token.value)
  navigateTo('/login');

const categoryState = useState('category');
const codeState = useState('code');

const products = ref([]);
const code = ref('');
const category = ref('Всички');
const filtered = ref(false);

if (categoryState.value)
  category.value = categoryState.value;

if (codeState.value)
  code.value = codeState.value;

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

const deleteProduct = async (productId) => {
  Swal.fire({
    title: 'Delete Product',
    text: 'Are you sure you want to delete this product?',
    icon: 'error',
    confirmButtonText: 'Yes',
    showCancelButton: true,
    cancelButtonText: 'Cancel'
  }).then(async ({isConfirmed}) => {
    if (isConfirmed) {
      await $fetch(`http://localhost:8000/api/products/${productId}`, {
        method: 'DELETE',
        headers: {
          'Authorization': 'Bearer ' + token.value
        }
      }).then(async () => {
        await filterProducts();
        useNuxtApp().$toast.success('Product successfully deleted!', {
          transition: useNuxtApp().$toast.TRANSITIONS.SLIDE,
          autoClose: 4000
        });
      });
    }
  })
};

const filterProducts = async () => {
  await getProducts();
  if (code.value) {
    products.value = products.value.filter(product => product.attributes.code.includes(code.value));
    codeState.value = code.value;
    categoryState.value = null;
    category.value = 'Всички';
    filtered.value = true;
  } else {
    if (category.value === 'Всички') {
      await getProducts();
      filtered.value = false;
    } else {
      products.value = products.value.filter(product => product.attributes.category === category.value);
      categoryState.value = category.value;
      filtered.value = true;
    }
    codeState.value = null;
  }
};

const clearFilter = async () => {
  await getProducts();
  category.value = 'Всички';
  code.value = '';
  codeState.value = null;
  categoryState.value = null;
  filtered.value = false;
};

await filterProducts();



</script>
