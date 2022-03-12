<template>
  <section id="calendar">
    <Calendar lab_id="0" lab_description="LAB 243" start_time="8" end_time="16"/>
  </section>
</template>

<script lang="ts">
import {Component, Vue} from "vue-property-decorator";
import Calendar from "../components/Calendar/Calendar.vue";

@Component({
  components: {Calendar}
})
export default class About extends Vue {}
</script>

<style lang="scss">
#calendar {
  width: 90%;
  margin: auto;
  padding-top: 2rem
}
</style>