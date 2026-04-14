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

    <p v-if="successMessage" class="success-message">{{ successMessage }}</p>
    <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>

    <div class="services-list">
      <article
        v-for="service in displayedServices"
        :key="service.id"
        class="service-card"
      >
        <div class="card-top">
          <h2>{{ service.title }}</h2>

          <button
            type="button"
            class="heart-button"
            @click="toggleFavourite(service)"
            :aria-label="service.isFavourited ? 'Remove from favourites' : 'Add to favourites'"
          >
            {{ service.isFavourited ? '♥' : '♡' }}
          </button>
        </div>

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
      successMessage: '',
      errorMessage: '',
      allServices: [
        {
          id: 1,
          title: 'Logo Design',
          category: 'Graphic Design',
          rate: 50,
          rate_type: 'per hour',
          description: 'Professional logo design for small businesses.',
          isFavourited: false
        },
        {
          id: 2,
          title: 'Website Development',
          category: 'Web Development',
          rate: 300,
          rate_type: 'fixed',
          description: 'Responsive website development using modern tools.',
          isFavourited: false
        },
        {
          id: 3,
          title: 'Essay Editing',
          category: 'Writing & Editing',
          rate: 25,
          rate_type: 'per hour',
          description: 'Editing and proofreading for essays and reports.',
          isFavourited: false
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
      this.successMessage = ''
      this.errorMessage = ''

      const term = this.searchTerm.trim().toLowerCase()

      if (!term) {
        this.displayedServices = this.allServices.slice(-3)
        return
      }

      this.displayedServices = this.allServices.filter(service =>
        service.title.toLowerCase().includes(term) ||
        service.category.toLowerCase().includes(term)
      )
    },
    async toggleFavourite(service) {
      this.successMessage = ''
      this.errorMessage = ''

      try {
        service.isFavourited = !service.isFavourited

        if (service.isFavourited) {
          this.successMessage = `${service.title} added to favourites.`
        } else {
          this.successMessage = `${service.title} removed from favourites.`
        }

        // Later, when backend is merged, replace the mock toggle logic
        // with an API call like:
        // await api.post(`/services/${service.id}/favourite`)
      } catch (error) {
        this.errorMessage = 'Unable to update favourites.'
        console.error(error)
      }
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
  margin: 20px 0 20px;
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

.success-message {
  margin-bottom: 16px;
  color: green;
}

.error-message {
  margin-bottom: 16px;
  color: red;
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

.card-top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 16px;
}

.heart-button {
  border: none;
  background: transparent;
  font-size: 28px;
  cursor: pointer;
  line-height: 1;
}

.card-actions {
  margin-top: 12px;
}
</style>