<template>
  <nav class="p-6 bg-white flex justify-between">
    <ul class="flex items-center">
      <li v-if="token" class="hover:text-blue-500">
        <nuxt-link class="p-3" to="/products">Dashboard</nuxt-link>
      </li>
    </ul>

    <ul class="flex items-center">
      <li @click="logout" v-if="token" class="hover:text-blue-500">
        <nuxt-link class="p-3" to="#">Logout</nuxt-link>
      </li>
      <li v-if="!token" class="hover:text-blue-500">
        <nuxt-link class="p-3" to="/register">Register</nuxt-link>
      </li>
      <li v-if="!token" class="hover:text-blue-500">
        <nuxt-link class="p-3" to="/login">Login</nuxt-link>
      </li>
    </ul>
  </nav>
</template>

<script setup>

const cookieToken = useCookie('token')
const token = useState('token');

if (cookieToken.value)
  token.value = cookieToken.value;

const logout = async () => {

  await $fetch('http://localhost:8000/api/logout', {
    method: 'POST',
    headers: {
      'Authorization': 'Bearer ' + token.value
    }
  }).then(() => {
    cookieToken.value = null;
    token.value = null;
    useNuxtApp().$toast.success('Successfully logged out!', {
      transition: useNuxtApp().$toast.TRANSITIONS.SLIDE,
      autoClose: 4000
    });
    navigateTo('/login');
  });
}

</script>
