<template>
    <div class="container">
        <div class="card text-center">
            <h1>Login</h1>
        </div>
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label"
                    >Email address</label
                >
                <input
                    type="email"
                    class="form-control"
                    id="exampleInputEmail1"
                    aria-describedby="emailHelp"
                    v-model="email"
                />
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label"
                    >Password</label
                >
                <input
                    type="password"
                    class="form-control"
                    id="exampleInputPassword1"
                    v-model="password"
                />
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            email: "alfoisal940700@gmail.com",
            password: "password",
        };
    },
    methods: {
        async submitForm() {
            try {
                await this.$store.dispatch("setLogin", {
                    email: this.email,
                    password: this.password,
                });
                this.$router.replace({ name: "departmentList" });
            } catch (err) {
                this.error = err;
            }
        },
    },
    computed: {
        ...mapGetters(["isLogin"]),
    },
    mounted() {
        if (this.isLogin) {
            this.$router.push({ name: "departmentList" });
        }
    },
};
</script>
