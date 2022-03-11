<template>
  <div class="option-select">
    <div @click="toggleShowOptions" class="select">
      <span>{{ label }}</span>
      <box-icon color="var(--color-orange-300)" name="chevron-down"/>
    </div>
    <div v-if="show_options" class="options">
      <div :aria-label="option.value" @click="bindingValue" class="option" v-for="(option, index) in options" :key="'_' + index">
        {{option.legend}}
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";

@Component({})
export default class OptionSelect extends Vue {
  show_options: boolean = false

  toggleShowOptions() {
    this.$emit("update:expand", false)
    this.show_options = !this.show_options
  }

  bindingValue(event: any) {
    this.$emit("update:update-value", {
      legend: event.target.textContent,
      value: event.target.getAttribute("aria-label")
    })
    this.toggleShowOptions()
    this.$emit("update:expand", true)
  }

  @Prop({required: true}) label?: string
  @Prop({required: true}) options?: {value: any, legend: string}[]
  @Prop({}) value?: any
  @Prop({}) expand?: any
}
</script>

<style lang="scss">
.select {
  user-select: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: calc(100% - 2rem);
  height: 2rem;
  padding: 0.5rem 1rem;
  background-color: var(--color-whiteAlpha-50);
}

.options {
  user-select: none;
  width: calc(100% - 2rem);
  padding: 0.5rem 1rem;
  background-color: var(--color-whiteAlpha-50);
}

.option {
  background-color: var(--color-whiteAlpha-50);
  display: flex;
  align-items: center;
  justify-content: center;
  height: 2rem;
  margin-bottom: 0.5rem;
  cursor: pointer;

  &:hover {
    background-color: var(--color-whiteAlpha-200);
  }
}
</style>
