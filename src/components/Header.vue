<template>
  <header class="header">
    <nav id="nav">
      <router-link to="/" class="title font-black">FEYRI Labs</router-link>
      <router-link to="/admin">Admin</router-link>
      <router-link to="/calendar">Calendar</router-link>
    </nav>
    <button style="cursor: pointer" class="font-black" @click="logout">LogOut</button>
  </header>
</template>

<script lang="ts">
import {Component, Vue} from "vue-property-decorator";

@Component({})
export default class Header extends Vue {
  logout() {
    this.$store.commit('logout')
  }
}
</script>

<style lang="scss">
.header {
  height: 3.5rem;
  padding: 0 2rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  backdrop-filter: blur(20px);
  position: sticky;
  top: 0;
  z-index: 2;

  &::before {
    content: " ";
    position: absolute;
    opacity: 0.5;
    width: 100%;
    height: 100%;
    left: 0;
    background-color: var(--theme-app-bg);
    z-index: -1;
  }
}

nav {
  a {
    &:hover {
      color: var(--color-orange-300);
      text-decoration: underline;
      text-decoration-color: var(--color-orange-300);
      text-decoration-thickness: 0.1rem;
      text-underline-offset: 0.3rem;
    }
    &:not(:first-child) {
      margin-right: 1rem;
    }
  }
}

.title {
  margin-right: 2rem;
}
</style>