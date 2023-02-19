<template>
    <div class="container">
        <el-form
            v-loading="loading"
            ref="UserForm"
            :model="UserForm"
            label-width="150px"
            :rules="rules"
        >
            <el-form-item label="Email" prop="email">
                <el-input v-model="UserForm.email" />
            </el-form-item>
            <el-form-item label="Password" prop="pass">
                <el-input
                    v-model="UserForm.pass"
                    type="password"
                    autocomplete="off"
                />
            </el-form-item>
            <el-form-item label="Confirm Password" prop="checkPass">
                <el-input
                    v-model="UserForm.checkPass"
                    type="password"
                    autocomplete="off"
                />
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submitForm('UserForm')"
                    >Update</el-button
                >
                <el-button @click="resetForm('UserForm')">Reset</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
import axios from "axios";

export default {
    props: ["user"],
    data() {
        var validatePass = (rule, value, callback) => {
            if (value === "") {
                callback(new Error("Please input the password"));
            } else {
                if (this.UserForm.checkPass !== "") {
                    this.$refs.UserForm.validateField("checkPass");
                }
                callback();
            }
        };
        var validatePass2 = (rule, value, callback) => {
            if (value === "") {
                callback(new Error("Please input the password again"));
            } else if (value !== this.UserForm.pass) {
                callback(new Error("Two inputs don't match!"));
            } else {
                callback();
            }
        };
        return {
            UserForm: this.user,
            loading: false,
            rules: {
                email: [
                    {
                        required: true,
                        message: "Please input email address",
                        trigger: "blur",
                    },
                    {
                        type: "email",
                        message: "Please input correct email address",
                        trigger: ["blur", "change"],
                    },
                ],
                pass: [{ validator: validatePass, trigger: "blur" }],
                checkPass: [{ validator: validatePass2, trigger: "blur" }],
            },
        };
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.loading = true;
                    axios
                        .post("/users/update", this.UserForm)
                        .then((response) => {
                            if (response.data.success) {
                                this.UserForm = response.data.data;
                            }
                        });
                    this.resetForm("UserForm");
                    this.loading = false;
                } else {
                    console.log("error submit!!");
                    return false;
                }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
    },
};
</script>
