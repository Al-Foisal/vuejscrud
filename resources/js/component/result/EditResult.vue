<template>
    <form
        style="width: 50%; float: center; margin: 30px"
        @submit.prevent="submitForm"
    >
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label"
                >Student Name</label
            >
            <select v-model="studentId" id="" class="form-control">
                <option
                    v-for="list in studentList"
                    :key="list.id"
                    :value="list.id"
                >
                    {{ list.name }}
                </option>
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">GPA</label>
            <input
                type="text"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
                v-model="gpa"
            />
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Date</label>
            <input
                type="date"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
                v-model="date"
            />
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <button @click="cancelForm" type="button" class="btn btn-danger">
            Cancel
        </button>
    </form>
</template>

<script>
export default {
    props: ["result"],
    data() {
        return {
            studentId: "",
            gpa: "",
            date: "",
            errorMsg: "",
            studentList: [],
        };
    },

    methods: {
        async submitForm() {
            try {
                const result = await axios.post(
                    "/result/update/" + this.result.id,
                    {
                        student_id: this.studentId,
                        gpa: this.gpa,
                        date: this.date,
                    }
                );

                if (result.data.status == true) {
                    this.studentId = "";
                    this.gpa = "";
                    this.date = "";
                    this.$emit("result-updated");
                    this.cancelForm();
                }
            } catch (e) {
                console.log('error');
            }
        },
        cancelForm() {
            this.studentId = "";
            this.gpa = "";
            this.date = "";
            this.errorMsg = "";
            this.$emit("cancel-form");
        },
        async getStudentList() {
            const result = await axios.get("/result/student-list");
            this.studentList = result.data;
        },
    },
    mounted() {
        this.getStudentList();
    },
    watch: {
        result(value) {
            this.studentId = value.student_id;
            this.gpa = value.gpa;
            this.date = value.date;
        },
    },
};
</script>
