<template>
  <div class="calendar">
    <div class="calendar-description">
      <h2 class="font-black" title="Configuracion">
        <box-icon type="solid" color="var(--color-orange-300)" name="cog"/>
        <span>{{ lab_description }}</span>
      </h2>
      <h2 class="font-black">{{ this.months[current_month].toUpperCase() }} ({{ current_year }}) - SEMANA {{ current_week }}</h2>
      <div class="controls">
        <button @click="backWeek" class="font-black">anterior</button>
        <button @click="nextWeek" class="font-black">siguiente</button>
      </div>
    </div>

    <table>
      <thead>
        <tr>
          <th></th>
          <th v-if="selectValidDays(index)" v-for="(day, index) in days" :key="'_' + index">
            {{ day }} ({{days_week[index]}})
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="time in (end_time - start_time)">
          <th style="text-align: right">{{ time + parseInt(start_time + "") }}:00</th>
          <th class="cell" v-if="selectValidDays(index)" :id="createCellId(index, time, start_time)"
              @click="selected(createCellId(index, time, start_time))"
              v-for="(day, index) in days" :key="'_' + index"></th>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style lang="scss" src="./Calendar.scss"></style>
<script lang="ts">
import CalendarComponent from "@/components/Calendar/Calendar";
import {Component, Watch} from "vue-property-decorator";

@Component({})
export default class Calendar extends CalendarComponent {
  selectValidDays(index: number) {
    return index !== 0 && index !== 6
  }

  createCellId(index: number, time: number, start_time: number) {
    return '_' + this.current_week + '_' + index + '_' + (time + start_time)
  }

  @Watch("current_week", { immediate: true, deep: true })
  clearCalendar() {
    let all_cells = document.querySelectorAll("th")
    all_cells.forEach(cell => cell.style.backgroundColor = "")
  }

  selected(id: string) {
    let item: any = document.getElementById(id)
    if (item.style.backgroundColor == "red") item.style.backgroundColor = ""
    else item.style.backgroundColor = "red"
  }
}
</script>
