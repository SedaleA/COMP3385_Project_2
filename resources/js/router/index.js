import { createRouter, createWebHistory } from 'vue-router'

import Home from '../pages/Home.vue'
import Register from '../pages/Register.vue'
import Login from '../pages/Login.vue'
import Logout from '../pages/Logout.vue'
import Explore from '../pages/Explore.vue'
import UserProfile from '../pages/UserProfile.vue'
import NewService from '../pages/NewService.vue'
import ServiceDetails from '../pages/ServiceDetails.vue'

const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/register', name: 'register', component: Register },
  { path: '/login', name: 'login', component: Login },
  { path: '/logout', name: 'logout', component: Logout },
  { path: '/explore', name: 'explore', component: Explore },
  { path: '/users/:user_id', name: 'user-profile', component: UserProfile },
  { path: '/services/new', name: 'new-service', component: NewService },
  { path: '/services/:service_id', name: 'service-details', component: ServiceDetails },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router