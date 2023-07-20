<template>
    <div>
        <div class="card text-center">
            <h1>Student List</h1>
        </div>
        <div class="table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <button
                        @click="showForm = true"
                        type="button"
                        class="btn btn-info"
                    >
                        Add Student
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
                <add-student
                    @student-added="getStudentList"
                    @cancel-form="showForm = false"
                ></add-student>
            </div>
            <div v-show="showEditForm">
                <edit-student
                    @student-updated="getStudentList"
                    @cancel-form="showEditForm = false"
                    :student="updatedSudent"
                ></edit-student>
            </div>
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Department Name</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Batch Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in filter" :key="item.id">
                        <td>{{ ++index }}</td>
                        <td>{{ item.department.name }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.batch_name }}</td>
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
                                @click="deleteStudent(item.id)"
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
import AddStudent from "./AddStudent.vue";
import EditStudent from "./EditStudent.vue";
export default {
    components: { AddStudent, EditStudent },
    data() {
        return {
            student: [],
            showForm: false,
            showEditForm: false,
            updatedSudent: "",
            search: "",
        };
    },
    methods: {
        async getStudentList() {
            const result = await axios.get("/student");
            this.student = result.data;
        },
        async deleteStudent(id) {
            const result = await axios.delete("/student/delete/" + id);
            if (result.data.status == true) {
                this.getStudentList();
            } else {
                alert("something went wrong please try again");
            }
        },
        displayEditForm(item) {
            this.showEditForm = true;
            this.updatedSudent = item;
        },
    },
    computed: {
        filter() {
            if (!this.search) {
                return this.student;
            } else {
                return this.student.filter((std) => {
                    const data =
                        std.results?.map(({ gpa }) => gpa.toLowerCase()) ?? [];
                    const arr = [
                        std.name.toLowerCase(),
                        std.department.name.toLowerCase(),
                        ...data,
                    ];
                    return arr.some((e) => e.includes(this.search));
                });
            }
        },
    },
    mounted() {
        this.getStudentList();
    },
};
</script>
