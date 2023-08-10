<template>
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Sửa khách hàng</h5>
            </div>
            <div class="card-body">
                <form @submit.prevent="updateCustomer">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="customer_code">Mã khách hàng</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="customer.customer_code" id="customer_code" placeholder="Mã khách hàng(tự sinh nếu bỏ trống)" />
                        </div>
                        <div class="col-sm-10">
                            <small v-if="errors.customer_code">{{ errors.customer_code[0] }}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="customer_name">Tên khách hàng</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="customer.customer_name" id="customer_name" placeholder="Nhập tên khách hàng( bắc buộc )" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="customer_phone">Số điện thoại</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="customer.customer_phone" id="customer_phone" placeholder="012345678" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="customer_email">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="customer.customer_email" id="customer_email" placeholder="Nhập email khách hàng ( ví dụ: abc@gmail.com )" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="customer_addr">Địa chỉ</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="customer.customer_addr" id="customer_addr" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="customer_ship_addr">Địa chỉ nhận hàng</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="customer.customer_ship_addr" id="customer_ship_addr" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="exampleFormControlSelect1" class="col-sm-2 col-form-labe">Khu vực</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                <option v-for="stores in stores" :value="stores.value" :key="stores.value">{{ stores.store_name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="notes">Ghi chú</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" v-model="customer.notes" id="notes" rows="5"></textarea>
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
        const {
            params
        } = useRoute(); // Destructure useRoute() to get access to params
        const errors = ref({});
        const stores = ref([]); // Initialize as an array instead of an object
        const customer = ref({
            customer_code: "",
            customer_name: "",
            customer_email: "",
            customer_phone: "",
            customer_addr: "",
            customer_ship_addr: "",
            customer_store: "",
            notes: "",
            customer_image: "",
            user_init: 0,
            created: "2020-06-16 10:37:31",
        });

        const getCustomerEdit = () => {
            axios
                .get(`${baseUrl}/api/customers/${params.id}/edit`) // Use params.id instead of route.params.id
                .then((response) => {
                    const data = response.data.customer;
                    customer.value = data;
                    stores.value = response.data.stores;
                })
                .catch((error) => {
                    console.log(error);
                });
        };

        const updateCustomer = () => {
            axios
                .put(`${baseUrl}/api/customers/${params.id}`, customer.value) // Use params.id instead of route.params.id
                .then(() => {
                    toast.success("Bạn đã cập nhật tài khoản thành công");
                    router.push({
                        name: "admin-customers"
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

        getCustomerEdit();

        return {
            customer,
            errors,
            stores,
            updateCustomer,
        };
    },
});
</script>
