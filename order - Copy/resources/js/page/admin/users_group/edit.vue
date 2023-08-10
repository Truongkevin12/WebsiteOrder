<template>
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Sửa nhà kho</h5>
            </div>
            <div class="card-body">
                <form @submit.prevent="updateUserGroup">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="store_name">Tên người dùng</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="user_group.group_name" id="store_name" placeholder="Nhập tên kho bạn muốn thêm..." />
                            <small class="text-danger" v-if="errors.group_name">{{ errors.group_name[0] }}</small>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <router-link :to="{ name: 'admin-stores' }" class="btn btn-primary me-sm-2">Hủy</router-link>
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
    ref,
    toRefs
} from "vue";
import {
    useToast
} from "vue-toast-notification";
import {
    useRouter,
    useRoute
} from "vue-router";
import {
    inject
} from 'vue';
import axios from "axios";
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
        const getUserGroupEdit = () => {
            axios
                .get(`${baseUrl}/api/groupusers/${route.params.id}/edit`)
                .then((response) => {
                    const data = response.data.user_group;
                    user_group.value = data;
                })
                .catch((error) => {
                    console.log(error);
                });
        };
        const updateUserGroup = () => {
            axios
                .put(`${baseUrl}/api/groupusers/${route.params.id}`, user_group.value)
                .then(() => {
                    toast.success("Bạn đã cập nhật tài khoản thành công");
                    router.push({
                        name: "admin-groupusers"
                    });
                })
                .catch((error) => {
                    if (error.response && error.response.data && error.response.data.errors) {
                        errors.value = error.response.data.errors;
                    } else {
                        toast.error("Cập nhật tài khoản thất bại");
                    }
                });
        };
        const route = useRoute();
        getUserGroupEdit();
        return {
            user_group,
            errors,
            updateUserGroup,
        };
    },
});
</script>
