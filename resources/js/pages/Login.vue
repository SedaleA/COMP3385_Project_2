<template>
    <section class="login-page">
        <div class="login-card">
            <div class="card-brand">⚡ UniGigs</div>

            <h1>Welcome back</h1>
            <p class="card-subtitle">Log in to your account to continue</p>

            <form @submit.prevent="handleLogin" class="login-form">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        placeholder="you@example.com"
                    />
                </div>

                <div class="form-group">
                    <div class="password-label-row">
                        <label for="password">Password</label>
                        <a href="#" @click.prevent>Forgot password?</a>
                    </div>

                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        placeholder="Enter your password"
                    />
                </div>

                <button type="submit" :disabled="loading" class="submit-button">
                    {{ loading ? "Logging in..." : "Log In" }}
                </button>
            </form>

            <p v-if="successMessage" class="success-message">
                {{ successMessage }}
            </p>

            <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>

            <p class="bottom-link">
                Don’t have an account?
                <router-link to="/register">Sign up for free</router-link>
            </p>
        </div>
    </section>
</template>

<script>
import api from "../services/api";

export default {
    name: "LoginPage",
    data() {
        return {
            form: {
                email: "",
                password: "",
            },
            loading: false,
            successMessage: "",
            errorMessage: "",
        };
    },
    methods: {
        async handleLogin() {
            this.successMessage = "";
            this.errorMessage = "";

            if (!this.form.email || !this.form.password) {
                this.errorMessage = "Please fill in all fields.";
                return;
            }

            this.loading = true;

            try {
                const response = await api.post("/auth/login", this.form);

                localStorage.setItem("token", response.data.token);
                localStorage.setItem(
                    "user",
                    JSON.stringify(response.data.user),
                );
                localStorage.setItem("user_id", response.data.user.id);

                const token = response.data.token;

                this.successMessage = "Login successful.";
                this.form = {
                    email: "",
                    password: "",
                };

                this.$router.push("/");
            } catch (error) {
                this.errorMessage =
                    error.response?.data?.message || "Login failed.";
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style scoped>
.login-page {
    min-height: calc(100vh - 80px);
    background: #eef3f3;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 80px 20px;
}

.login-card {
    width: 100%;
    max-width: 420px;
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

.login-card h1 {
    text-align: center;
    margin: 0;
    font-size: 32px;
    color: #0f172a;
}

.card-subtitle {
    text-align: center;
    margin: 8px 0 24px;
    color: #64748b;
    font-size: 14px;
}

.login-form {
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

.password-label-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.password-label-row a {
    font-size: 12px;
    color: #0ea5e9;
    text-decoration: none;
    font-weight: 600;
}

input {
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

input:focus {
    border-color: #38bdf8;
    box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15);
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
    .login-card {
        padding: 24px 18px;
    }

    .login-card h1 {
        font-size: 28px;
    }
}
</style>
