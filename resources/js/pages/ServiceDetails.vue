<template>
  <section v-if="service" class="service-details-page">
    <div class="details-container">
      <div class="details-main">
        <div class="details-image-wrap">
          <img :src="service.image" :alt="service.title" class="details-image" />
          <span class="category-tag">{{ service.category }}</span>
        </div>

        <div class="title-row">
          <h1>{{ service.title }}</h1>

          <button
            type="button"
            class="favourite-badge"
            @click="toggleFavourite"
          >
            <span :class="{ active: service.isFavourited }">♥</span>
            {{ service.isFavourited ? 'Favourited' : 'Favourite' }}
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
              <span>{{ service.date_listed }}</span>
            </div>
          </div>

          <button class="contact-btn" type="button">📩 Contact Provider</button>
          <small>Response typically within 24 hours</small>
        </div>

        <div class="sidebar-card provider-card">
          <h3>About the Provider</h3>

          <div class="provider-info">
            <div class="provider-avatar">{{ service.provider_name.charAt(0) }}</div>

            <div>
              <strong>{{ service.provider_name }}</strong>
              <p>{{ service.location }}</p>
              <small>Member since {{ service.member_since }}</small>
            </div>
          </div>

          <p class="provider-bio">{{ service.provider_bio }}</p>

          <router-link :to="`/users/${service.user_id}`" class="profile-btn">
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
export default {
  name: 'ServiceDetailsPage',
  data() {
    return {
      toastMessage: '',
      services: [
        {
          id: 1,
          title: 'Logo Design',
          category: 'Graphic Design',
          rate: 50,
          rate_type: 'per hour',
          description:
            'Professional logo design for small businesses and personal brands. I create clean, memorable designs that reflect your business identity and help you stand out.',
          provider_name: 'Daniela Retemyer',
          location: 'St. John, Antigua',
          user_id: 1,
          image: 'https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&w=900&q=80',
          isFavourited: true,
          date_listed: 'March 14, 2024',
          member_since: '2023',
          provider_bio:
            'Creative designer with experience in branding, logo design, and visual identity work for small businesses and online brands.'
        },
        {
          id: 2,
          title: 'Website Development',
          category: 'Web Development',
          rate: 300,
          rate_type: 'fixed',
          description:
            'Responsive website development using modern tools and clean layouts. Perfect for portfolios, small business sites, and landing pages.',
          provider_name: 'Jordan Smith',
          location: 'St. George, Antigua',
          user_id: 2,
          image: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80',
          isFavourited: false,
          date_listed: 'March 16, 2024',
          member_since: '2022',
          provider_bio:
            'Frontend developer focused on responsive websites, clean code, and user-friendly digital experiences.'
        },
        {
          id: 3,
          title: 'Essay Editing',
          category: 'Writing & Editing',
          rate: 25,
          rate_type: 'per hour',
          description:
            'Editing and proofreading for essays, reports, and academic writing. I help improve clarity, grammar, and structure.',
          provider_name: 'Alicia Browne',
          location: 'St. Mary, Antigua',
          user_id: 3,
          image: 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=900&q=80',
          isFavourited: false,
          date_listed: 'March 18, 2024',
          member_since: '2021',
          provider_bio:
            'Editor and proofreader with a strong interest in helping students and professionals present polished written work.'
        }
      ],
      service: null
    }
  },
  mounted() {
    const serviceId = Number(this.$route.params.service_id)
    this.service = this.services.find(service => service.id === serviceId) || null
  },
  methods: {
    toggleFavourite() {
      if (!this.service) return

      this.service.isFavourited = !this.service.isFavourited

      if (this.service.isFavourited) {
        this.showToast('Added to favourites')
      } else {
        this.showToast('Removed from favourites')
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

.provider-info strong {
  display: block;
  color: #0f172a;
}

.provider-info p,
.provider-info small {
  margin: 0;
  color: #64748b;
}

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

.not-found-page {
  padding: 80px 20px;
  text-align: center;
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
  .details-container {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 600px) {
  .title-row {
    flex-direction: column;
    align-items: flex-start;
  }

  .details-image {
    height: 240px;
  }

  .toast {
    right: 16px;
    left: 16px;
    bottom: 16px;
  }
}
</style>