<template>
  <section id="admin">
    <h1>Admin</h1>
    <hr>
    <h1>Labs</h1>
    <hr>
    <h1>Users</h1>
  </section>
</template>

<script lang="ts">
import {Component, Vue} from "vue-property-decorator";

@Component({})
export default class Admin extends Vue {}
</script>

<style lang="scss">
#admin {
  width: 90%;
  margin: auto;
  padding-top: 2rem
}
</style>