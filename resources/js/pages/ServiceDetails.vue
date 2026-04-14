<template>
  <section class="service-details-page" v-if="service">
    <h1>{{ service.title }}</h1>

    <div class="service-card">
      <p><strong>Category:</strong> {{ service.category }}</p>
      <p><strong>Rate:</strong> {{ service.rate }} {{ service.rate_type }}</p>
      <p><strong>Description:</strong> {{ service.description }}</p>
      <p><strong>Provider:</strong> {{ service.provider_name }}</p>
      <p><strong>Location:</strong> {{ service.location }}</p>

      <div class="action-buttons">
        <button type="button">Contact Provider</button>

        <router-link :to="`/users/${service.user_id}`">
          View Profile
        </router-link>
      </div>
    </div>
  </section>

  <section v-else>
    <h1>Service Not Found</h1>
    <p>The service you are looking for does not exist.</p>
  </section>
</template>

<script>
export default {
  name: 'ServiceDetailsPage',
  data() {
    return {
      services: [
        {
          id: 1,
          title: 'Logo Design',
          category: 'Graphic Design',
          rate: 50,
          rate_type: 'per hour',
          description: 'Professional logo design for small businesses.',
          provider_name: 'Daniela Retemyer',
          location: 'St. John',
          user_id: 1
        },
        {
          id: 2,
          title: 'Website Development',
          category: 'Web Development',
          rate: 300,
          rate_type: 'fixed',
          description: 'Responsive website development using modern tools.',
          provider_name: 'Jordan Smith',
          location: 'St. George',
          user_id: 2
        },
        {
          id: 3,
          title: 'Essay Editing',
          category: 'Writing & Editing',
          rate: 25,
          rate_type: 'per hour',
          description: 'Editing and proofreading for essays and reports.',
          provider_name: 'Alicia Browne',
          location: 'St. Mary',
          user_id: 3
        }
      ],
      service: null
    }
  },
  mounted() {
    const serviceId = Number(this.$route.params.service_id)

    this.service = this.services.find(service => service.id === serviceId) || null
  }
}
</script>

<style scoped>
.service-details-page {
  max-width: 800px;
}

.service-card {
  background: white;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  padding: 24px;
  margin-top: 20px;
}

.action-buttons {
  display: flex;
  gap: 16px;
  align-items: center;
  margin-top: 20px;
}

.action-buttons button,
.action-buttons a {
  padding: 10px 16px;
  font-size: 16px;
  text-decoration: none;
}
</style>