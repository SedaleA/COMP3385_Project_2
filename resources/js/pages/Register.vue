<template>
    <section class="register-page">
        <div class="register-card">
            <div class="card-brand">⚡ UniGigs</div>

            <h1>Create your account</h1>
            <p class="card-subtitle">Join the freelance community today</p>

            <form @submit.prevent="handleRegister" class="register-form">
                <div class="form-group">
                    <label for="photo"
                        >Profile Photo <span>(optional)</span></label
                    >

                    <div class="photo-upload-row">
                        <div class="photo-preview">
                            <img
                                v-if="photoPreview"
                                :src="photoPreview"
                                alt="Profile preview"
                            />
                            <span v-else>👤</span>
                        </div>

                        <div class="photo-upload-text">
                            <input
                                id="photo"
                                type="file"
                                accept="image/*"
                                @change="handlePhotoChange"
                            />
                            <small>JPG, PNG or GIF up to 3MB</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Full Name <span>*</span></label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        placeholder="e.g. Jane Smith"
                    />
                </div>

                <div class="form-group">
                    <label for="email">Email Address <span>*</span></label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        placeholder="you@example.com"
                    />
                </div>

                <div class="two-column-row">
                    <div class="form-group">
                        <label for="password">Password <span>*</span></label>
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            placeholder="Min. 6 characters"
                        />
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword"
                            >Confirm Password <span>*</span></label
                        >
                        <input
                            id="confirmPassword"
                            v-model="confirmPassword"
                            type="password"
                            placeholder="Repeat password"
                        />
                    </div>
                </div>

                <div class="form-group">
                    <label for="location">Location <span>*</span></label>
                    <input
                        id="location"
                        v-model="form.location"
                        type="text"
                        placeholder="e.g. St. John's"
                    />
                </div>

                <div class="form-group">
                    <label for="biography">Biography <span>*</span></label>
                    <textarea
                        id="biography"
                        v-model="form.biography"
                        placeholder="Tell clients about your skills, experience, and what you love to do..."
                        maxlength="250"
                    ></textarea>
                    <small>{{ form.biography.length }}/250 characters</small>
                </div>

                <button type="submit" :disabled="loading" class="submit-button">
                    {{ loading ? "Creating Account..." : "Create Account" }}
                </button>
            </form>

            <p v-if="successMessage" class="success-message">
                {{ successMessage }}
            </p>
            <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>

            <p class="bottom-link">
                Already have an account?
                <router-link to="/login">Log in</router-link>
            </p>
        </div>
    </section>
</template>

<script>
import api from "../services/api";

export default {
    name: "RegisterPage",
    data() {
        return {
            form: {
                name: "",
                email: "",
                password: "",
                location: "",
                biography: "",
                photo: null,
            },
            confirmPassword: "",
            photoPreview: "",
            loading: false,
            successMessage: "",
            errorMessage: "",
        };
    },
    methods: {
        handlePhotoChange(event) {
            const file = event.target.files[0] || null;
            this.form.photo = file;

            if (file) {
                this.photoPreview = URL.createObjectURL(file);
            } else {
                this.photoPreview = "";
            }
        },
        async handleRegister() {
            this.successMessage = "";
            this.errorMessage = "";

            if (
                !this.form.name ||
                !this.form.email ||
                !this.form.password ||
                !this.form.location ||
                !this.form.biography ||
                !this.confirmPassword
            ) {
                this.errorMessage = "Please fill in all required fields.";
                return;
            }

            if (this.form.password.length < 8) {
                this.errorMessage = "Password must be at least 8 characters.";
                return;
            }

            if (this.form.password !== this.confirmPassword) {
                this.errorMessage = "Passwords do not match.";
                return;
            }

            this.loading = true;

            try {
                const formData = new FormData();
                formData.append("name", this.form.name);
                formData.append("email", this.form.email);
                formData.append("password", this.form.password);
                formData.append("password_confirmation", this.confirmPassword);
                formData.append("location", this.form.location);
                formData.append("biography", this.form.biography);

                if (this.form.photo) {
                    formData.append("photo", this.form.photo);
                }

                const response = await api.post("/auth/register", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });

                localStorage.setItem("token", response.data.token);
                localStorage.setItem(
                    "user",
                    JSON.stringify(response.data.user),
                );
                localStorage.setItem("user_id", response.data.user.id);

                this.successMessage = "Registration successful.";

                this.$router.push("/users/" + response.data.user.id);

                this.form = {
                    name: "",
                    email: "",
                    password: "",
                    location: "",
                    biography: "",
                    photo: null,
                };
                this.confirmPassword = "";
                this.photoPreview = "";
            } catch (error) {
                const data = error.response?.data;
                if (data?.errors) {
                    this.errorMessage = Object.values(data.errors)
                        .flat()
                        .join(" ");
                } else {
                    this.errorMessage = data?.message || "Registration failed;";
                }
                console.error(error);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style scoped>
.register-page {
    min-height: calc(100vh - 80px);
    background: #eef3f3;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 60px 20px;
}

.register-card {
    width: 100%;
    max-width: 540px;
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
    padding: 30px 28px 24px;
}

.card-brand {
    text-align: center;
    font-weight: 800;
    color: #0ea5e9;
    margin-bottom: 8px;
    font-size: 14px;
}

.register-card h1 {
    text-align: center;
    margin: 0;
    font-size: 34px;
    color: #0f172a;
}

.card-subtitle {
    text-align: center;
    margin: 8px 0 24px;
    color: #64748b;
    font-size: 14px;
}

.register-form {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.form-group label {
    font-size: 13px;
    font-weight: 700;
    color: #334155;
}

.form-group label span {
    font-weight: 500;
    color: #94a3b8;
}

input,
textarea {
    width: 100%;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 11px 13px;
    font-size: 14px;
    color: #0f172a;
    background: #fff;
    outline: none;
    box-sizing: border-box;
}

input:focus,
textarea:focus {
    border-color: #38bdf8;
    box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15);
}

textarea {
    min-height: 110px;
    resize: none;
}

.form-group small {
    color: #94a3b8;
    font-size: 12px;
}

.photo-upload-row {
    display: flex;
    align-items: center;
    gap: 14px;
}

.photo-preview {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    color: #64748b;
    font-size: 20px;
    flex-shrink: 0;
}

.photo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.photo-upload-text {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.photo-upload-text input[type="file"] {
    padding: 0;
    border: none;
    box-shadow: none;
}

.two-column-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

.submit-button {
    width: 100%;
    border: none;
    border-radius: 8px;
    background: #0ea5e9;
    color: white;
    font-size: 14px;
    font-weight: 700;
    padding: 12px;
    cursor: pointer;
    margin-top: 6px;
}

.submit-button:hover {
    background: #0284c7;
}

.submit-button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.success-message {
    margin-top: 14px;
    color: green;
    text-align: center;
}

.error-message {
    margin-top: 14px;
    color: red;
    text-align: center;
}

.bottom-link {
    text-align: center;
    margin-top: 18px;
    font-size: 14px;
    color: #64748b;
}

.bottom-link a {
    color: #0ea5e9;
    text-decoration: none;
    font-weight: 700;
}

@media (max-width: 640px) {
    .register-card {
        padding: 24px 18px;
    }

    .register-card h1 {
        font-size: 28px;
    }

    .two-column-row {
        grid-template-columns: 1fr;
    }

    .photo-upload-row {
        align-items: flex-start;
        flex-direction: column;
    }
}
</style>
