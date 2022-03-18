<template>
  <div id="app">
    <Header/>
    <router-view/>
    <Login/>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from "vue-property-decorator";
import Header from "@/components/Header.vue";
import Login from '@/views/Login.vue';

@Component({
  components: {Login, Header}
})
export default class App extends Vue {
  get isLogin(): boolean {
    return this.$store.getters.isLogged
  }
}
</script>

<style lang="scss">
@import "./assets/scss/global.scss";

#app {
  width: 100vw;
  height: 100vh;
}
</style>