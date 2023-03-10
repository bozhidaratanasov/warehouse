<template>
  <div class="flex justify-center">
    <div class="w-4/12 bg-white p-6 rounded-lg">
      <h1 class="text-center text-4xl text-blue-500 mb-4">{{ productId ? 'Edit Product' : 'Create Product' }}</h1>
      <form @submit.prevent="submit" class="space-y-6">
        <div class="text-center" v-if="errors">
          <p v-for="error in errors" :key="error" class="text-red-500">{{ error[0] }}</p>
        </div>
        <div>
          <label for="title" class="sr-only">Title</label>
          <input v-model="title"
                 type="text"
                 name="title"
                 id="title"
                 placeholder="Title"
                 required
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>

        <div>
          <label for="description" class="sr-only">Description</label>
          <textarea v-model="description"
                    name="description"
                    id="description"
                    placeholder="Description"
                    class="bg-gray-100 border-2 w-full p-4 rounded-lg">
          </textarea>
        </div>

        <div>
          <label for="code" class="sr-only">Code</label>
          <input v-model="code"
                 type="text"
                 name="code"
                 id="code"
                 placeholder="Code"
                 required
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>

        <div>
          <label for="category" class="sr-only">Category</label>
          <select v-model="category" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
            <option>Хранителни стоки</option>
            <option>Канцеларски материали</option>
            <option>Строителни материали</option>
          </select>
        </div>

        <div>
          <label for="buying-price" class="sr-only">Buying Price</label>
          <input v-model="buyingPrice"
                 type="number"
                 name="buyingPrice"
                 id="buyingPrice"
                 placeholder="Buying price"
                 step=".01"
                 required
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>

        <div>
          <label for="selling-price" class="sr-only">Selling Price</label>
          <input v-model="sellingPrice"
                 type="number"
                 name="selling-price"
                 id="selling-price"
                 placeholder="Selling Price"
                 step=".01"
                 required
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>

        <div>
          <label for="quantity" class="sr-only">Quantity</label>
          <input v-model="quantity"
                 type="number"
                 name="quantity"
                 id="quantity"
                 placeholder="Quantity"
                 required
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>

        <div>
          <label for="image" class="sr-only">Image</label>
          <input type="file"
                 name="image"
                 id="image"
                 placeholder="Image"
                 accept=".jpeg,.jpg,.png"
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg"
                 @change="setFile">
        </div>
        <div class="flex justify-between space-x-12">
          <button type="button"
                  class="bg-red-500 hover:bg-red-400 text-white px-4 py-3 rounded font-medium w-full"
                  @click="navigateTo('/products')">
            Cancel
          </button>
          <button type="submit"
                  class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-3 rounded font-medium w-full">
            {{ productId ? 'Edit' : 'Create' }}
          </button>
        </div>
      </form>
    </div>
  </div>

</template>

<script setup>
import axios from 'axios';

const token = useState('token');
const route = useRoute();
const productId = route.params.id;

const title = ref('');
const description = ref('');
const code = ref('');
const category = ref('Хранителни стоки');
const buyingPrice = ref('');
const sellingPrice = ref('');
const quantity = ref('');
const image = ref(null);
const errors = ref(null);

if (productId) {
  await $fetch(`http://localhost:8000/api/products/${productId}`, {
    method: 'GET',
    headers: {
      'Authorization': 'Bearer ' + token.value
    }
  }).then(res => {
    const data = res.data.attributes;
    title.value = data.title;
    description.value = data.description;
    code.value = data.code;
    category.value = data.category;
    buyingPrice.value = data.buying_price;
    sellingPrice.value = data.selling_price;
    quantity.value = data.quantity;
  });
}

const setFile = (event) => {
  image.value = event.target.files[0];
};

const submit = async () => {
  if (productId)
    await editProduct();

  else
    await createProduct();
};

const createProduct = async () => {
  const formData = new FormData();
  formData.append('title', title.value);
  formData.append('description', description.value);
  formData.append('code', code.value);
  formData.append('category', category.value);
  formData.append('buying_price', buyingPrice.value);
  formData.append('selling_price', sellingPrice.value);
  formData.append('quantity', quantity.value);

  if (image.value)
    formData.append('image', image.value);

  await axios.post('http://localhost:8000/api/products', formData, {
    headers: {
      'Authorization': 'Bearer ' + token.value
    }
  }).then(() => {
    useNuxtApp().$toast.success('Product successfully created!', {
      transition: useNuxtApp().$toast.TRANSITIONS.SLIDE,
      autoClose: 4000
    });
    navigateTo('/products');
  }).catch(err => {
    errors.value = err.response.data.errors;
    console.log(errors.value)
  })
};

const editProduct = async () => {
  const formData = new FormData();
  formData.append('title', title.value);
  formData.append('description', description.value);
  formData.append('code', code.value);
  formData.append('category', category.value);
  formData.append('buying_price', buyingPrice.value);
  formData.append('selling_price', sellingPrice.value);
  formData.append('quantity', quantity.value);
  formData.append('_method', 'PUT')

  if (image.value)
    formData.append('image', image.value);

  await axios.post(`http://localhost:8000/api/products/${productId}`, formData, {
    headers: {
      'Authorization': 'Bearer ' + token.value
    }
  }).then(() => {
    useNuxtApp().$toast.success('Product successfully edited!', {
      transition: useNuxtApp().$toast.TRANSITIONS.SLIDE,
      autoClose: 4000
    });
    navigateTo('/products');
  }).catch(err => {
    errors.value = err.response.data.errors;
    console.log(errors.value)
  })
};
</script>
