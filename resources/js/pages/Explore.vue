<template>
  <section class="explore-page">
    <div class="explore-hero">
      <div class="explore-hero-inner">
        <h1>Explore Services</h1>
        <p>Discover talented freelancers ready to bring your project to life.</p>

        <div class="search-row">
          <div class="search-input-wrap">
            <span class="search-icon">🔍</span>
            <input
              v-model="searchTerm"
              type="text"
              placeholder="Search by title or category..."
            />
          </div>

          <select v-model="selectedCategory">
            <option value="">All Categories</option>
            <option v-for="category in uniqueCategories" :key="category" :value="category">
              {{ category }}
            </option>
          </select>

          <button @click="handleSearch">Search</button>
        </div>
      </div>
    </div>

    <div class="explore-content">
      <div v-if="loading" class="loading-state">
        <p>Loading services...</p>
      </div>

      <div v-else-if="errorMessage" class="error-state">
        <p>{{ errorMessage }}</p>
      </div>

      <template v-else>
        <section class="services-section">
          <div class="section-heading">
            <div>
              <h2>Recently Added</h2>
              <p>The latest services from our community</p>
            </div>
            <span class="section-badge">NEW</span>
          </div>

          <div class="services-grid recent-grid">
            <article
              v-for="service in recentServices"
              :key="service.id"
              class="service-card"
            >
              <div class="service-image-wrap">
                <img
                  :src="service.photo ? `/storage/${service.photo}` : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80'"
                  :alt="service.title"
                  class="service-image"
                />
                <span class="category-tag">{{ service.category }}</span>

                <button
                  v-if="isLoggedIn"
                  type="button"
                  class="heart-button"
                  @click="toggleFavourite(service)"
                  :aria-label="service.isFavourited ? 'Remove from favourites' : 'Add to favourites'"
                >
                  <span :class="{ active: service.isFavourited }">
                    {{ service.isFavourited ? '♥' : '♡' }}
                  </span>
                </button>
              </div>

              <div class="service-body">
                <h3>{{ service.title }}</h3>

                <p class="service-description">{{ service.description }}</p>

                <div class="service-meta">
                  <strong>${{ service.rate }}</strong>
                  <span>{{ service.rate_type }}</span>
                </div>

                <router-link :to="`/services/${service.id}`" class="details-btn">
                  View Details
                </router-link>
              </div>
            </article>
          </div>
        </section>

        <section class="services-section">
          <div class="section-heading column-heading">
            <div>
              <h2>All Services</h2>
              <p>{{ displayedServices.length }} services found</p>
            </div>
          </div>

          <div class="services-grid">
            <article
              v-for="service in displayedServices"
              :key="service.id"
              class="service-card"
            >
              <div class="service-image-wrap">
                <img
                  :src="service.photo ? `/storage/${service.photo}` : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80'"
                  :alt="service.title"
                  class="service-image"
                />
                <span class="category-tag">{{ service.category }}</span>

                <button
                  v-if="isLoggedIn"
                  type="button"
                  class="heart-button"
                  @click="toggleFavourite(service)"
                  :aria-label="service.isFavourited ? 'Remove from favourites' : 'Add to favourites'"
                >
                  <span :class="{ active: service.isFavourited }">
                    {{ service.isFavourited ? '♥' : '♡' }}
                  </span>
                </button>
              </div>

              <div class="service-body">
                <h3>{{ service.title }}</h3>

                <div class="provider-row">
                  <span class="provider-avatar">{{ service.user?.name?.charAt(0) ?? '?' }}</span>
                  <span>{{ service.user?.name ?? 'Unknown' }}</span>
                </div>

                <p class="service-description">{{ service.description }}</p>

                <div class="service-footer">
                  <div class="service-price">
                    <strong>${{ service.rate }}</strong>
                    <span>{{ service.rate_type }}</span>
                  </div>

                  <router-link :to="`/services/${service.id}`" class="details-btn">
                    View Details
                  </router-link>
                </div>
              </div>
            </article>
          </div>

          <p v-if="displayedServices.length === 0" class="no-results">No services found.</p>
        </section>
      </template>
    </div>

    <div v-if="toastMessage" class="toast">
      {{ toastMessage }}
    </div>
  </section>
</template>

<script>
import api from '../services/api'

export default {
  name: 'ExplorePage',
  data() {
    return {
      searchTerm: '',
      selectedCategory: '',
      toastMessage: '',
      allServices: [],
      displayedServices: [],
      loading: false,
      errorMessage: '',
    }
  },
  computed: {
    isLoggedIn() {
      return !!localStorage.getItem('token')
    },
    recentServices() {
      return [...this.allServices].slice(-3).reverse()
    },
    uniqueCategories() {
      return [...new Set(this.allServices.map(s => s.category))]
    }
  },
  async mounted() {
    await this.fetchServices()
  },
  methods: {
    async fetchServices() {
      this.loading = true
      this.errorMessage = ''
      try {
        const response = await api.get('/services')
        this.allServices = response.data.services.map(s => ({
          ...s,
          isFavourited: false,
        }))
        this.displayedServices = [...this.allServices]
      } catch (error) {
        this.errorMessage = 'Failed to load services. Please try again.'
        console.error(error)
      } finally {
        this.loading = false
      }
    },
    async handleSearch() {
      const term = this.searchTerm.trim()

      if (!term && !this.selectedCategory) {
        this.displayedServices = [...this.allServices]
        return
      }

      try {
        const params = {}
        if (term) params.query = term
        if (this.selectedCategory) params.category = this.selectedCategory

        const response = await api.get('/search', { params })
        this.displayedServices = response.data.services.map(s => ({
          ...s,
          isFavourited: this.allServices.find(a => a.id === s.id)?.isFavourited ?? false,
        }))
      } catch (error) {
        // Fall back to client-side filtering if search endpoint fails
        this.displayedServices = this.allServices.filter(service => {
          const matchesSearch =
            !term ||
            service.title.toLowerCase().includes(term.toLowerCase()) ||
            service.category.toLowerCase().includes(term.toLowerCase())

          const matchesCategory =
            !this.selectedCategory || service.category === this.selectedCategory

          return matchesSearch && matchesCategory
        })
      }
    },
    async toggleFavourite(service) {
      if (!this.isLoggedIn) {
        this.showToast('Please log in to favourite services')
        return
      }

      // Optimistically toggle UI
      service.isFavourited = !service.isFavourited

      try {
        await api.post(`/services/${service.id}/favourite`)
        this.showToast(`${service.title} added to favourites`)
      } catch (error) {
        const status = error.response?.status
        if (status === 409) {
          // Already favourited — reflect that in UI
          service.isFavourited = true
          this.showToast('Already in your favourites')
        } else {
          // Revert on unexpected error
          service.isFavourited = !service.isFavourited
          this.showToast('Something went wrong')
          console.error(error)
        }
      }
    },
    showToast(message) {
      this.toastMessage = message
      setTimeout(() => {
        this.toastMessage = ''
      }, 2500)
    }
  }
}
</script>

<style scoped>
.explore-page {
  background: #f8fafc;
  min-height: 100%;
}

.explore-hero {
  background: linear-gradient(135deg, #091b3a 0%, #133b72 100%);
  padding: 46px 20px 54px;
}

.explore-hero-inner {
  max-width: 1040px;
  margin: 0 auto;
  color: white;
}

.explore-hero h1 {
  margin: 0 0 10px;
  font-size: 40px;
  font-weight: 800;
}

.explore-hero p {
  margin: 0 0 24px;
  color: #cbd5e1;
}

.search-row {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}

.search-input-wrap {
  flex: 1 1 420px;
  position: relative;
}

.search-icon {
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 14px;
  opacity: 0.8;
}

.search-input-wrap input {
  width: 100%;
  box-sizing: border-box;
  padding: 13px 14px 13px 38px;
  border-radius: 10px;
  border: 1px solid rgba(255, 255, 255, 0.12);
  background: rgba(255, 255, 255, 0.08);
  color: white;
  outline: none;
}

.search-input-wrap input::placeholder {
  color: #cbd5e1;
}

.search-row select,
.search-row button {
  padding: 13px 14px;
  border-radius: 10px;
  border: 1px solid rgba(255, 255, 255, 0.16);
  outline: none;
}

.search-row select {
  background: rgba(255, 255, 255, 0.08);
  color: white;
}

.search-row option {
  color: black;
}

.search-row button {
  background: #0ea5e9;
  color: white;
  font-weight: 700;
  cursor: pointer;
  border: none;
}

.explore-content {
  max-width: 1040px;
  margin: 0 auto;
  padding: 28px 20px 56px;
}

.loading-state,
.error-state {
  text-align: center;
  padding: 60px 20px;
  color: #64748b;
  font-size: 16px;
}

.error-state {
  color: #ef4444;
}

.services-section {
  margin-top: 10px;
}

.section-heading {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 16px;
  margin-bottom: 18px;
}

.section-heading h2 {
  margin: 0;
  font-size: 28px;
  color: #0f172a;
}

.section-heading p {
  margin: 6px 0 0;
  color: #64748b;
  font-size: 14px;
}

.column-heading {
  margin-top: 34px;
}

.section-badge {
  background: #0ea5e9;
  color: white;
  font-size: 11px;
  font-weight: 800;
  padding: 6px 10px;
  border-radius: 999px;
}

.services-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 18px;
}

.service-card {
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 8px 22px rgba(15, 23, 42, 0.05);
}

.service-image-wrap {
  position: relative;
}

.service-image {
  width: 100%;
  height: 180px;
  object-fit: cover;
  display: block;
}

.category-tag {
  position: absolute;
  left: 12px;
  top: 12px;
  background: rgba(15, 23, 42, 0.8);
  color: white;
  font-size: 11px;
  font-weight: 700;
  padding: 6px 10px;
  border-radius: 999px;
}

.heart-button {
  position: absolute;
  right: 12px;
  top: 12px;
  width: 34px;
  height: 34px;
  border-radius: 50%;
  border: none;
  background: rgba(255, 255, 255, 0.92);
  font-size: 18px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.heart-button span {
  color: #64748b;
  transition: 0.2s ease;
}

.heart-button span.active {
  color: #ef4444;
}

.service-body {
  padding: 16px 16px 18px;
}

.service-body h3 {
  margin: 0 0 10px;
  font-size: 18px;
  color: #0f172a;
}

.provider-row {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 12px;
  color: #475569;
  font-size: 14px;
}

.provider-avatar {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background: #fde68a;
  color: #0f172a;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 12px;
}

.service-description {
  margin: 0 0 16px;
  color: #64748b;
  font-size: 14px;
  line-height: 1.6;
  min-height: 68px;
}

.service-meta {
  display: flex;
  flex-direction: column;
  margin-bottom: 14px;
}

.service-meta strong,
.service-price strong {
  font-size: 22px;
  color: #0f172a;
}

.service-meta span,
.service-price span {
  color: #64748b;
  font-size: 13px;
}

.service-footer {
  display: flex;
  justify-content: space-between;
  align-items: end;
  gap: 12px;
}

.details-btn {
  text-decoration: none;
  background: #0ea5e9;
  color: white;
  font-weight: 700;
  font-size: 13px;
  padding: 10px 14px;
  border-radius: 10px;
  white-space: nowrap;
}

.no-results {
  margin-top: 18px;
  color: #64748b;
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
  animation: fadeInUp 0.3s ease;
  z-index: 1000;
}

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(10px); }
  to   { opacity: 1; transform: translateY(0); }
}

@media (max-width: 980px) {
  .services-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 680px) {
  .explore-hero h1 { font-size: 32px; }
  .services-grid { grid-template-columns: 1fr; }
  .service-footer { flex-direction: column; align-items: flex-start; }
  .toast { right: 16px; left: 16px; bottom: 16px; }
}
</style>
