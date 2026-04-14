<template>
  <div class="home-page">
    <section class="hero-section">
      <div class="hero-content">
        <span class="hero-badge">Built for Students & Professionals</span>

        <h1>
          Find the skills you need,<br />
          <span>offer the skills you have.</span>
        </h1>

        <p class="hero-text">
          UniGigs is the freelance marketplace where talented people connect
          with those who need their skills. Browse services, hire freelancers,
          or list your own expertise today.
        </p>

        <div class="hero-buttons">
          <router-link to="/explore" class="primary-btn">Explore Services</router-link>
          <router-link to="/register" class="secondary-btn">Get Started Free</router-link>
        </div>

        <div class="hero-stats">
          <div>
            <strong>200+</strong>
            <span>Services Listed</span>
          </div>
          <div>
            <strong>150+</strong>
            <span>Freelancers</span>
          </div>
          <div>
            <strong>6</strong>
            <span>Categories</span>
          </div>
        </div>
      </div>

      <div class="hero-image-wrapper">
        <img
          src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=900&q=80"
          alt="Laptop with freelance work"
          class="hero-image"
        />
      </div>
    </section>

    <section class="features-section">
      <h2>Why Choose UniGigs?</h2>
      <p class="section-subtitle">
        Everything you need to find or offer freelance services
      </p>

      <div class="feature-grid">
        <div class="feature-card">
          <div class="feature-icon">🔎</div>
          <h3>Discover Talent</h3>
          <p>
            Browse hundreds of services across categories — from web
            development to graphic design, writing, and more.
          </p>
        </div>

        <div class="feature-card">
          <div class="feature-icon">⭐</div>
          <h3>Save Your Favourites</h3>
          <p>
            Heart the services you love and build a curated list of your
            go-to freelancers for future projects.
          </p>
        </div>

        <div class="feature-card">
          <div class="feature-icon">🚀</div>
          <h3>Offer Your Skills</h3>
          <p>
            Are you a student or professional? List your services and connect
            with clients who need your expertise.
          </p>
        </div>

        <div class="feature-card">
          <div class="feature-icon">🔒</div>
          <h3>Trusted Community</h3>
          <p>
            Real users ensure quality work and professional communication every
            time.
          </p>
        </div>
      </div>
    </section>

    <section class="cta-section">
      <h2>Ready to get started?</h2>
      <p>
        Join thousands of students and professionals already using UniGigs.
      </p>

      <div class="cta-buttons">
        <router-link to="/register" class="light-btn">Create Free Account</router-link>
        <router-link to="/explore" class="outline-btn">Browse Services</router-link>
      </div>
    </section>

  </div>
</template>

<script>
export default {
  name: 'HomePage'
}
</script>

<style scoped>
.home-page {
  width: 100%;
}

.hero-section {
  min-height: 640px;
  background: linear-gradient(135deg, #0d2c5a 0%, #133d73 100%);
  color: white;
  display: grid;
  grid-template-columns: 1.1fr 1fr;
  align-items: center;
  gap: 60px;
  padding: 80px 70px;
}

.hero-content {
  max-width: 520px;
}

.hero-badge {
  display: inline-block;
  background: rgba(18, 186, 255, 0.15);
  color: #7dd3fc;
  border: 1px solid rgba(125, 211, 252, 0.35);
  border-radius: 999px;
  padding: 8px 14px;
  font-size: 13px;
  margin-bottom: 22px;
}

.hero-content h1 {
  font-size: 56px;
  line-height: 1.05;
  margin: 0 0 20px;
  font-weight: 800;
}

.hero-content h1 span {
  color: #1bb7ff;
}

.hero-text {
  color: #cbd5e1;
  line-height: 1.7;
  font-size: 16px;
  margin-bottom: 28px;
}

.hero-buttons {
  display: flex;
  gap: 14px;
  margin-bottom: 34px;
}

.primary-btn,
.secondary-btn,
.light-btn,
.outline-btn {
  text-decoration: none;
  padding: 12px 20px;
  border-radius: 10px;
  font-weight: 600;
  display: inline-block;
  transition: 0.2s ease;
}

.primary-btn {
  background: #12baff;
  color: white;
}

.secondary-btn {
  border: 1px solid rgba(255, 255, 255, 0.65);
  color: white;
}

.light-btn {
  background: white;
  color: #119ed8;
}

.outline-btn {
  border: 1px solid rgba(255, 255, 255, 0.7);
  color: white;
}

.primary-btn:hover,
.secondary-btn:hover,
.light-btn:hover,
.outline-btn:hover {
  transform: translateY(-1px);
}

.hero-stats {
  display: flex;
  gap: 34px;
}

.hero-stats div {
  display: flex;
  flex-direction: column;
}

.hero-stats strong {
  font-size: 28px;
  font-weight: 800;
}

.hero-stats span {
  color: #94a3b8;
  font-size: 13px;
  margin-top: 4px;
}

.hero-image-wrapper {
  display: flex;
  justify-content: center;
}

.hero-image {
  width: 100%;
  max-width: 520px;
  height: 360px;
  object-fit: cover;
  border-radius: 22px;
  box-shadow: 0 18px 45px rgba(0, 0, 0, 0.25);
}

.features-section {
  background: #f8fafc;
  text-align: center;
  padding: 80px 70px;
}

.features-section h2 {
  margin: 0;
  font-size: 38px;
  color: #0f172a;
}

.section-subtitle {
  margin-top: 12px;
  color: #64748b;
  font-size: 16px;
}

.feature-grid {
  margin-top: 42px;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 22px;
}

.feature-card {
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 16px;
  text-align: left;
  padding: 26px 22px;
  box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
}

.feature-icon {
  font-size: 24px;
  margin-bottom: 16px;
}

.feature-card h3 {
  margin: 0 0 12px;
  font-size: 18px;
  color: #0f172a;
}

.feature-card p {
  margin: 0;
  color: #64748b;
  line-height: 1.7;
  font-size: 14px;
}

.cta-section {
  background: linear-gradient(90deg, #109ed8 0%, #12baff 100%);
  color: white;
  text-align: center;
  padding: 70px 20px;
}

.cta-section h2 {
  margin: 0 0 12px;
  font-size: 40px;
}

.cta-section p {
  margin: 0 0 28px;
  color: rgba(255, 255, 255, 0.88);
}

.cta-buttons {
  display: flex;
  justify-content: center;
  gap: 16px;
  flex-wrap: wrap;
}

@media (max-width: 1000px) {
  .hero-section {
    grid-template-columns: 1fr;
    padding: 60px 30px;
    text-align: center;
  }

  .hero-content {
    max-width: 100%;
  }

  .hero-buttons,
  .hero-stats {
    justify-content: center;
    flex-wrap: wrap;
  }

  .feature-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 640px) {
  .hero-content h1 {
    font-size: 40px;
  }

  .features-section {
    padding: 60px 20px;
  }

  .feature-grid {
    grid-template-columns: 1fr;
  }

  .cta-section h2 {
    font-size: 30px;
  }
}
</style>