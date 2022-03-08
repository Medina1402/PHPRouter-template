<template>
  <div id="app">
    <Application v-if="isLogin"/>
    <Login v-else/>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from "vue-property-decorator";
import Login from '@/views/Login.vue';
import Application from "@/components/Application.vue";

@Component({
  components: {Application, Login }
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