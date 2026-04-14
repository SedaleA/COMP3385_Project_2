<template>
  <section class="explore-page">
    <h1>Explore Services</h1>

    <div class="search-box">
      <input
        v-model="searchTerm"
        type="text"
        placeholder="Search by title or category"
      />
      <button @click="handleSearch">Search</button>
    </div>

    <div class="services-list">
      <article v-for="service in displayedServices" :key="service.id" class="service-card">
        <h2>{{ service.title }}</h2>
        <p><strong>Category:</strong> {{ service.category }}</p>
        <p><strong>Rate:</strong> {{ service.rate }} {{ service.rate_type }}</p>
        <p>{{ service.description }}</p>

        <div class="card-actions">
          <router-link :to="`/services/${service.id}`">View More Details</router-link>
        </div>
      </article>
    </div>

    <p v-if="displayedServices.length === 0">No services found.</p>
  </section>
</template>

<script>
export default {
  name: 'ExplorePage',
  data() {
    return {
      searchTerm: '',
      allServices: [
        {
          id: 1,
          title: 'Logo Design',
          category: 'Graphic Design',
          rate: 50,
          rate_type: 'per hour',
          description: 'Professional logo design for small businesses.'
        },
        {
          id: 2,
          title: 'Website Development',
          category: 'Web Development',
          rate: 300,
          rate_type: 'fixed',
          description: 'Responsive website development using modern tools.'
        },
        {
          id: 3,
          title: 'Essay Editing',
          category: 'Writing & Editing',
          rate: 25,
          rate_type: 'per hour',
          description: 'Editing and proofreading for essays and reports.'
        }
      ],
      displayedServices: []
    }
  },
  mounted() {
    this.displayedServices = this.allServices.slice(-3)
  },
  methods: {
    handleSearch() {
      const term = this.searchTerm.trim().toLowerCase()

      if (!term) {
        this.displayedServices = this.allServices.slice(-3)
        return
      }

      this.displayedServices = this.allServices.filter(service =>
        service.title.toLowerCase().includes(term) ||
        service.category.toLowerCase().includes(term)
      )
    }
  }
}
</script>

<style scoped>
.explore-page {
  max-width: 900px;
}

.search-box {
  display: flex;
  gap: 12px;
  margin: 20px 0 30px;
}

.search-box input {
  flex: 1;
  padding: 10px;
  font-size: 16px;
}

.search-box button {
  padding: 10px 18px;
  font-size: 16px;
  cursor: pointer;
}

.services-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.service-card {
  padding: 20px;
  background: white;
  border: 1px solid #d1d5db;
  border-radius: 8px;
}

.card-actions {
  margin-top: 12px;
}
</style>