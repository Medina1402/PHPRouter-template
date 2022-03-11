<template>
  <div class="setting-lab-calendar">
    <option-select :expand.sync="show_config" :update-value.sync="select_value" :options="options_example" label="Seleccionar docente"/>
    <div class="config" v-if="show_config">
      <h2 class="config-title">Configuracion</h2>
      <p>Docente: {{select_value.legend}}</p>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Vue, Watch} from "vue-property-decorator";
import OptionSelect from "@/components/OptionSelect.vue";

@Component({
  components: {OptionSelect}
})
export default class SettingsLabCalendar extends Vue {
  select_value: any = null
  show_config: boolean = false

  options_example = [
    {legend: 'Maestro 1', value:'4c2z112x3'},
    {legend: 'Maestro 2', value:'x3123x1xr'},
    {legend: 'Maestro 3', value:'_mw21xs2s'},
    {legend: 'Maestro 4', value:'_1x314x12'}
  ]
}
</script>

<style lang="scss">
.setting-lab-calendar {
  width: 18rem;
  margin: 1rem 1rem 1rem 0;
}

.config {
  margin-top: 2rem;
}

.config-title {
  text-align: center;
}
</style>