import { createApp } from "vue/dist/vue.esm-bundler.js";
import { createRouter, createWebHistory } from "vue-router";
import store from "./store.js";

import axios from "axios";
axios.defaults.withCredentials = true;
axios.defaults.baseURL = "http://vuecrud.foisal/api";

import App from "./component/App.vue";
import TheLogin from "./component/TheLogin.vue";
import DepartmentList from "./component/department/DepartmentList.vue";
import StudentList from "./component/student/StudentList.vue";
import ResultList from "./component/result/ResultList.vue";

import "./bootstrap";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/login",
            component: TheLogin,
            name: "login",
        },
        {
            path: "/department",
            component: DepartmentList,
            name: "departmentList",
            meta: { requiresAuth: true },
        },
        {
            path: "/student",
            component: StudentList,
            name: "studentList",
            meta: { requiresAuth: true },
        },
        {
            path: "/result",
            component: ResultList,
            name: "resultList",
            meta: { requiresAuth: true },
        },
    ],
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (!store.getters.isLogin) {
            next({ name: "login" });
        } else {
            next();
        }
    } else {
        next(); //make sure to always call to next()
    }
});
store.dispatch("getUser").then(() => {
    const app = createApp(App);

    app.use(store);
    app.use(router);
    app.mount("#app");
});
