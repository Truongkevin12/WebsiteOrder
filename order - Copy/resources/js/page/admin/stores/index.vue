<template>
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Danh sách nhà kho</h5>
        <router-link :to="{ name: 'admin-stores-create' }">
            <button type="button" class="btn btn-primary float-end">Thêm nhà kho</button>
        </router-link>
    </div>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên Kho</th>
                        <th>Ngày tạo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="store in stores" :key="store.ID">
                        <td>{{ store.ID }}</td>
                        <td>{{ store.store_name }}</td>
                        <td>{{ store.created }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <router-link :to="{ name: 'admin-stores-update', params: { id: store.ID } }">
                                        <a class="dropdown-item" href="javascript:void(0);">
                                            <i class="bx bx-edit-alt me-1"></i>Edit
                                        </a>
                                    </router-link>
                                    <a @click="confirmDeleteStore(store)" class="dropdown-item" href="javascript:void(0);">
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
} from 'vue-toast-notification';
import {
    inject
} from 'vue';
export default defineComponent({
    setup() {
        const toast = useToast();
        const stores = ref([]);
        const globalState = inject('globalState');
        const baseUrl = globalState.baseUrl;
        const getStores = () => {
            axios
                .get(`${baseUrl}/api/stores`)
                .then((response) => {
                    stores.value = response.data.stores.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        };
        const deleteStore = (storeId) => {
            axios
                .delete(`${baseUrl}/api/stores/${storeId}`)
                .then(() => {
                    toast.success('Xoá khách hàng thành công');
                    stores.value = stores.value.filter((store) => store.ID !== storeId);
                    console.log(stores.value);
                })
                .catch((error) => {
                    console.log(error);
                    toast.error('Xóa khách hàng thất bại');
                });
        };
        const confirmDeleteStore = (store) => {
            if (window.confirm('Bạn có chắc chắn muốn xoá khách hàng này?')) {
                deleteStore(store.ID);
            }
        };
        getStores();
        return {
            stores,
            confirmDeleteStore,
        };
    },
});
</script>
