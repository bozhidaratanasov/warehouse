<template>
  <div class="flex justify-center">
    <div class="w-4/12 bg-white p-6 rounded-lg">
      <form @submit.prevent="register" class="space-y-6">
        <div>
          <label for="username" class="sr-only">Username</label>
          <input v-model="username"
                 type="text"
                 name="username"
                 id="username"
                 placeholder="Username"
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>

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
          <label for="phone" class="sr-only">Phone</label>
          <input v-model="phone"
                 type="phone"
                 name="phone"
                 id="phone"
                 placeholder="Your phone"
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
          <label for="password_confirmation" class="sr-only">Confirm Password</label>
          <input v-model="confirmPassword"
                 type="password"
                 name="password_confirmation"
                 id="password_confirmation"
                 placeholder="Confirm password"
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>
        <div>
          <button type="submit"
                  class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-3 rounded font-medium w-full">
            Register
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
useHead({
  title: 'Register'
})

const username = ref(null);
const email = ref(null);
const phone = ref(null);
const password = ref(null);
const confirmPassword = ref(null);

const token = useCookie('token');

if (token.value)
  navigateTo('/products');

const register = async () => {
  await $fetch('http://localhost:8000/api/register', {
    method: 'POST',
    body: {
      username: username.value,
      email: email.value,
      phone: phone.value,
      password: password.value,
      password_confirmation: confirmPassword.value
    }
  }).then(res => {
    token.value = res.data.token;
  })
}
</script>
