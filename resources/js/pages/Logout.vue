<script>
import api from "../services/api";

export default {
    name: "LogoutPage",
    async mounted() {
        try {
            await api.post("/auth/logout");
        } catch (error) {
            console.error("Logout failed:", error);
        } finally {
            localStorage.removeItem("token");
            localStorage.removeItem("user");
            this.$router.replace("/login");
        }
    },
};
</script>

<template>
    <section style="padding: 40px; text-align: center">
        <p>Logging you out...</p>
    </section>
</template>
