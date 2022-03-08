<template>
  <div class="input">
    <div class="input-container" :class="classInput">
      <label class="input-label">
        <box-icon class="leading-icon" v-if="leadingIcon" :name="leadingIcon"/>
        <input
            :placeholder="placeholder" :id="id" :name="name" :type="type" :required="required"
            @change="$emit('update:update-value', $event.target.value)"/>
      </label>
      <box-icon class="trailing-icon" v-if="trailingIcon" :name="trailingIcon"/>
    </div>
    <div class="input-helper" v-if="helper">
      <span v-if="!helperMessage" style="color: transparent; user-select: none">_</span>{{helperMessage}}
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";

@Component({})
export default class Input extends Vue {
  @Prop({}) classInput!: string

  @Prop({}) leadingIcon!: string
  @Prop({}) trailingIcon!: string

  @Prop({}) id!: string
  @Prop({}) name!: string
  @Prop({}) placeholder!: string
  @Prop({}) type!: string
  @Prop({ default: true }) required!: boolean

  @Prop({}) helper!: boolean
  @Prop({}) helperMessage!: string
}
</script>

<style lang="scss">
.trailing-icon {
  cursor: pointer;
}

.input {
  margin: 1rem 0;

  .input-helper {
    font-size: 0.65rem;
    margin: 0.1rem 0.5rem;
    opacity: 0.5;
    font-weight: bold;
  }

  .input-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    user-select: none;
    padding: 0 0.5rem;
    background-color: var(--color-whiteAlpha-700);

    .input-label {
      display: flex;
      align-items: center;
      width: 100%;

      input {
        width: 100%;
        font-size: 1rem;
        padding: 0.3rem;
        margin: 0.5rem 0 0.5rem 0.5rem;
        background-color: transparent;

        color: var(--color-gray-900);
      }
    }
  }
}
</style>