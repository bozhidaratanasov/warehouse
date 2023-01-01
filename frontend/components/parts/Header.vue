<template>
  <nav class="p-6 bg-white flex justify-between">
    <ul class="flex items-center">
      <li class="hover:text-blue-500">
        <a class="p-3" href="/products">Dashboard</a>
      </li>
    </ul>

    <ul class="flex items-center">
      <li @click="logout" v-if="token" class="hover:text-blue-500">
        <a class="p-3" href="#">Logout</a>
      </li>
      <li v-if="!token" class="hover:text-blue-500">
        <a class="p-3" href="/register">Register</a>
      </li>
      <li v-if="!token" class="hover:text-blue-500">
        <a class="p-3" href="/login">Login</a>
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
    navigateTo('/login');
  });
}

</script>
