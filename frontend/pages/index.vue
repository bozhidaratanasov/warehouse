<template>
  <div></div>
</template>

<script setup>

const cookieToken = useCookie('token');
if (cookieToken.value)
  navigateTo('/products');

else
  navigateTo('/login');

</script>

<style scoped>

</style>