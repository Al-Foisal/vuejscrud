<template>
    <div>
        <div class="card text-center">
            <h1>Department List</h1>
            {{ user }}
        </div>
        <div class="table-responsive">
            <button @click="showForm = true" type="button" class="btn btn-info">
                Add Department
            </button>
            <div v-show="showForm">
                <add-department
                    @department-added="getDepartmentList"
                    @cancel-form="showForm = false"
                ></add-department>
            </div>

            <div v-show="showEditForm">
                <edit-department
                    @department-updated="getDepartmentList"
                    @cancel-form="showEditForm = false"
                    :department="updatedDepartmentId"
                ></edit-department>
            </div>

            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in department" :key="item.id">
                        <td>{{ ++index }}</td>
                        <td>{{ item.name }}</td>
                        <td>
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="displayEditForm(item)"
                            >
                                Edit
                            </button>

                            <button
                                type="button"
                                class="btn btn-danger"
                                @click="deleteDepartment(item.id)"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import AddDepartment from "./AddDepartment.vue";
import EditDepartment from "./EditDepartment.vue";
import { mapGetters } from "vuex";
export default {
    components: {
        AddDepartment,
        EditDepartment,
    },

    data() {
        return {
            department: [],
            showForm: false,
            showEditForm: false,
            updatedDepartmentId: "",
        };
    },
    methods: {
        async getDepartmentList() {
            const result = await axios.get("/department");
            this.department = result.data;
        },
        async deleteDepartment(id) {
            const result = await axios.delete("/department/delete/" + id);
            if (result.data.status == true) {
                this.getDepartmentList();
            } else {
                alert("something went wrong please try again");
            }
        },
        displayEditForm(item) {
            this.showEditForm = true;
            this.updatedDepartmentId = item;
        },
    },
    computed: {
        ...mapGetters(["user"]),
    },
    mounted() {
        this.getDepartmentList();
    },
};
</script>
