<template>
  <div class="flex justify-center">
    <div class="w-4/12 bg-white p-6 rounded-lg">
      <form @submit.prevent="login" class="space-y-6">
        <div>
          <label for="email" class="sr-only">Email</label>
          <input v-model="email"
                 type="email"
                 name="email"
                 id="email"
                 placeholder="Your email"
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>

        <div>
          <label for="password" class="sr-only">Password</label>
          <input v-model="password"
                 type="password"
                 name="password"
                 id="name"
                 placeholder="Password"
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>

        <div>
          <button type="submit"
                  class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-3 rounded font-medium w-full">
            Login
          </button>
        </div>
      </form>
    </div>
  </div>

</template>

<script setup>

const email = ref(null);
const password = ref(null);

const cookieToken = useCookie('token');
const token = useState('token');

const login = async () => {
  await $fetch('http://localhost:8000/api/login', {
    method: 'POST',
    body: {
      email: email.value,
      password: password.value
    }
  }).then(res => {
    cookieToken.value = res.data.token;
    token.value = res.data.token;
    navigateTo('/products');
  })
}
</script>
