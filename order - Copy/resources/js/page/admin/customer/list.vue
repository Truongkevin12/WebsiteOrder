<template>
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card mb-4">
            <h5 class="card-header">Chi tiết khách hàng</h5>
            <div class="card-body">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="align-middle"><strong class="fw-semibold">Tên khách hàng</strong></td>
                            <td class="py-3">
                                <p class="mb-0">{{ customer.customer_name }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle"><strong class="fw-semibold">Mã khách hàng</strong></td>
                            <td class="py-3">
                                <p class="mb-0">{{ customer.customer_code }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle"><strong class="fw-semibold">Điện thoại</strong></td>
                            <td class="py-3">
                                <p class="mb-0">{{ customer.customer_phone }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle"><strong class="fw-semibold">Email</strong></td>
                            <td class="py-3">
                                <p class="mb-0">{{ customer.customer_email }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle"><strong class="fw-semibold">Địa chỉ</strong></td>
                            <td class="py-3">
                                <p class="mb-0">{{ customer.customer_addr }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle"><strong class="fw-semibold">Địa chỉ giao hàng</strong></td>
                            <td class="py-3">
                                <p class="mb-0">{{ customer.customer_ship_addr }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle"><strong class="fw-semibold">Danh mục</strong></td>
                            <td class="py-3">
                                <p class="mb-0">{{ stores.find(x=>x.ID==customer.store_id)?.store_name  }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle"><strong class="fw-semibold">Ghi chú</strong></td>
                            <td class="py-3">
                                <p class="mb-0">{{ stores.notes  }}</p>
                            </td>
                        </tr>
                        <div class="row">
                            <div class="col-sm-10">
                                <router-link :to="{ name: 'admin-products' }" class="btn btn-primary me-sm-2">Trở về</router-link>
                            </div>
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h6 class="card-title m-0">Người đặt hàng</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Họ và tên</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td>Albert Cook</td>
                                <td><span class="badge bg-label-primary me-1">Active</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h6 class="card-title m-0">Người phụ trách</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Họ và tên</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Angular Project</strong>
                                </td>
                                <td>Albert Cook</td>
                                <td><span class="badge bg-label-primary me-1">Active</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h6 class="card-title m-0">Đơn hàng</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Ngày đặt hàng</th>
                                <th>Trạng thái</th>
                                <th>Tổng tiền</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Angular Project</strong>
                                </td>
                                <td>Albert Cook</td>
                                <td><span class="badge bg-label-primary me-1">Active</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu" style="">
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h6 class="card-title m-0">Tình hình công nợ</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Hạn thanh toán</th>
                                <th>Trạng thái</th>
                                <th>Chưa thanh toán</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Angular Project</strong>
                                </td>
                                <td>Albert Cook</td>
                                <td><span class="badge bg-label-primary me-1">Active</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu" style="">
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h6 class="card-title m-0">Hợp đồng thầu</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã số thầu</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày hết hạn</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td>{{ customerBids.output_code }}</td>
                                <td><span class="badge bg-label-primary me-1">Active</span></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
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
        const customer = ref([]);
        const route = useRoute();
        const stores = ref([]);
        const customerBids = ref([]);
        const getCustomer = () => {
            axios
                .get(`${baseUrl}/api/customers/${route.params.customer}`)
                .then((response) => {
                    const data = response.data.customer;
                    customer.value = data;
                    stores.value = response.data.stores;
                    customerBids.value = response.data.customerBids;
                    console.log(customerBids.value);
                })
                .catch((error) => {
                    console.log(error);
                });
        };
        getCustomer();
        return {
            customer,
            stores,
            customerBids,
        };
    },
});
</script>
