<template>
    <header
        class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow"
    >
        <router-link
            v-if="!isLogin"
            :to="{ name: 'login' }"
            class="navbar-brand col-md-3 col-lg-2 me-0 px-3"
            >Login</router-link
        >

        <div class="navbar-nav" v-if="isLogin">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="#" @click="logout()">Sign out</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav
                v-if="isLogin"
                id="sidebarMenu"
                class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse"
            >
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <router-link
                                class="nav-link active"
                                aria-current="page"
                                :to="{ name: 'departmentList' }"
                            >
                                <span data-feather="home"></span>
                                Department
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                class="nav-link"
                                :to="{ name: 'studentList' }"
                            >
                                <span data-feather="file"></span>
                                Student
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                class="nav-link"
                                :to="{ name: 'resultList' }"
                            >
                                <span data-feather="shopping-cart"></span>
                                Result
                            </router-link>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-5">
                <router-view></router-view>
            </main>
        </div>
    </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
    computed: {
        ...mapGetters(["isLogin"]),
    },
    methods: {
        async logout() {
            const result = await this.$store.dispatch("logout");
            console.log(result);
            this.$router.replace({ name: "login" });
        },
    },
};
</script>
