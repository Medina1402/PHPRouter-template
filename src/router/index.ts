import Vue from 'vue'
import VueRouter, { RouteConfig } from 'vue-router'
import Home from '../views/Home.vue'
import Calendar from "@/views/Calendar.vue";
import Admin from "@/views/Admin.vue";
import Error from "@/views/Error.vue";

Vue.use(VueRouter)

const routes: Array<RouteConfig> = [
  { path: '/', name: 'Home', component: Home },
  { path: '/calendar', name: 'Calendar', component: Calendar },
  { path: '/admin', name: 'Admin', component: Admin },
  { path: '/*', name: 'Error', component: Error }
]

const router = new VueRouter({
  mode: 'hash',
  base: process.env.BASE_URL,
  routes
})

export default router
