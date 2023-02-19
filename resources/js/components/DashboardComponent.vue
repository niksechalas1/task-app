<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Tasks</div>

                    <div class="card-body">
                        <el-row>
                            <el-col :span="24">
                                <el-button
                                    class="float-right"
                                    type="primary"
                                    size="small"
                                    @click="showStoreDialog"
                                >
                                    Add New
                                </el-button>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <el-table
                                    v-loading="loading"
                                    :data="tableData"
                                    style="width: 100%"
                                >
                                    <el-table-column
                                        label="Title"
                                        prop="title"
                                    />
                                    <el-table-column
                                        label="Description"
                                        prop="content"
                                    />
                                    <el-table-column
                                        label="Date"
                                        prop="created_at"
                                    />
                                    <el-table-column align="left">
                                        <template #default="scope">
                                            <el-button
                                                size="small"
                                                @click="
                                                    handleEdit(
                                                        scope.$index,
                                                        scope.row
                                                    )
                                                "
                                            >
                                                Edit
                                            </el-button>
                                            <el-button
                                                size="small"
                                                type="danger"
                                                @click="
                                                    handleDelete(
                                                        scope.$index,
                                                        scope.row
                                                    )
                                                "
                                            >
                                                Complete Task
                                            </el-button>
                                        </template>
                                    </el-table-column>
                                </el-table>
                            </el-col>
                        </el-row>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <el-dialog v-model="showStore" title="New Task" width="30%" draggable>
        <span>
            <el-form
                ref="ruleFormRef"
                :model="newForm"
                label-width="120px"
                :rules="rules"
            >
                <el-form-item label="Title" prop="title">
                    <el-input v-model="newForm.title" />
                </el-form-item>
                <el-form-item label="Description" prop="content">
                    <el-input v-model="newForm.content" type="textarea" />
                </el-form-item>
                <el-form-item>
                    <span class="dialog-footer">
                        <el-button @click="closeDialog">Cancel</el-button>
                        <el-button type="primary" @click="storeDialog">
                            Save
                        </el-button>
                    </span>
                </el-form-item>
            </el-form>
        </span>
    </el-dialog>

    <el-dialog v-model="showUpdate" title="Update Task" width="30%" draggable>
        <span>
            <el-form
                ref="ruleFormRef"
                :model="selectedTask"
                label-width="120px"
                :rules="rules"
            >
                <el-form-item label="Title" prop="title">
                    <el-input v-model="selectedTask.title" />
                </el-form-item>
                <el-form-item label="Description" prop="content">
                    <el-input v-model="selectedTask.content" type="textarea" />
                </el-form-item>
                <el-form-item>
                    <span class="dialog-footer">
                        <el-button @click="closeDialog">Cancel</el-button>
                        <el-button type="primary" @click="updateDialog">
                            Update
                        </el-button>
                    </span>
                </el-form-item>
            </el-form>
        </span>
    </el-dialog>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            tableData: [],
            showStore: false,
            showUpdate: false,
            newForm: {
                title: "",
                content: "",
            },
            rules: {
                title: [
                    {
                        required: true,
                        message: "Please input Title",
                        trigger: "blur",
                    },
                    {
                        min: 5,
                        message: "Length should be more than 4",
                        trigger: "blur",
                    },
                ],
                content: [
                    {
                        required: true,
                        message: "Please input Description",
                        trigger: "blur",
                    },
                    {
                        min: 10,
                        message: "Length should be more than 10",
                        trigger: "blur",
                    },
                ],
            },
            loading: false,
            selectedTask: null,
        };
    },
    methods: {
        handleDelete(index, row) {
            axios.delete("/tasks/delete/" + row.id).then((response) => {
                if (response.data.success) {
                    this.handleFetch();
                }
            });
        },
        handleEdit(index, row) {
            console.log(row);
            this.selectedTask = row;
            this.showUpdate = true;
        },
        handleFetch() {
            this.loading = true;
            axios.get("/tasks/all").then((response) => {
                if (response.data.success) {
                    this.tableData = response.data.data;
                }
            });
            this.loading = false;
        },
        showStoreDialog() {
            this.showStore = true;
        },
        closeDialog() {
            this.newForm.title = "";
            this.newForm.content = "";
            this.showUpdate = false;
            this.showStore = false;
        },
        storeDialog() {
            axios.post("/tasks/store", this.newForm).then((response) => {
                if (response.data.success) {
                    this.handleFetch();
                    this.showStore = false;
                }
            });
        },
        updateDialog() {
            axios
                .post(
                    "/tasks/update/" + this.selectedTask.id,
                    this.selectedTask
                )
                .then((response) => {
                    if (response.data.success) {
                        this.handleFetch();
                        this.showUpdate = false;
                    }
                });
        },
    },
    created() {
        this.handleFetch();
    },
};
</script>
