<template>
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Thêm sản phẩm</h5>
            </div>
            <div class="card-body">
                <form @submit.prevent="createProducts()">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="prd_name">Tên sản phẩm</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="products.prd_name" id="prd_name" placeholder="Nhập tên sản phẩm" />
                            <small class="text-danger text-start-center" v-if="errors.prd_name">{{ errors.prd_name[0] }}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="prd_active">Hoạt chất</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="products.prd_active" id="prd_active" placeholder="Nhập hóa chất" />
                            <small class="text-danger text-start-center" v-if="errors.prd_active">{{ errors.prd_active[0] }}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="prd_content">Nồng độ/ hàm lượng</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="products.prd_content" id="prd_content" placeholder="Nhập nồng độ ,hàm lượng" />
                            <small class="text-danger text-start-center" v-if="errors.prd_content">{{ errors.prd_content[0] }}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="prd_code">Mã sản phẩm</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="products.prd_code" id="prd_code" placeholder="Nếu không nhập, hệ thống tự sinh" />
                            <small class="text-danger text-start-center" v-if="errors.prd_code">{{ errors.prd_code[0] }}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="prd_sell_price">Giá bán</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="products.prd_sell_price" id="prd_sell_price" placeholder="0" />
                            <small class="text-danger text-start-center" v-if="errors.prd_sell_price">{{ errors.prd_sell_price[0] }}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="prd_pack">Quy cách đóng gói</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="products.prd_pack" id="prd_pack" placeholder="Nhập quy cách đóng gói" />
                            <small class="text-danger text-start-center" v-if="errors.prd_pack">{{ errors.prd_pack[0] }}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="exampleFormControlSelect1" class="col-sm-2 col-form-label">Đơn vị tính</label>
                        <div class="col-sm-10">
                            <select v-model="products.prd_unit_id" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                <option v-for="product_unit in product_unit" :value="product_unit.ID" :key="product_unit.value">{{ product_unit.prd_unit_name}}</option>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="row mb-3">
                        <label for="exampleFormControlSelect1" class="col-sm-2 col-form-label">Danh mục</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                <option v-for="product_unit in product_unit" :value="product_unit.ID" :key="product_unit.value">{{ product_unit.prd_unit_name }}</option>
                            </select>
                        </div>
                    </div> -->
                    <div class="row mb-3">
                        <label for="exampleFormControlSelect1" class="col-sm-2 col-form-label">Nhà sản xuất</label>
                        <div class="col-sm-10">
                            <select v-model="products.prd_manufacture_id" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                <option v-for="producer in producer" :value="producer.ID" :key="producer.ID">{{ producer.prd_manuf_name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="exampleFormControlSelect1" class="col-sm-2 col-form-label">Hình ảnh sản phẩm</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file" id="prd_image_url">
                            <small class="text-danger text-start-center" v-if="errors.prd_image_url">{{ errors.prd_image_url[0] }}</small>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <router-link :to="{ name: 'admin-products' }" class="btn btn-primary me-sm-2">
                                Hủy
                            </router-link>
                            <button type="submit" class="btn btn-primary ">Lưu</button>
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
} from 'vue-toast-notification';
import {
    useRouter
} from "vue-router";
import axios from 'axios';
import {
    inject
} from 'vue';
export default defineComponent({
    setup() {
        const globalState = inject('globalState');
        const baseUrl = globalState.baseUrl;
        const toast = useToast();
        const producer = ref([]);
        const product_unit = ref([]);
        const router = useRouter();
        const errors = ref([]);
        const products = ref({
            prd_code: "",
            prd_name: "",
            prd_content: "",
            prd_active: "",
            prd_sell_price: "",
            prd_image_url: "",
            prd_descriptions: "",
            prd_manufacture_id:"",
            prd_unit_id:"",
        });
        const createProducts = () => {
            axios
                .post(`${baseUrl}/api/products`, products.value)
                .then(function (response) {
                    toast.success("Bạn đã tạo tài khoản thành công");
                    router.push({
                        name: 'admin-products'
                    });
                })
                .catch(function (error) {
                    errors.value = error.response.data.errors;
                    toast.error("Bạn đã tạo tài khoản thất bại");
                });
        };
        const getProductsCreat = () => {
            axios
                .get(`${baseUrl}/api/products/create`)
                .then((response) => {
                    producer.value = response.data.producer.data
                    product_unit.value = response.data.product_unit.data
                })
                .catch((error) => {
                    errors.value = error.response.data.errors;
                });
        }
        getProductsCreat();
        return {
            products,
            product_unit,
            createProducts,
            errors,
            producer,
            ...toRefs(products),
        };
    },
});
</script>
