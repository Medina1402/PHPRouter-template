<template>
  <section id="login">
    <form class="form" @submit.prevent="logging">
      <Input :update-value.sync="email" leading-icon="face" placeholder="Email" type="email"/>
      <Input :update-value.sync="password" leading-icon="lock" placeholder="Password" type="password"/>
      <div class="align-option">
        <button class="button font-black" type="submit">INGRESAR</button>
<!--        <label class="align-option">-->
<!--          <span class="font-light legend-form-session">Mantener sesion</span>-->
<!--          <input type="checkbox" v-model="keepSession"/>-->
<!--        </label>-->
      </div>
    </form>
  </section>
</template>

<script lang="ts">
import {Component, Vue} from "vue-property-decorator";
import Input from "@/components/Input.vue";

@Component({
  components: { Input }
})
export default class Login extends Vue {
  email: string | null = null
  password: string | null = null
  keepSession: boolean = false

  logging() {
    this.$store.commit('logging')
  }
}
</script>

<style lang="scss">
@import "../assets/scss/sizes";

#login {
  display: flex;
  width: 100%;
  height: 100%;
}

.legend-form-session {
  font-size: 0.8rem;
  padding-right: 0.4rem;
}

.align-option {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.form {
  width: $size-xs;
  margin: auto;
  padding: 2rem;
  background-color: var(--theme-app-codebox-bg);

  .button {
    color: var(--color-gray-900);
    background-color: var(--color-orange-300);
    margin: 0.1rem;
    padding: 0.5rem 1rem;
    cursor: pointer;
  }
}

button {
  background-color: transparent;
}
</style>