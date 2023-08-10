<template>
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Danh sách người dùng</h5>
        <router-link :to="{ name: 'admin-users-create' }">
            <button type="button" class="btn btn-primary float-end"> <i class='bx bx-plus'></i>Thêm khách hàng</button>
        </router-link>
    </div>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên nhân viên</th>
                        <th>Email</th>
                        <th>Nhóm người sử dụng</th>
                        <th>Khu vực</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in users" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ user.username }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ stores.find(x=>x.ID==user.store_id)?.store_name }}</td>
                        <td>{{ users_group.find(y=>y.id==user.group_id)?.group_name }}</td>
                        <td class="alert-success" v-if="user.user_status === 1">Hoạt động</td>
                        <td class="alert-danger" v-else>Tạm ngừng</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <router-link :to="{ name: 'admin-users-update', params: { id: user.id } }">
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i>Edit</a>
                                    </router-link>
                                    <a @click="deleteUsers(user.id)" class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                                    <router-link :to="{ name: 'admin-users-roles', params: { user: user.id } }">
                                        <a class="dropdown-item" href="javascript:void(0);"><i class='bx bx-detail'></i>Chi tiết</a>
                                    </router-link>
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
    useRouter
} from 'vue-router';
import {
    useToast
} from 'vue-toast-notification';
import {
    inject
} from 'vue';
export default defineComponent({
    setup() {
        const globalState = inject('globalState');
        const baseUrl = globalState.baseUrl;
        const users = ref([]);
        const stores = ref([]);
        const users_group = ref([]);
        const router = useRouter();
        const toast = useToast();
        const getUsers = () => {
            axios
                .get(`${baseUrl}/api/users`)
                .then((response) => {
                    users.value = response.data.users;
                    stores.value = response.data.stores.data;
                    users_group.value = response.data.users_group.data;
                    console.log("store", stores.value);
                    console.log(users.value);
                })
                .catch((error) => {
                    console.log(error);
                });
        };
        const deleteUsers = (userId) => {
            axios
                .delete(`${baseUrl}/api/users/${userId}`)
                .then((response) => {
                    console.log(response);
                    toast.success('Xoá khách hàng thành công');
                    users.value = users.value.filter((user) => user.id !== userId);
                })
                .catch((error) => {
                    console.log(error);
                    toast.error('Failed to delete user');
                });
        };
        getUsers();
        return {
            users,
            stores,
            users_group,
            deleteUsers,
        };
    },
});
</script>
