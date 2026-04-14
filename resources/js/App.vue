<template>
  <div class="app-shell">
    <header class="topbar">
      <div class="brand">UniGigs</div>

      <nav class="nav-links">
        <router-link to="/">Home</router-link>
        <router-link to="/register">Register</router-link>
        <router-link to="/login">Login</router-link>
        <router-link to="/logout">Logout</router-link>
        <router-link to="/explore">Explore</router-link>
        <router-link to="/users/1">My Profile</router-link>
        <router-link to="/services/new">Add Service</router-link>
      </nav>
    </header>

    <main class="page-content">
      <router-view />
    </main>
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style scoped>
.app-shell {
  min-height: 100vh;
  background-color: #f7f8fc;
  color: #1f2937;
  font-family: Arial, Helvetica, sans-serif;
}

.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 40px;
  background: white;
  border-bottom: 1px solid #e5e7eb;
}

.brand {
  font-size: 32px;
  font-weight: 700;
}

.nav-links {
  display: flex;
  gap: 18px;
  flex-wrap: wrap;
}

.nav-links a {
  text-decoration: none;
  color: #374151;
  font-weight: 600;
}

.nav-links a.router-link-active {
  color: #2563eb;
}

.page-content {
  padding: 40px;
}
</style>