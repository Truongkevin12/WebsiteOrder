<template>
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Thêm kho</h5>
                </div>
                <div class="card-body">
                    <form @submit.prevent="createStore">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="store_name">Tên kho</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="stores.store_name" id="store_name"
                                    placeholder="Nhập tên kho bạn muốn thêm..." />
                                <small class="text-danger" v-if="errors.store_name">{{ errors.store_name[0] }}</small>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <router-link :to="{ name: 'admin-stores' }" class="btn btn-primary me-sm-2">
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
        const stores = ref({
            store_name: "",
            user_init: 1
        });
        const createStore = () => {
            axios
                .post(`${baseUrl}/api/stores`, stores.value)
                .then((response) => {
                    toast.success("Bạn đã tạo kho thành công");
                    router.push({
                        name: "admin-stores"
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
            stores,
            createStore,
            errors,
        };
    },
});
</script>
