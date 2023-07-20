<template>
    <div>
        <div class="card text-center">
            <h1>Result List</h1>
        </div>
        <div class="table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <button
                        @click="showForm = true"
                        type="button"
                        class="btn btn-info"
                    >
                        Add Result
                    </button>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label"
                            >Search</label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="exampleInputEmail1"
                            aria-describedby="emailHelp"
                            v-model="search"
                        />
                    </div>
                </div>
            </div>
            <div v-show="showForm">
                <add-result
                    @result-added="getResultList"
                    @cancel-form="showForm = false"
                ></add-result>
            </div>
            <div v-show="showEditForm">
                <edit-result
                    @result-updated="getResultList"
                    @cancel-form="showEditForm = false"
                    :result="updatedResult"
                ></edit-result>
            </div>
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">GPA</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in filter" :key="item.id">
                        <td>{{ ++index }}</td>
                        <td>{{ item.student.name }}</td>
                        <td>{{ item.gpa }}</td>
                        <td>{{ item.student.department.name }}</td>
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
                                @click="deleteResult(item.id)"
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
import AddResult from "./AddResult.vue";
import EditResult from "./EditResult.vue";

export default {
    components: { AddResult, EditResult },
    data() {
        return {
            result: [],
            showForm: false,
            showEditForm: false,
            updatedResult: [],
            search: "",
        };
    },
    methods: {
        async getResultList() {
            const result = await axios.get("/result");
            this.result = result.data;
        },
        async deleteResult(id) {
            const result = await axios.delete("/result/delete/" + id);
            if (result.data.status == true) {
                this.getResultList();
            } else {
                alert("something went wrong please try again");
            }
        },
        displayEditForm(item) {
            this.showEditForm = true;
            this.updatedResult = item;
        },
    },
    computed: {
        filter() {
            if (!this.search) {
                return this.result;
            } else {
                return this.result.filter((res) => {
                    const arr = [
                        res.gpa,
                        res.student.name.toLowerCase(),
                        res.student.department.name,
                    ];
                    return arr.some((e) => e.includes(this.search));
                });
            }
        },
    },
    mounted() {
        this.getResultList();
    },
};
</script>
