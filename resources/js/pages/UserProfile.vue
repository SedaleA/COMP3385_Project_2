<template>
  <section v-if="user" class="profile-page">
    <div class="profile-hero">
      <div class="profile-hero-inner">
        <div class="profile-avatar">{{ user.name.charAt(0) }}</div>

        <div class="profile-info">
          <h1>{{ user.name }}</h1>
          <p class="profile-meta">{{ user.location }} • Member since {{ user.member_since }}</p>
          <p class="profile-bio">{{ user.biography }}</p>

          <div class="profile-stats">
            <div>
              <strong>{{ user.services.length }}</strong>
              <span>Services</span>
            </div>
            <div>
              <strong>{{ user.favourites.length }}</strong>
              <span>Favourites</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="profile-content">
      <section class="profile-section">
        <h2>{{ firstName }}'s Services</h2>

        <div class="cards-grid">
          <article
            v-for="service in user.services"
            :key="service.id"
            class="service-card"
          >
            <div class="service-image-wrap">
              <img :src="service.image" :alt="service.title" class="service-image" />
              <span class="category-tag">{{ service.category }}</span>

              <button type="button" class="heart-button">
                <span :class="{ active: service.isFavourited }">
                  {{ service.isFavourited ? '♥' : '♡' }}
                </span>
              </button>
            </div>

            <div class="service-body">
              <h3>{{ service.title }}</h3>

              <div class="provider-row">
                <span class="provider-avatar-small">{{ user.name.charAt(0) }}</span>
                <span>{{ user.name }}</span>
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
      </section>

      <section class="profile-section">
        <h2>{{ firstName }}'s Favourites</h2>

        <div class="cards-grid">
          <article
            v-for="service in user.favourites"
            :key="service.id"
            class="service-card"
          >
            <div class="service-image-wrap">
              <img :src="service.image" :alt="service.title" class="service-image" />
              <span class="category-tag">{{ service.category }}</span>

              <button type="button" class="heart-button">
                <span :class="{ active: service.isFavourited }">
                  {{ service.isFavourited ? '♥' : '♡' }}
                </span>
              </button>
            </div>

            <div class="service-body">
              <h3>{{ service.title }}</h3>

              <div class="provider-row">
                <span class="provider-avatar-small">{{ service.provider_name.charAt(0) }}</span>
                <span>{{ service.provider_name }}</span>
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
      </section>
    </div>
  </section>

  <section v-else class="not-found-page">
    <h1>User Not Found</h1>
    <p>The user you are looking for does not exist.</p>
  </section>
</template>

<script>
export default {
  name: 'UserProfilePage',
  data() {
    return {
      users: [
        {
          id: 1,
          name: 'Daniela Retemyer',
          location: 'St. John, Antigua',
          member_since: '2023',
          biography:
            'Creative freelancer offering design support for small businesses, branding, and visual identity projects.',
          services: [
            {
              id: 1,
              title: 'Logo Design',
              category: 'Graphic Design',
              rate: 50,
              rate_type: 'per hour',
              description: 'Professional logo design for small businesses and personal brands.',
              image: 'https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&w=900&q=80',
              isFavourited: true
            }
          ],
          favourites: [
            {
              id: 2,
              title: 'Website Development',
              category: 'Web Development',
              rate: 300,
              rate_type: 'fixed',
              description: 'Responsive website development using modern tools and clean layouts.',
              image: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80',
              isFavourited: true,
              provider_name: 'Jordan Smith'
            }
          ]
        },
        {
          id: 2,
          name: 'Jordan Smith',
          location: 'St. George, Antigua',
          member_since: '2022',
          biography:
            'Web developer focused on responsive websites, clean code, and modern digital experiences.',
          services: [
            {
              id: 2,
              title: 'Website Development',
              category: 'Web Development',
              rate: 300,
              rate_type: 'fixed',
              description: 'Responsive website development using modern tools and clean layouts.',
              image: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80',
              isFavourited: false
            }
          ],
          favourites: [
            {
              id: 1,
              title: 'Logo Design',
              category: 'Graphic Design',
              rate: 50,
              rate_type: 'per hour',
              description: 'Professional logo design for small businesses and personal brands.',
              image: 'https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&w=900&q=80',
              isFavourited: true,
              provider_name: 'Daniela Retemyer'
            },
            {
              id: 3,
              title: 'Essay Editing',
              category: 'Writing & Editing',
              rate: 25,
              rate_type: 'per hour',
              description: 'Editing and proofreading for essays, reports, and academic writing.',
              image: 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=900&q=80',
              isFavourited: false,
              provider_name: 'Alicia Browne'
            }
          ]
        },
        {
          id: 3,
          name: 'Alicia Browne',
          location: 'St. Mary, Antigua',
          member_since: '2021',
          biography:
            'Editor and proofreader helping students and professionals improve clarity and writing quality.',
          services: [
            {
              id: 3,
              title: 'Essay Editing',
              category: 'Writing & Editing',
              rate: 25,
              rate_type: 'per hour',
              description: 'Editing and proofreading for essays, reports, and academic writing.',
              image: 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=900&q=80',
              isFavourited: false
            }
          ],
          favourites: []
        }
      ],
      user: null
    }
  },
  computed: {
    firstName() {
      return this.user ? this.user.name.split(' ')[0] : 'User'
    }
  },
  mounted() {
    const userId = Number(this.$route.params.user_id)
    this.user = this.users.find(user => user.id === userId) || null
  }
}
</script>

<style scoped>
.profile-page {
  background: #f8fafc;
  min-height: 100%;
}

.profile-hero {
  background: linear-gradient(135deg, #091b3a 0%, #133b72 100%);
  padding: 42px 20px;
  color: white;
}

.profile-hero-inner {
  max-width: 1040px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  gap: 22px;
}

.profile-avatar {
  width: 86px;
  height: 86px;
  border-radius: 50%;
  background: #fde68a;
  color: #0f172a;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 34px;
  font-weight: 800;
  flex-shrink: 0;
}

.profile-info h1 {
  margin: 0 0 8px;
  font-size: 34px;
}

.profile-meta {
  margin: 0 0 12px;
  color: #cbd5e1;
  font-size: 14px;
}

.profile-bio {
  margin: 0 0 16px;
  color: #e2e8f0;
  line-height: 1.7;
  max-width: 760px;
}

.profile-stats {
  display: flex;
  gap: 28px;
}

.profile-stats div {
  display: flex;
  flex-direction: column;
}

.profile-stats strong {
  font-size: 24px;
}

.profile-stats span {
  color: #cbd5e1;
  font-size: 13px;
}

.profile-content {
  max-width: 1040px;
  margin: 0 auto;
  padding: 34px 20px 56px;
}

.profile-section {
  margin-bottom: 38px;
}

.profile-section h2 {
  margin: 0 0 18px;
  font-size: 28px;
  color: #0f172a;
}

.cards-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
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
  background: rgba(15, 23, 42, 0.82);
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
  display: flex;
  align-items: center;
  justify-content: center;
}

.heart-button span {
  color: #cbd5e1;
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

.provider-avatar-small {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background: #fde68a;
  color: #0f172a;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  font-weight: 700;
}

.service-description {
  margin: 0 0 16px;
  color: #64748b;
  font-size: 14px;
  line-height: 1.6;
  min-height: 68px;
}

.service-footer {
  display: flex;
  justify-content: space-between;
  align-items: end;
  gap: 12px;
}

.service-price strong {
  font-size: 22px;
  color: #0f172a;
}

.service-price span {
  display: block;
  color: #64748b;
  font-size: 13px;
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

.not-found-page {
  padding: 80px 20px;
  text-align: center;
}

@media (max-width: 820px) {
  .cards-grid {
    grid-template-columns: 1fr;
  }

  .profile-hero-inner {
    flex-direction: column;
    align-items: flex-start;
  }
}

@media (max-width: 600px) {
  .service-footer {
    flex-direction: column;
    align-items: flex-start;
  }
}
</style>