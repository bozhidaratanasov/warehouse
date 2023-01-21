<template>
  <div>
    <Header />
    <slot />
    <Footer/>
  </div>
</template>

<script>
import Header from "../components/parts/Header";
import Footer from "../components/parts/Footer";
export default {
  name: "default",
  components: {Footer, Header}
}
</script>
