<template>
  <div class="app-shell">
    <header class="topbar">
      <div class="brand">⚡ UniGigs</div>

      <nav class="nav-links">
        <router-link to="/">Home</router-link>
        <router-link to="/explore">Explore</router-link>

        <template v-if="!isLoggedIn">
          <router-link to="/login">Login</router-link>
          <router-link to="/register" class="signup-link">Sign Up</router-link>
        </template>

        <template v-else>
          <router-link :to="`/users/${userId}`">My Profile</router-link>
          <router-link to="/services/new">Add Service</router-link>
          <router-link to="/logout">Logout</router-link>
        </template>
      </nav>
    </header>

    <main class="page-content">
      <router-view />
    </main>

    <footer class="global-footer">
      <div class="footer-brand">⚡ UniGigs</div>
      <p>The freelance marketplace for students & professionals.</p>

      <div class="footer-links">
        <router-link to="/">Home</router-link>
        <router-link to="/explore">Explore</router-link>
        <router-link to="/register">Sign Up</router-link>
      </div>

      <small>© 2026 UniGigs</small>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      isLoggedIn: !!localStorage.getItem('token'),
      userId: null,
    }
  },
  watch: {
    // Re-evaluate auth state on every route change
    $route() {
      this.isLoggedIn = !!localStorage.getItem('token')
      const user = JSON.parse(localStorage.getItem('user') || '{}')
      this.userId = user.id || null
    }
  },
  created() {
    const user = JSON.parse(localStorage.getItem('user') || '{}')
    this.userId = user.id || null
  }
}
</script>

<style scoped>
.app-shell {
  min-height: 100vh;
  background-color: #f7f8fc;
  color: #1f2937;
  font-family: Arial, Helvetica, sans-serif;
  display: flex;
  flex-direction: column;
}

.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 18px 42px;
  background: white;
  border-bottom: 1px solid #e5e7eb;
}

.brand {
  font-size: 24px;
  font-weight: 800;
  color: #0f172a;
}

.nav-links {
  display: flex;
  gap: 14px;
  align-items: center;
  flex-wrap: wrap;
}

.nav-links a {
  text-decoration: none;
  color: #334155;
  font-weight: 600;
  padding: 8px 12px;
  border-radius: 8px;
}

.nav-links a.router-link-active {
  color: #0ea5e9;
  background: #e0f2fe;
}

.signup-link {
  background: #12baff;
  color: white !important;
}

.page-content {
  flex: 1;
  padding: 0;
}

.global-footer {
  background: #07122e;
  color: white;
  text-align: center;
  padding: 34px 20px;
}

.footer-brand {
  font-weight: 800;
  margin-bottom: 10px;
  color: #12baff;
}

.global-footer p {
  margin: 0 0 14px;
  color: #cbd5e1;
}

.footer-links {
  display: flex;
  justify-content: center;
  gap: 18px;
  margin-bottom: 12px;
  flex-wrap: wrap;
}

.footer-links a {
  color: white;
  text-decoration: none;
}

.global-footer small {
  color: #94a3b8;
}

@media (max-width: 700px) {
  .topbar {
    padding: 16px 20px;
    flex-direction: column;
    gap: 12px;
  }

  .nav-links {
    justify-content: center;
  }
}
</style>
