<template>
  <div class="setting-lab-calendar">
    <option-select :expand.sync="show_config" :update-value.sync="select_value" :options="options_example" label="Seleccionar docente"/>
    <div class="config" v-if="show_config">
      <h2 class="config-title">Configuracion</h2>
      <div class="config-legend">
        <h3>Identificador</h3>
        <p>{{select_value.value}}</p>
      </div>
      <div class="config-legend">
        <h3>Responsable</h3>
        <p>{{select_value.legend}}</p>
      </div>
      <div class="config-legend">
        <h3>Contacto</h3>
        <p>{{select_value.contact}}</p>
      </div>
      <button :aria-label="edit_calendar" class="font-black btn-edit" @click="toggle_edit_calendar">
        <span v-if="!edit_calendar">EDITAR CALENDAR</span>
        <span v-else>CANCELAR EDIT</span>
      </button>
      <div v-if="edit_calendar">
        <!-- TODO Selector por registro para docente<>laboratorio -->
        <button class="font-black btn-save">SAVE changes</button>
      </div>
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
  edit_calendar = false
  options_example = [
    {legend: 'Maestro 1', value:'4c2z112x3', contact:"pedro@gmail.com"},
    {legend: 'Maestro 2', value:'x3123x1xr', contact:"664 162 87 45"},
    {legend: 'Maestro 3', value:'_mw21xs2s', contact:"Cubiculo 34 feyri"},
    {legend: 'Maestro 4', value:'_1x314x12', contact:"-"}
  ]

  @Watch("show_config")
  watch_toggle_calendar() {
    if ( !this.show_config ) this.edit_calendar = false
  }

  @Watch("edit_calendar")
  watch_edit_calendar() {
    this.$emit("update:edit-calendar", this.edit_calendar)
    this.$emit("update:select-value", this.select_value)
  }

  toggle_edit_calendar() {
    this.edit_calendar = !this.edit_calendar
  }
}
</script>

<style lang="scss">
.setting-lab-calendar {
  width: 18rem;
  margin: 1rem 1rem 1rem 0;
}

.config-legend {
  margin-bottom: 1rem;

  h3 {
    color: var(--color-whiteAlpha-500);
    font-weight: lighter;
  }
}

.config {
  margin-top: 2rem;

  button {
    font-size: 0.6rem;
    text-transform: uppercase;
    cursor: pointer;
    color: var(--color-gray-900);
  }

  .btn-save {
    width: 100%;
    height: 3rem;
    border: 0.2rem solid var(--color-orange-300);
    color: var(--color-orange-300);
  }

  .btn-edit {
    padding: 0.5rem;
    width: 100%;
    height: 3rem;
    margin: 1rem 0 1.5rem 0;
    background-color: var(--color-orange-300);

    span {
      color: var(--color-gray-900);
    }
  }

  [aria-label="true"] {
    background-color: var(--color-orange-400);
  }
}

.config-title {
  text-align: center;
  margin-bottom: 1rem;
}
</style>