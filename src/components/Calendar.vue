<template>
  <div class="calendar">
    <div class="calendar-description">
      <h2 class="font-black">{{ lab_description }}</h2>
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
          <th v-for="(day, index) in days" :key="'_' + index">{{ day }} ({{days_week[index]}})</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="time in (end_time - start_time)">
          <th style="text-align: right">{{ time + parseInt(start_time + "") }}:00</th>
          <th class="cell" v-for="(day, index) in days" :key="'_' + index"></th>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";

@Component({})
export default class Calendar extends Vue {
  months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
  days = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"]

  @Prop({required: true}) lab_description!: string
  @Prop({required: true}) start_time!: number
  @Prop({required: true}) end_time!: number

  current_year!: number
  current_month!: number
  current_week = this.week
  days_week: number[] = []

  mounted() {
    this.days_for_week()
  }

  get week() {
    let current_date: any = new Date()
    let one_jan: any = new Date(current_date.getFullYear(),0,1)
    let numberOfDays = Math.floor((current_date - one_jan) / (24 * 60 * 60 * 1000))
    // Render: Load Current Year
    this.updateDate(current_date)
    return Math.ceil((current_date.getDay() + 1 + numberOfDays) / 7)
  }

  updateDate(current_date: Date) {
    this.current_year = current_date.getUTCFullYear()
    this.current_month = current_date.getMonth()
  }

  days_for_week() {
    let current_date = new Date(new Date(new Date().getFullYear(),0,1))
    // Get first day for the week
    current_date.setDate(7 * (this.current_week - 1) + 2)
    let start_date = current_date.getDate()
    this.updateDate(current_date)

    // Get last day for the week
    current_date.setDate(7 * (this.current_week - 1) + 10)
    const end_date = current_date.getDate()

    // Last day watch for change month
    const top_day_month = new Date(new Date(new Date().getFullYear(),this.current_month + 1, 0)).getDate()

    // Create Array for days of week
    let result = []
    if (start_date > end_date) {
      for (let current = start_date; current <= top_day_month; current++) result.push(current)
      start_date = 1 // Change month
    }
    for (let current = start_date; current <= end_date + 1; current++) result.push(current)

    this.days_week = result

  }

  backWeek() {
    if ( this.current_week <= 1 ) {
      this.current_week = 52
      this.current_year--
    } else this.current_week--
    this.days_for_week()
  }

  nextWeek() {
    if ( this.current_week >= 52 ) {
      this.current_week = 1
      this.current_year++
    } else this.current_week++
    this.days_for_week()
  }
}
</script>

<style lang="scss">
.cell {
  &:hover {
    background-color: var(--color-whiteAlpha-50);
  }
}

.calendar-description {
  display: flex;
  align-items: center;
  justify-content: space-between;

  h2 {
    font-size: 1.3rem;
    &:nth-child(2) {
      text-decoration: underline;
      text-decoration-color: var(--color-orange-300);
      text-decoration-thickness: 0.1rem;
      text-underline-offset: 0.3rem;
    }
  }
}

.controls {
  display: grid;
  gap: 0.5rem;
  grid-template-columns: 1fr 1fr;

  button {
    font-size: 0.6rem;
    padding: 0.5rem;
    color: var(--color-gray-900);
    background-color: var(--color-orange-300);
    text-transform: uppercase;
    cursor: pointer;
  }
}

table {
  width: 100%;
}

th {
  height: 3rem;
  user-select: none;
  &:first-child {
    width: 2rem;
  }
}
</style>
