<template>
  <div>
    <Header />
    <slot />
  </div>
</template>

<script>
import Header from "../components/parts/Header";
export default {
  name: "default",
  components: {Header}
}
</script>
