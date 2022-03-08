<template>
  <div style="width: 90%; margin: auto; padding-top: 2rem">
    <Calendar start_time="8" end_time="16" lab_description="LAB 243"/>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from "vue-property-decorator";
import Calendar from "../components/Calendar.vue";

@Component({
  components: {Calendar}
})
export default class About extends Vue {}
</script>