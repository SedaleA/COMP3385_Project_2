<template>
  <section class="new-service-page">
    <h1>Add New Service</h1>

    <form @submit.prevent="handleSubmit" class="service-form">
      <div class="form-group">
        <label for="title">Title</label>
        <input id="title" v-model="form.title" type="text" />
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" v-model="form.description"></textarea>
      </div>

      <div class="form-group">
        <label for="category">Category</label>
        <select id="category" v-model="form.category">
          <option value="">Select a category</option>
          <option v-for="category in categories" :key="category" :value="category">
            {{ category }}
          </option>
        </select>
      </div>

      <div class="form-group">
        <label for="rate">Rate</label>
        <input id="rate" v-model="form.rate" type="number" min="0" step="0.01" />
      </div>

      <div class="form-group">
        <label for="rate_type">Rate Type</label>
        <select id="rate_type" v-model="form.rate_type">
          <option value="">Select a rate type</option>
          <option v-for="type in rateTypes" :key="type" :value="type">
            {{ type }}
          </option>
        </select>
      </div>

      <div class="form-group">
        <label for="photo">Photo</label>
        <input id="photo" type="file" @change="handleFileChange" />
      </div>

      <button type="submit" :disabled="loading">
        {{ loading ? 'Submitting...' : 'Add Service' }}
      </button>
    </form>

    <p v-if="successMessage" class="success-message">{{ successMessage }}</p>
    <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
  </section>
</template>

<script>
import api from '../services/api'

export default {
  name: 'NewServicePage',
  data() {
    return {
      categories: [
        'Web Development',
        'Graphic Design',
        'Photography',
        'Video Editing',
        'Writing & Editing',
        'Tutoring',
        'Music & Audio',
        'Data Entry',
        'Social Media Management',
        'Translation'
      ],
      rateTypes: [
        'per hour',
        'per day',
        'per week',
        'per month',
        'fixed'
      ],
      form: {
        title: '',
        description: '',
        category: '',
        rate: '',
        rate_type: '',
        photo: null
      },
      loading: false,
      successMessage: '',
      errorMessage: ''
    }
  },
  methods: {
    handleFileChange(event) {
      this.form.photo = event.target.files[0] || null
    },
    async handleSubmit() {
      this.successMessage = ''
      this.errorMessage = ''

      if (
        !this.form.title ||
        !this.form.description ||
        !this.form.category ||
        !this.form.rate ||
        !this.form.rate_type ||
        !this.form.photo
      ) {
        this.errorMessage = 'Please fill in all fields and upload a photo.'
        return
      }

      this.loading = true

      try {
        const formData = new FormData()
        formData.append('title', this.form.title)
        formData.append('description', this.form.description)
        formData.append('category', this.form.category)
        formData.append('rate', this.form.rate)
        formData.append('rate_type', this.form.rate_type)
        formData.append('photo', this.form.photo)

        await api.post('/services', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })

        this.successMessage = 'Service added successfully.'
        this.form = {
          title: '',
          description: '',
          category: '',
          rate: '',
          rate_type: '',
          photo: null
        }
      } catch (error) {
        this.errorMessage = 'Failed to add service.'
        console.error(error)
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
.new-service-page {
  max-width: 700px;
}

.service-form {
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
select,
button {
  padding: 10px;
  font-size: 16px;
}

textarea {
  min-height: 120px;
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