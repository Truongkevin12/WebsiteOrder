<template>
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Danh sách nhà kho</h5>
        <router-link :to="{ name: 'admin-category-create' }">
            <button type="button" class="btn btn-primary float-end"><i class="bx bx-plus"></i>Thêm danh mục</button>
        </router-link>
    </div>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Danh mục</th>
                        <th>Ngày tạo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="category in category" :key="category.ID">
                        <td>{{ category.ID }}</td>
                        <td>{{ category.prd_group_name }}</td>
                        <td>{{ category.created}}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <router-link :to="{ name: 'admin-category-update', params: { id: category.ID } }">
                                        <a class="dropdown-item" href="javascript:void(0);">
                                            <i class="bx bx-edit-alt me-1"></i>Edit
                                        </a>
                                    </router-link>
                                    <a @click="confirmDeleteCategory(category)" class="dropdown-item" href="javascript:void(0);">
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
        const category = ref([]);
        const globalState = inject('globalState');
        const baseUrl = globalState.baseUrl;
        const getCategory = () => {
            axios
                .get(`${baseUrl}/api/category`)
                .then((response) => {
                    category.value = response.data.category.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        };
        const deleteCategory = (CategoryId) => {
            axios
                .delete(`${baseUrl}/api/category/${CategoryId}`)
                .then(() => {
                    toast.success('Xoá khách hàng thành công');
                    category.value = category.value.filter((category) => category.ID !== CategoryId);
                })
                .catch((error) => {
                    console.log(error);
                    toast.error('Xóa khách hàng thất bại');
                });
        };
        const confirmDeleteCategory = (category) => {
            if (window.confirm('Bạn có chắc chắn muốn xoá khách hàng này?')) {
                deleteCategory(category.ID);
            }
        };
        getCategory();
        return {
            category,
            confirmDeleteCategory,
        };
    },
});
</script>
