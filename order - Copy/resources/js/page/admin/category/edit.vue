<template>
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Sửa nhà kho</h5>
            </div>
            <div class="card-body">
                <form @submit.prevent="updateCategory">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="prd_group_name">Danh mục</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="category.prd_group_name" id="prd_group_name" placeholder="Nhập thêm danh mục vào..." />
                            <small class="text-danger text-start-center" v-if="errors.prd_group_name">{{ errors.prd_group_name[0] }}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="exampleFormControlSelect1" class="col-sm-2 col-form-label">Danh mục cha</label>
                        <div class="col-sm-10">
                            <select v-model="category.level" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                <option value="0" selected="">--Danh mục --</option>
                                <option v-for="categories in categories" :value="categories.ID" :key="categories.ID">{{
                                        categories.prd_group_name }}</option>
                            </select>
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
        const category = ref({
            prd_group_name: "",
            parentid: "",
            user_init: 1,
        });
        const categories = ref([]);
        const getCategoryEdit = () => {
            axios
                .get(`${baseUrl}/api/category/${route.params.id}/edit`)
                .then((response) => {
                    const data = response.data.category;
                    category.value.data = data;
                    console.log(category.value);
                })
                .catch((error) => {
                    console.log(error);
                });
        };
        const updateCategory = () => {
            axios
                .put(`${baseUrl}/api/category/${route.params.id}`, stores.value)
                .then(() => {
                    toast.success("Bạn đã cập nhật tài khoản thành công");
                    router.push({
                        name: "admin-category"
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
        getCategoryEdit();
        return {
            categories,
            errors,
            category,
            updateCategory,
        };
    },
});
</script>
