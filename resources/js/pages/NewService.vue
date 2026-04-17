<template>
  <section class="new-service-page">
    <div class="page-hero">
      <div class="page-hero-inner">
        <h1>List a New Service</h1>
        <p>Share your skills with the UniGigs community</p>
      </div>
    </div>

    <div class="form-wrapper">
      <div class="form-card">
        <form @submit.prevent="handleSubmit" class="service-form">
          <div class="form-section">
            <h2>Service Photo</h2>

            <div class="form-group">
              <label for="photo">Cover Image <span>*</span></label>

              <label for="photo" class="upload-box">
                <span class="upload-icon">🖼️</span>
                <strong>Click to upload a cover image</strong>
                <small>JPG, PNG or GIF up to 3MB</small>
              </label>

              <input id="photo" type="file" accept="image/*" @change="handleFileChange" />
            </div>
          </div>

          <div class="form-section">
            <h2>Service Details</h2>

            <div class="form-group">
              <label for="title">Service Title <span>*</span></label>
              <input
                id="title"
                v-model="form.title"
                type="text"
                placeholder="e.g. Professional Logo Design & Brand Identity"
              />
            </div>

            <div class="form-group">
              <label for="description">Description <span>*</span></label>
              <textarea
                id="description"
                v-model="form.description"
                maxlength="500"
                placeholder="Describe your service in detail. What will you deliver? What’s included? What’s your process?"
              ></textarea>
              <small>{{ form.description.length }}/500 characters</small>
            </div>

            <div class="form-group">
              <label for="category">Category <span>*</span></label>
              <select id="category" v-model="form.category">
                <option value="">Select a category...</option>
                <option v-for="category in categories" :key="category" :value="category">
                  {{ category }}
                </option>
              </select>
            </div>
          </div>

          <div class="form-section">
            <h2>Pricing</h2>

            <div class="two-column-row">
              <div class="form-group">
                <label for="rate">Rate (USD) <span>*</span></label>
                <input
                  id="rate"
                  v-model="form.rate"
                  type="number"
                  min="0"
                  step="0.01"
                  placeholder="$ 0.00"
                />
              </div>

              <div class="form-group">
                <label for="rate_type">Rate Type <span>*</span></label>
                <select id="rate_type" v-model="form.rate_type">
                  <option value="">Select type</option>
                  <option v-for="type in rateTypes" :key="type" :value="type">
                    {{ type }}
                  </option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <button type="button" class="cancel-btn">Cancel</button>
            <button type="submit" :disabled="loading" class="submit-btn">
              {{ loading ? 'Submitting...' : 'List My Service' }}
            </button>
          </div>
        </form>

        <p v-if="successMessage" class="success-message">{{ successMessage }}</p>
        <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
      </div>
    </div>
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
  background: #f8fafc;
  min-height: 100%;
}

.page-hero {
  background: linear-gradient(135deg, #091b3a 0%, #133b72 100%);
  padding: 42px 20px;
}

.page-hero-inner {
  max-width: 1040px;
  margin: 0 auto;
  color: white;
}

.page-hero h1 {
  margin: 0 0 8px;
  font-size: 38px;
  font-weight: 800;
}

.page-hero p {
  margin: 0;
  color: #cbd5e1;
}

.form-wrapper {
  max-width: 1040px;
  margin: 0 auto;
  padding: 34px 20px 56px;
  display: flex;
  justify-content: center;
}

.form-card {
  width: 100%;
  max-width: 620px;
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 18px;
  box-shadow: 0 8px 22px rgba(15, 23, 42, 0.05);
  padding: 26px;
}

.service-form {
  display: flex;
  flex-direction: column;
  gap: 22px;
}

.form-section h2 {
  margin: 0 0 16px;
  font-size: 18px;
  color: #0f172a;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-group label {
  font-size: 13px;
  font-weight: 700;
  color: #334155;
}

.form-group label span {
  color: #ef4444;
}

input[type='text'],
input[type='number'],
textarea,
select {
  width: 100%;
  box-sizing: border-box;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  padding: 11px 13px;
  font-size: 14px;
  color: #0f172a;
  background: white;
  outline: none;
}

input[type='text']:focus,
input[type='number']:focus,
textarea:focus,
select:focus {
  border-color: #38bdf8;
  box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15);
}

textarea {
  min-height: 120px;
  resize: none;
}

.form-group small {
  color: #94a3b8;
  font-size: 12px;
}

.upload-box {
  border: 1px dashed #cbd5e1;
  background: #f8fafc;
  border-radius: 12px;
  min-height: 120px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 8px;
  text-align: center;
  cursor: pointer;
  padding: 16px;
}

.upload-icon {
  font-size: 28px;
}

input[type='file'] {
  display: none;
}

.two-column-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 8px;
}

.cancel-btn,
.submit-btn {
  border-radius: 10px;
  padding: 11px 16px;
  font-weight: 700;
  font-size: 14px;
  cursor: pointer;
}

.cancel-btn {
  background: white;
  border: 1px solid #38bdf8;
  color: #0ea5e9;
}

.submit-btn {
  background: #0ea5e9;
  border: none;
  color: white;
}

.submit-btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.success-message {
  margin-top: 16px;
  color: green;
  text-align: center;
}

.error-message {
  margin-top: 16px;
  color: red;
  text-align: center;
}

@media (max-width: 640px) {
  .two-column-row {
    grid-template-columns: 1fr;
  }

  .form-actions {
    flex-direction: column;
  }

  .cancel-btn,
  .submit-btn {
    width: 100%;
  }
}
</style>