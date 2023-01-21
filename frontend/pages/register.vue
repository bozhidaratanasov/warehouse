<template>
  <div class="flex justify-center">
    <div class="w-4/12 bg-white p-6 rounded-lg">
      <h1 class="text-center text-4xl text-blue-500 mb-4">Register</h1>
      <form @submit.prevent="register" class="space-y-6">
        <div class="text-center" v-if="errors">
          <p v-for="error in errors" :key="error" class="text-red-500">{{ error[0] }}</p>
        </div>
        <div>
          <label for="username" class="sr-only">Username</label>
          <input v-model="username"
                 type="text"
                 name="username"
                 id="username"
                 placeholder="Username"
                 required
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>

        <div>
          <label for="email" class="sr-only">Email</label>
          <input v-model="email"
                 type="email"
                 name="email"
                 id="email"
                 placeholder="Your email"
                 required
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>

        <div>
          <label for="phone" class="sr-only">Phone</label>
          <input v-model="phone"
                 type="phone"
                 name="phone"
                 id="phone"
                 placeholder="Your phone"
                 pattern="^[0-9\s-]+$"
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>

        <div>
          <label for="password" class="sr-only">Password</label>
          <input v-model="password"
                 type="password"
                 name="password"
                 id="name"
                 placeholder="Password"
                 required
                 pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,20}$"
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        </div>

        <div class="text-center">
          <label for="password_confirmation" class="sr-only">Confirm Password</label>
          <input v-model="confirmPassword"
                 type="password"
                 name="password_confirmation"
                 id="password_confirmation"
                 placeholder="Confirm password"
                 class="bg-gray-100 border-2 w-full p-4 rounded-lg mb-2">
          <nuxt-link to="/login" class="text-blue-400">Already have an account? Login now.</nuxt-link>

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
import axios from "axios";

useHead({
  title: 'Register'
})

const token = useCookie('token');

if (token.value)
  navigateTo('/products');

const username = ref(null);
const email = ref(null);
const phone = ref(null);
const password = ref(null);
const confirmPassword = ref(null);
const errors = ref(null)

const register = async () => {
  await axios.post('http://localhost:8000/api/register', {
    username: username.value,
    email: email.value,
    phone: phone.value,
    password: password.value,
    password_confirmation: confirmPassword.value
  }).then(() => {
    useNuxtApp().$toast.success('Successfully registered!', {
      transition: useNuxtApp().$toast.TRANSITIONS.SLIDE,
      autoClose: 4000
    });
    navigateTo('/login');
  }).catch(err => {
    errors.value = err.response.data.errors;
  })
}
</script>
