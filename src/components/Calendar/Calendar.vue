<template>
  <div class="calendar">
    <div class="calendar-description">
      <button id="settings" @click="toggleSetting" class="font-black" title="Settings">
        <box-icon type="solid" color="var(--color-orange-300)" name="cog"/>
        <span>{{ lab_description }}</span>
      </button>
      <h2 class="font-black">
        {{ this.months[current_month].toUpperCase() }} ({{ current_year }}) - SEMANA {{ current_week }}
      </h2>
      <div class="controls">
        <button @click="backWeek" class="font-black">anterior</button>
        <button @click="nextWeek" class="font-black">siguiente</button>
      </div>
    </div>

    <div class="table">
      <SettingsLabCalendar v-if="showSetting"/>
      <div class="content">
        <div class="time">
          <div class="row-head"></div>
          <div class="box" v-for="time in (end_time - start_time)">
            {{ time + parseInt(start_time + "") }}:00
          </div>
        </div>
        <div class="days">
          <div class="row-days" v-if="selectValidDays(index)" v-for="(day, index) in days" :key="'_' + index"
               :aria-selected="isDateValid(index)" :id="current_week + '_' + days_week[index]">
            <div class="row-head">{{ getDaysFormat(index) }}</div>
            <BoxCalendar class="box" v-for="time in (end_time - start_time)"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" src="./Calendar.scss"></style>
<script lang="ts">
import CalendarComponent from "@/components/Calendar/Calendar";
import {Component, Watch} from "vue-property-decorator";
import BoxCalendar from "@/components/BoxCalendar.vue";
import SettingsLabCalendar from "@/components/SettingsLabCalendar.vue";

@Component({
  components: {SettingsLabCalendar, BoxCalendar }
})
export default class Calendar extends CalendarComponent {
  showSetting = false
  current_date?: number

  mounted() {
    this.days_for_week()
    this.current_date = (this.current_week * 7) + (new Date().getDate() % 7)
  }

  toggleSetting() {
    this.showSetting = !this.showSetting
  }

  isDateValid(date: number) {
    return (this.current_date) ?(this.current_week * 7) + date > this.current_date :false
  }

  getDaysFormat(date: number, length?: number) {
    if ( !length ) length = this.days[date].length
    return `${this.days[date].substr(0, length)} (${this.days_week[date]})`
  }

  selectValidDays(index: number) {
    return index !== 0 && index !== 6
  }
}
</script>
