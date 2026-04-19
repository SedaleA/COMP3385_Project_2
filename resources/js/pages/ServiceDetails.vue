<template>
  <section v-if="loading" class="loading-page">
    <p>Loading service...</p>
  </section>

  <section v-else-if="service" class="service-details-page">
    <div class="details-container">
      <div class="details-main">
        <div class="details-image-wrap">
          <img
            :src="service.photo ? `/storage/${service.photo}` : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80'"
            :alt="service.title"
            class="details-image"
          />
          <span class="category-tag">{{ service.category }}</span>
        </div>

        <div class="title-row">
          <h1>{{ service.title }}</h1>

          <button
            v-if="isLoggedIn"
            type="button"
            class="favourite-badge"
            @click="toggleFavourite"
            :disabled="favouriteLoading"
          >
            <span :class="{ active: isFavourited }">♥</span>
            {{ isFavourited ? 'Favourited' : 'Favourite' }}
          </button>
        </div>

        <div class="details-section">
          <h2>About This Service</h2>
          <p>{{ service.description }}</p>
        </div>
      </div>

      <aside class="details-sidebar">
        <div class="sidebar-card price-card">
          <div class="price-row">
            <strong>${{ service.rate }}</strong>
            <span>{{ service.rate_type }}</span>
          </div>

          <div class="sidebar-meta">
            <div>
              <label>Category</label>
              <span>{{ service.category }}</span>
            </div>
            <div>
              <label>Listed</label>
              <span>{{ formatDate(service.created_at) }}</span>
            </div>
          </div>

          <button class="contact-btn" type="button">📩 Contact Provider</button>
          <small>Response typically within 24 hours</small>
        </div>

        <div v-if="service.user" class="sidebar-card provider-card">
          <h3>About the Provider</h3>

          <div class="provider-info">
            <div class="provider-avatar">{{ service.user.name.charAt(0) }}</div>

            <div>
              <strong>{{ service.user.name }}</strong>
              <p>{{ service.user.location }}</p>
              <small>Member since {{ formatYear(service.user.created_at) }}</small>
            </div>
          </div>

          <p v-if="service.user.biography" class="provider-bio">{{ service.user.biography }}</p>

          <router-link :to="`/users/${service.user.id}`" class="profile-btn">
            View Profile
          </router-link>
        </div>
      </aside>
    </div>

    <div v-if="toastMessage" class="toast">
      {{ toastMessage }}
    </div>
  </section>

  <section v-else class="not-found-page">
    <h1>Service Not Found</h1>
    <p>The service you are looking for does not exist.</p>
  </section>
</template>

<script>
import api from '../services/api'

export default {
  name: 'ServiceDetailsPage',
  data() {
    return {
      service: null,
      isFavourited: false,
      favouriteLoading: false,
      loading: false,
      toastMessage: '',
    }
  },
  computed: {
    isLoggedIn() {
      return !!localStorage.getItem('token')
    }
  },
  async mounted() {
    await this.fetchService()
  },
  methods: {
    async fetchService() {
      this.loading = true
      try {
        const serviceId = this.$route.params.service_id
        const response = await api.get(`/services/${serviceId}`)
        this.service = response.data.service
      } catch (error) {
        this.service = null
        console.error(error)
      } finally {
        this.loading = false
      }
    },
    async toggleFavourite() {
      if (!this.service || this.favouriteLoading) return

      this.favouriteLoading = true

      // Optimistically toggle
      this.isFavourited = !this.isFavourited

      try {
        await api.post(`/services/${this.service.id}/favourite`)
        this.showToast('Added to favourites')
      } catch (error) {
        const status = error.response?.status
        if (status === 409) {
          this.isFavourited = true
          this.showToast('Already in your favourites')
        } else {
          // Revert on unexpected error
          this.isFavourited = !this.isFavourited
          this.showToast('Something went wrong')
          console.error(error)
        }
      } finally {
        this.favouriteLoading = false
      }
    },
    formatDate(dateString) {
      if (!dateString) return '—'
      return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric', month: 'long', day: 'numeric'
      })
    },
    formatYear(dateString) {
      if (!dateString) return '—'
      return new Date(dateString).getFullYear()
    },
    showToast(message) {
      this.toastMessage = message
      setTimeout(() => { this.toastMessage = '' }, 2500)
    }
  }
}
</script>

<style scoped>
.loading-page,
.not-found-page {
  padding: 80px 20px;
  text-align: center;
  color: #64748b;
}

.service-details-page {
  background: #f8fafc;
  padding: 36px 20px 60px;
}

.details-container {
  max-width: 1100px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 28px;
}

.details-main,
.sidebar-card {
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  box-shadow: 0 8px 22px rgba(15, 23, 42, 0.05);
}

.details-main {
  padding: 22px;
}

.details-image-wrap {
  position: relative;
  margin-bottom: 18px;
}

.details-image {
  width: 100%;
  height: 360px;
  object-fit: cover;
  border-radius: 14px;
  display: block;
}

.category-tag {
  position: absolute;
  top: 14px;
  left: 14px;
  background: rgba(15, 23, 42, 0.82);
  color: white;
  font-size: 11px;
  font-weight: 700;
  padding: 6px 10px;
  border-radius: 999px;
}

.title-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 14px;
  margin-bottom: 22px;
}

.title-row h1 {
  margin: 0;
  font-size: 34px;
  color: #0f172a;
}

.favourite-badge {
  border: 1px solid #fecaca;
  background: #fff1f2;
  color: #ef4444;
  border-radius: 10px;
  padding: 10px 14px;
  font-weight: 700;
  cursor: pointer;
  white-space: nowrap;
}

.favourite-badge:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.favourite-badge span {
  margin-right: 6px;
  color: #cbd5e1;
}

.favourite-badge span.active {
  color: #ef4444;
}

.details-section h2 {
  margin: 0 0 12px;
  font-size: 20px;
  color: #0f172a;
}

.details-section p {
  margin: 0;
  color: #475569;
  line-height: 1.8;
}

.details-sidebar {
  display: flex;
  flex-direction: column;
  gap: 18px;
}

.sidebar-card {
  padding: 22px;
}

.price-row {
  display: flex;
  align-items: baseline;
  gap: 8px;
  margin-bottom: 18px;
}

.price-row strong {
  font-size: 36px;
  color: #0f172a;
}

.price-row span {
  color: #64748b;
  font-size: 14px;
}

.sidebar-meta {
  display: flex;
  flex-direction: column;
  gap: 12px;
  margin-bottom: 18px;
}

.sidebar-meta div {
  display: flex;
  justify-content: space-between;
  gap: 14px;
}

.sidebar-meta label {
  color: #94a3b8;
  font-size: 13px;
}

.sidebar-meta span {
  color: #0f172a;
  font-size: 13px;
  font-weight: 700;
  text-align: right;
}

.contact-btn,
.profile-btn {
  width: 100%;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  text-decoration: none;
  border-radius: 10px;
  padding: 12px;
  font-weight: 700;
  font-size: 14px;
  box-sizing: border-box;
}

.contact-btn {
  background: #0ea5e9;
  color: white;
  border: none;
  cursor: pointer;
  margin-bottom: 8px;
}

.price-card small {
  display: block;
  text-align: center;
  color: #94a3b8;
}

.provider-card h3 {
  margin: 0 0 16px;
  font-size: 18px;
  color: #0f172a;
}

.provider-info {
  display: flex;
  gap: 14px;
  align-items: center;
  margin-bottom: 16px;
}

.provider-avatar {
  width: 54px;
  height: 54px;
  border-radius: 50%;
  background: #fde68a;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  color: #0f172a;
  flex-shrink: 0;
}

.provider-info strong { display: block; color: #0f172a; }
.provider-info p,
.provider-info small { margin: 0; color: #64748b; }

.provider-bio {
  color: #475569;
  line-height: 1.7;
  margin-bottom: 18px;
}

.profile-btn {
  border: 1px solid #38bdf8;
  color: #0ea5e9;
  background: white;
}

.toast {
  position: fixed;
  bottom: 30px;
  right: 30px;
  background: #0f172a;
  color: white;
  padding: 12px 18px;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 600;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  z-index: 1000;
}

@media (max-width: 900px) {
  .details-container { grid-template-columns: 1fr; }
}

@media (max-width: 600px) {
  .title-row { flex-direction: column; align-items: flex-start; }
  .details-image { height: 240px; }
  .toast { right: 16px; left: 16px; bottom: 16px; }
}
</style>
