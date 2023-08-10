<template>
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sản phẩm /</span> Danh sách</h4>
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div>
            <input class="form-control" id="html5-search-input" v-model="searchKeyword" @input="searchProducts" type="text" placeholder="Nhập mã sản phẩm hoặc tên sản phẩm,hoạt chất ...">
        </div>
        <div class="mb-3 me-sm-2">
            <label for="exampleFormControlSelect1" class="form-label">Trạng thái</label>
            <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                <option>ừefefe</option>
            </select>
        </div>
        <div class="mb-3 me-sm-2">
            <label for="exampleFormControlSelect1" class="form-label">Danh mục</label>
            <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                <option>ừefefe</option>
            </select>
        </div>
        <div class="mb-3 me-sm-2">
            <label for="exampleFormControlSelect1" class="form-label">Nhà sản xuất</label>
            <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                <option>ừefefe</option>
            </select>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Hoạt chất</th>
                        <th>Nồng độ/hàm lượng</th>
                        <th>Giá bán</th>
                        <th>Nhà sản xuất</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(product, index) in products" :key="index">
                        <td> {{ product.prd_code }}</td>
                        <td>
                            <router-link :to="{ name: 'admin-products-detail', params: { products: product.ID } }"> {{ product.prd_name }}</router-link>
                        </td>
                        <td>{{ product.prd_active }}</td>
                        <td>{{ product.prd_content }}</td>
                        <td>{{ product.prd_sell_price.toLocaleString()}}</td>
                        <td>{{ products_manuf.find(x=>x.ID==product.prd_manufacture_id)?.prd_manuf_name }}</td>
                        <td class="alert-success" v-if="product.prd_status === 1">Hoạt động</td>
                        <td class="alert-danger" v-else>Tạm ngừng</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <router-link :to="{ name: 'admin-products-detail', params: { products: product.ID } }">
                                        <a class="dropdown-item" href="javascript:void(0);"><i class='bx bx-detail me-1'></i>Chi tiết</a>
                                    </router-link>
                                    <router-link :to="{ name: 'admin-products-update', params: { id: product.ID } }">
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i>Edit</a>
                                    </router-link>
                                    <a @click="confirmDeleteProducts(product)" class="dropdown-item" href="javascript:void(0);">
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
    ref,
    watch
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
        const globalState = inject('globalState');
        const baseUrl = globalState.baseUrl;
        const products = ref([]);
        const products_manuf = ref([]);
        const searchKeyword = ref('');
        const status = ref([]);
        const category = ref([]);
        const currentPage = ref(1); // Current page number
        const itemsPerPage = 10; // Number of items to display per page (adjust as needed)
        let totalPages = ref(0); // Total number of pages (initially set to 0)
        const getProducts = () => {
            axios
                .get(`${baseUrl}/api/products`, {
                    params: {
                        page: currentPage.value,
                        per_page: itemsPerPage,
                        keyword: searchKeyword.value,
                    },
                })
                .then((response) => {
                    products.value = response.data.product.data;
                    products_manuf.value = response.data.products_manuf.data;
                    totalPages.value = response.data.product.last_page;
                    category.value = response.data.category.data;
                    status.value = response.data.status.data;
                    console.log(status.value)
                })
                .catch((error) => {
                    console.log(error);
                });
        };
        const deleteProducts = (productsId) => {
            axios
                .delete(`${baseUrl}/api/products/${productsId}`)
                .then(() => {
                    toast.success('Xoá khách hàng thành công');
                    products.value = products.value.filter((products) => products.ID !== productsId);
                    category.value = category.value.category.data,
                        producer.value = response.data.producer.data,
                        console.log(category.value);
                })
                .catch((error) => {
                    console.log(error);
                    toast.error('Xóa khách hàng thất bại');
                });
        };
        watch(currentPage, () => {
            getProducts();
        });
        const changePage = (page) => {
            currentPage.value = page;
        };
        const searchProducts = () => {
            currentPage.value = 1;
            getProducts();
        };
        const confirmDeleteProducts = (products) => {
            if (window.confirm('Bạn có chắc chắn muốn xoá khách hàng này?')) {
                deleteProducts(products.ID);
            }
        };
        getProducts();
        return {
            products,
            status,
            category,
            products_manuf,
            searchKeyword,
            currentPage,
            totalPages,
            changePage,
            searchProducts,
            confirmDeleteProducts,
        };
    },
});
</script>
