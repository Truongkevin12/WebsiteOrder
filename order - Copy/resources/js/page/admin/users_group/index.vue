<template>
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Danh sách người dùng</h5>
        <router-link :to="{ name: 'admin-groupusers-create' }">
            <button type="button" class="btn btn-primary float-end">Thêm nhà kho</button>
        </router-link>
    </div>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên nhóm</th>
                        <th>Ngày tạo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user_group, index) in user_group" :key="index">
                        <td>{{ user_group.id }}</td>
                        <td>{{ user_group.group_name }}</td>
                        <td>{{ user_group.group_registered }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <router-link :to="{ name: 'admin-groupusers-update', params: { id: user_group.id } }">
                                        <a class="dropdown-item" href="javascript:void(0);">
                                            <i class="bx bx-edit-alt me-1"></i>Edit
                                        </a>
                                    </router-link>
                                    <a @click="confirmDeleteGroup(user_group)" class="dropdown-item" href="javascript:void(0);">
                                        <i class="bx bx-trash me-1"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</template>


<script>
import axios from 'axios';
import {
    defineComponent,
    ref
} from 'vue';
import {
    useToast
} from "vue-toast-notification";
import {
    inject
} from 'vue';
export default defineComponent({
    setup() {
        const globalState = inject('globalState');
        const baseUrl = globalState.baseUrl;
        const toast = useToast();
        const user_group = ref([]);
        const getUsersGroup = () => {
            axios
                .get(`${baseUrl}/api/groupusers`)
                .then((response) => {
                    user_group.value = response.data.user_group.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        };
        const deleteGroupUser = (user_groupId) => {
            axios
                .delete(`${baseUrl}/api/groupusers/${user_groupId}`)
                .then(() => {
                    toast.success('Xoá khách hàng thành công');
                    user_group.value = user_group.value.filter((user_group) => user_group.id !== user_groupId);
                })
                .catch((error) => {
                    console.log(error);
                    toast.error('Xóa khách hàng thất bại');
                });
        };
        const confirmDeleteGroup = (user_group) => {
            if (window.confirm('Bạn có chắc chắn muốn xoá khách hàng này?')) {
                deleteGroupUser(user_group.id);
            }
        };
        getUsersGroup();
        return {
            user_group,
            confirmDeleteGroup,
        };
    },
});
</script>
