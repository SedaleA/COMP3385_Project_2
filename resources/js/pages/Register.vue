<template>
  <section class="register-page">
    <h1>Register</h1>

    <form @submit.prevent="handleRegister" class="register-form">
      <div class="form-group">
        <label for="name">Name</label>
        <input id="name" v-model="form.name" type="text" />
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input id="email" v-model="form.email" type="email" />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input id="password" v-model="form.password" type="password" />
      </div>

      <div class="form-group">
        <label for="location">Location</label>
        <input id="location" v-model="form.location" type="text" />
      </div>

      <div class="form-group">
        <label for="biography">Biography</label>
        <textarea id="biography" v-model="form.biography"></textarea>
      </div>

      <button type="submit" :disabled="loading">
        {{ loading ? 'Registering...' : 'Register' }}
      </button>
    </form>

    <p v-if="successMessage" class="success-message">{{ successMessage }}</p>
    <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
  </section>
</template>

<script>
import api from '../services/api'

export default {
  name: 'RegisterPage',
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        location: '',
        biography: ''
      },
      loading: false,
      successMessage: '',
      errorMessage: ''
    }
  },
  methods: {
    async handleRegister() {
      this.successMessage = ''
      this.errorMessage = ''

      if (
        !this.form.name ||
        !this.form.email ||
        !this.form.password ||
        !this.form.location ||
        !this.form.biography
      ) {
        this.errorMessage = 'Please fill in all fields.'
        return
      }

      this.loading = true

      try {
        await api.post('/auth/register', this.form)

        this.successMessage = 'Registration successful.'
        this.form = {
          name: '',
          email: '',
          password: '',
          location: '',
          biography: ''
        }
      } catch (error) {
        this.errorMessage = 'Registration failed.'
        console.error(error)
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
.register-page {
  max-width: 500px;
}

.register-form {
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
textarea,
button {
  padding: 10px;
  font-size: 16px;
}

textarea {
  min-height: 100px;
  resize: vertical;
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