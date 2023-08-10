<template>
<div class="row">
    <div class="col-12 col-lg-8">
        <div class="card mb-4">
            <h5 class="card-header">Chi tiết sản phẩm</h5>
            <div class="card-body">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="align-middle"><strong class="fw-semibold">Tên sản phẩm</strong></td>
                            <td class="py-3">
                                <p class="mb-0">{{ products.prd_name }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle"><strong class="fw-semibold">Hoạt chất</strong></td>
                            <td class="py-3">
                                <p class="mb-0">{{ products.prd_active }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle"><strong class="fw-semibold">Nồng độ/ hàm lượng</strong></td>
                            <td class="py-3">
                                <p class="mb-0">{{ products.prd_content }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle"><strong class="fw-semibold">Quy cách đóng gói</strong></td>
                            <td class="py-3">
                                <p class="mb-0">{{ products.prd_pack }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle"><strong class="fw-semibold">Danh mục</strong></td>
                            <td class="py-3">
                                <p class="mb-0">{{ products.prd_name }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle"><strong class="fw-semibold">Mã sản phẩm</strong></td>
                            <td class="py-3">
                                <p class="mb-0">{{ category.find(x=>x.ID==products.prd_group_id)?.prd_group_name }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle"><strong class="fw-semibold">Giá bán</strong></td>
                            <td class="py-3">
                                <p class="mb-0">{{ products.prd_sell_price.toLocaleString() }}</p>
                            </td>
                        </tr>
                        <div class="row justify-content">
                            <div class="col-sm-10">
                                <router-link :to="{ name: 'admin-products' }" class="btn btn-primary me-sm-2">Trở về</router-link>
                            </div>
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card mb-4">

            <div class="card-header d-flex justify-content-between">
                <h6 class="card-title m-0">Hình ảnh</h6>
            </div>
            <div class="card-body">
                <div class="rounded-3 text-center">
          <img class="img-fluid w-60" src="https://vapa.vn/wp-content/uploads/2022/12/anh-hoa-huong-duong-dep.jpeg" alt="Card girl image">
        </div>
            </div>

        </div>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h6 class="card-title m-0">Danh mục</h6>
            </div>
            <div class="card-body ">
                <div class="d-flex justify-content-between">
                    <h6 class="card-title m-6">Danh mục</h6>
                    <p class="m-6">{{ products.prd_name }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <h6 class="card-title m-6">Nhà sản xuất</h6>
                    <p class="m-6">{{ producer.find(x=>x.ID==products.prd_manufacture_id)?.prd_manuf_name }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <h6 class="card-title m-6">Đơn vị</h6>
                    <p class="m-6">{{ product_unit.find(x=>x.ID==products.prd_unit_id)?.prd_unit_name }}</p>
                </div>

            </div>

        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios';
import {
    defineComponent,
    ref,
    watch
} from 'vue';
import {
    inject
} from 'vue';
import {
    useRouter,
    useRoute
} from "vue-router";
export default defineComponent({
    setup() {
        const globalState = inject('globalState');
        const baseUrl = globalState.baseUrl;
        const products = ref([]);
        const router = useRouter();
        const route = useRoute();
        const producer = ref([]);
        const product_unit = ref([]);
        const category = ref([]);
        const getProducts = () => {
            axios
                .get(`${baseUrl}/api/products/${route.params.products}`)
                .then((response) => {
                    const data = response.data.products;
                    products.value = data;
                    producer.value = response.data.producer.data;
                    product_unit.value = response.data.product_unit.data;
                    category.value = response.data.category.data;
                    console.log(product_unit.value);
                })
                .catch((error) => {
                    console.log(error);
                });
        };
        getProducts();
        return {
            products,
            product_unit,
            producer,
            route,
            category,
        };
    },
});
</script>
