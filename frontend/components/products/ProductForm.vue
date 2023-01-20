<template>
  <div class="flex justify-center">
    <div class="w-4/12 bg-white p-6 rounded-lg">
      <h1 class="text-center text-3xl text-blue-500 mb-4">{{ productId ? 'Edit Product' : 'Create Product'}}</h1>
      <form @submit.prevent="submit" class="space-y-6">
        <div>
          <label for="title" class="sr-only">Title</label>
          <input v-model="title"
                 type="text"
                 name="title"
                 id="title"
                 placeholder="Title"
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
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>

        <div>
          <label for="selling-price" class="sr-only">Selling Price</label>
          <input v-model="sellingPrice"
                 type="number"
                 name="selling-price"
                 id="selling-price"
                 placeholder="Selling Price"
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>

        <div>
          <label for="quantity" class="sr-only">Quantity</label>
          <input v-model="quantity"
                 type="number"
                 name="quantity"
                 id="quantity"
                 placeholder="Quantity"
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>

        <div>
          <label for="image" class="sr-only">Image</label>
          <input type="file"
                 name="image"
                 id="image"
                 placeholder="Image"
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>
        <div>
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
const token = useState('token');
const route = useRoute();
const productId = route.params.id;

const title = ref(null);
const description = ref(null);
const code = ref(null);
const category = ref('Хранителни стоки');
const buyingPrice = ref(null);
const sellingPrice = ref(null);
const quantity = ref(null);
const image = ref(null);

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
  })
}

const submit = async () => {
  if (productId)
    await editProduct();

  else
    await createProduct();
}

const createProduct = async () => {
  await $fetch('http://localhost:8000/api/products', {
    method: 'POST',
    body: {
      title: title.value,
      description: description.value,
      code: code.value,
      category: category.value,
      buying_price: buyingPrice.value,
      selling_price: sellingPrice.value,
      quantity: quantity.value
    },
    headers: {
      'Authorization': 'Bearer ' + token.value
    }
  }).then(() => {
    navigateTo('/products');
  })
}

const editProduct = async () => {
  await $fetch(`http://localhost:8000/api/products/${productId}`, {
    method: 'PUT',
    body: {
      title: title.value,
      description: description.value,
      code: code.value,
      category: category.value,
      buying_price: buyingPrice.value,
      selling_price: sellingPrice.value,
      quantity: quantity.value
    },
    headers: {
      'Authorization': 'Bearer ' + token.value
    }
  }).then(() => {
    navigateTo('/products');
  })
}
</script>
