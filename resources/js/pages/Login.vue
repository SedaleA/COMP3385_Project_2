<template>
  <section class="login-page">
    <h1>Login</h1>

    <form @submit.prevent="handleLogin" class="login-form">
      <div class="form-group">
        <label for="email">Email</label>
        <input id="email" v-model="form.email" type="email" />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input id="password" v-model="form.password" type="password" />
      </div>

      <button type="submit" :disabled="loading">
        {{ loading ? 'Logging in...' : 'Login' }}
      </button>
    </form>

    <p v-if="successMessage" class="success-message">{{ successMessage }}</p>
    <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
  </section>
</template>

<script>
import api from '../services/api'

export default {
  name: 'LoginPage',
  data() {
    return {
      form: {
        email: '',
        password: ''
      },
      loading: false,
      successMessage: '',
      errorMessage: ''
    }
  },
  methods: {
    async handleLogin() {
      this.successMessage = ''
      this.errorMessage = ''

      if (!this.form.email || !this.form.password) {
        this.errorMessage = 'Please fill in all fields.'
        return
      }

      this.loading = true

      try {
        const response = await api.post('/auth/login', this.form)

        const token = response.data.token

        if (token) {
          localStorage.setItem('token', token)
        }

        this.successMessage = 'Login successful.'
        this.form = {
          email: '',
          password: ''
        }
      } catch (error) {
        this.errorMessage = 'Login failed.'
        console.error(error)
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
.login-page {
  max-width: 500px;
}

.login-form {
  display: flex;
  flex-direction: column;
  gap: 16px;
  margin-top: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

input,
button {
  padding: 10px;
  font-size: 16px;
}

.success-message {
  margin-top: 16px;
  color: green;
}

.error-message {
  margin-top: 16px;
  color: red;
}
</style>