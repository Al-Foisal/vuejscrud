<template>
    <form
        style="width: 50%; float: center; margin: 30px"
        @submit.prevent="submitForm"
    >
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label"
                >Department Name</label
            >
            <input
                type="text"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
                v-model="name"
            />
            <div id="emailHelp" class="form-text" v-if="errorMsg.length">
                {{ errorMsg }}
            </div>
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
            name: "",
            errorMsg: "",
        };
    },
    methods: {
        async submitForm() {
            try {
                const result = await axios.post("/department/store", {
                    name: this.name,
                });

                if (result.data.status == true) {
                    this.name = "";
                    this.errorMsg = "";
                    this.$emit("department-added");
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
    },
};
</script>
