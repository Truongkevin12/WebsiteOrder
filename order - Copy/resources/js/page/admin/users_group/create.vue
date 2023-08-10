<template>
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Thêm nhóm người dùng</h5>
                </div>
                <div class="card-body">
                    <form @submit.prevent="createUserGroup">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="store_name">Tên người dùng</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="user_group.group_name" id="store_name"
                                    placeholder="Nhập tên kho bạn muốn thêm..." />
                                <small class="text-danger" v-if="errors.group_name">{{ errors.group_name[0] }}</small>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <router-link :to="{ name: 'admin-groupusers' }" class="btn btn-primary me-sm-2">
                                    Hủy
                                </router-link>
                                <button type="submit" class="btn btn-primary">Lưu</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {
    defineComponent,
    ref
} from "vue";
import {
    useToast
} from "vue-toast-notification";
import {
    useRouter
} from "vue-router";
import axios from "axios";
import {
    inject
} from 'vue';
export default defineComponent({
    setup() {
        const globalState = inject('globalState');
        const baseUrl = globalState.baseUrl;
        const toast = useToast();
        const router = useRouter();
        const errors = ref({});
        const user_group = ref({
            group_name: "",
        });
        const createUserGroup = () => {
            axios
                .post(`${baseUrl}/api/groupusers`, user_group.value)
                .then((response) => {
                    toast.success("Bạn đã tạo kho thành công");
                    router.push({
                        name: "admin-groupusers"
                    });
                })
                .catch((error) => {
                    if (error.response && error.response.data && error.response.data.errors) {
                        errors.value = error.response.data.errors;
                    } else {
                        toast.error("Có lỗi xảy ra khi tạo kho");
                    }
                });
        };

        return {
            user_group,
            createUserGroup,
            errors,
        };
    },
});
</script>
