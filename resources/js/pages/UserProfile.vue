<template>
  <section v-if="user" class="profile-page">
    <div class="profile-card">
      <h1>{{ user.name }}</h1>
      <p><strong>Email:</strong> {{ user.email }}</p>
      <p><strong>Location:</strong> {{ user.location }}</p>
      <p><strong>Biography:</strong> {{ user.biography }}</p>
    </div>

    <div class="profile-section">
      <h2>Services Offered</h2>

      <div v-if="user.services.length">
        <article
          v-for="service in user.services"
          :key="service.id"
          class="service-card"
        >
          <h3>{{ service.title }}</h3>
          <p><strong>Category:</strong> {{ service.category }}</p>
          <p><strong>Rate:</strong> {{ service.rate }} {{ service.rate_type }}</p>
          <p>{{ service.description }}</p>

          <router-link :to="`/services/${service.id}`">
            View Details
          </router-link>
        </article>
      </div>

      <p v-else>No services offered yet.</p>
    </div>

    <div class="profile-section">
      <h2>Favourited Services</h2>

      <div v-if="user.favourites.length">
        <article
          v-for="service in user.favourites"
          :key="service.id"
          class="service-card"
        >
          <h3>{{ service.title }}</h3>
          <p><strong>Category:</strong> {{ service.category }}</p>
          <p><strong>Rate:</strong> {{ service.rate }} {{ service.rate_type }}</p>

          <router-link :to="`/services/${service.id}`">
            View Details
          </router-link>
        </article>
      </div>

      <p v-else>No favourited services yet.</p>
    </div>
  </section>

  <section v-else>
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
          email: 'danielaspencer9@gmail.com',
          location: 'St. John',
          biography: 'Creative freelancer offering design support for small businesses.',
          services: [
            {
              id: 1,
              title: 'Logo Design',
              category: 'Graphic Design',
              rate: 50,
              rate_type: 'per hour',
              description: 'Professional logo design for small businesses.'
            }
          ],
          favourites: [
            {
              id: 2,
              title: 'Website Development',
              category: 'Web Development',
              rate: 300,
              rate_type: 'fixed'
            }
          ]
        },
        {
          id: 2,
          name: 'Jordan Smith',
          email: 'jordan@example.com',
          location: 'St. George',
          biography: 'Web developer building responsive websites and apps.',
          services: [
            {
              id: 2,
              title: 'Website Development',
              category: 'Web Development',
              rate: 300,
              rate_type: 'fixed',
              description: 'Responsive website development using modern tools.'
            }
          ],
          favourites: [
            {
              id: 1,
              title: 'Logo Design',
              category: 'Graphic Design',
              rate: 50,
              rate_type: 'per hour'
            }
          ]
        },
        {
          id: 3,
          name: 'Alicia Browne',
          email: 'alicia@example.com',
          location: 'St. Mary',
          biography: 'Editor and proofreader for essays, reports, and academic writing.',
          services: [
            {
              id: 3,
              title: 'Essay Editing',
              category: 'Writing & Editing',
              rate: 25,
              rate_type: 'per hour',
              description: 'Editing and proofreading for essays and reports.'
            }
          ],
          favourites: []
        }
      ],
      user: null
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
  max-width: 900px;
}

.profile-card {
  background: white;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  padding: 24px;
  margin-bottom: 30px;
}

.profile-section {
  margin-top: 30px;
}

.service-card {
  background: white;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  padding: 20px;
  margin-top: 16px;
}
</style>