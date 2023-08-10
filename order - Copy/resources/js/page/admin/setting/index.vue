<template>
    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Danh sách khách hàng</h5>
        <router-link :to="{ name: 'admin-users-create' }">
          <button type="button" class="btn btn-primary float-end">Thêm khách hàng</button>
        </router-link>
      </div>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Mã nhân viên</th>
                <th>Tên nhân viên</th>
                <th>Email</th>
                <th>Nhóm người sử dụng</th>
                <th>Khu vực</th>
                <th>Trạng thái</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(users, index) in users" :key="index">
                <td>{{ users.id }}</td>
                <td>{{ users.username }}</td>
                <td>{{ users.email }}</td>
                <td>{{ users.store_id }}</td>
                <td>{{ users.group_id }}</td>
                <td class="alert-success" v-if="users.user_status === 1">Hoạt động</td>
                <td class="alert-danger" v-else>Tạm ngừng</td>
                <td>
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                      <router-link :to="{ name: 'admin-users-update', params: { id: users.id } }">
                        <a class="dropdown-item" href="javascript:void(0);">
                          <i class="bx bx-edit-alt me-1"></i>Edit
                        </a>
                      </router-link>
                      <a @click="deleteUsers(users.id)" class="dropdown-item" href="javascript:void(0);">
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
        const getSetting = () => {
            axios
                .get(`${baseUrl}/api/setting`)
                .then((response) => {
                    users.value = response.data.users;
                    stores.value = response.data.stores;
                    users_group.value = response.data.users_group;
                })
                .catch((error) => {
                    console.log(error);
                });
        };
        getSetting();
        return {
            users,
            stores,
            users_group,
        };
    },
});
</script>
