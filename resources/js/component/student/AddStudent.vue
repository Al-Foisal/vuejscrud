<template>
    <form
        style="width: 50%; float: center; margin: 30px"
        @submit.prevent="submitForm"
    >
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label"
                >Student Name</label
            >
            <select v-model="departmentId" id="" class="form-control">
                <option
                    v-for="list in departmentList"
                    :key="list.id"
                    :value="list.id"
                >
                    {{ list.name }}
                </option>
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label"
                >Student Name</label
            >
            <input
                type="text"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
                v-model="studentName"
            />
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label"
                >Batch Name</label
            >
            <input
                type="text"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
                v-model="batchName"
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
    data() {
        return {
            departmentId: "",
            studentName: "",
            batchName: "",
            departmentList: [],
            errorMsg: "",
        };
    },
    methods: {
        async submitForm() {
            try {
                const result = await axios.post("/student/store", {
                    department_id: this.departmentId,
                    name: this.studentName,
                    batch_name: this.batchName,
                });

                if (result.data.status == true) {
                    this.studentName = "";
                    this.departmentId = "";
                    this.batchName = "";
                    this.errorMsg = "";
                    this.$emit("student-added");
                }
            } catch (e) {
                if (e.result.data.error.name[0].length > 0) {
                    this.errorMsg = e.result.data.error.name[0];
                }
            }
        },
        cancelForm() {
            this.name = "";
            this.errorMsg = "";
            this.$emit("cancel-form");
        },
        async getDepartmentList() {
            const result = await axios.get("/student/department-list");
            this.departmentList = result.data;
        },
    },
    mounted() {
        this.getDepartmentList();
    },
};
</script>
