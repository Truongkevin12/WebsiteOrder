<template>
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Thống kê đơn hàng /</span> Danh sách</h4>
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Danh sách đơn hàng</h5>
    </div>
    <div class="card-header d-flex align-items-center justify-content-between">
        <input class="form-control" id="html5-search-input" v-model="searchKeyword" @input="searchOrder" type="text" placeholder="Hãy nhập mã đơn hàng...">
    </div>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead >
                    <tr>
                        <th>#</th>
                        <th>Mã đơn hàng</th>
                        <th>Người đặt</th>
                        <th>Khách hàng</th>
                        <th>Khu vực</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt hàng</th>
                        <th>Tổng tiền</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(order, index) in order" :class="{'status-1':order.order_status === 1 ,'status-2': order.order_status === 2 , 'status-5': order.order_status === 5 , }">
                        <td>{{ index + 1 }}</td>
                        <td><router-link :to="{ name: 'admin-order-detail', params: { order: order.ID } }">{{ order.output_code }}</router-link></td>
                        <td>{{ customer.find(x=>x.ID==order.customer_id)?.customer_name }}</td>
                        <td>{{ users.find(x=>x.id==order.user_init)?.display_name }}</td>
                        <td>{{ stores.find(x=>x.ID==order.store_id)?.store_name }}</td>
                        <td>{{ status.find(x=>x.id==order.order_status)?.name}}</td>
                        <td>{{ order.created }}</td>
                        <td>{{ order.total_money.toLocaleString() }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <router-link :to="{ name: 'admin-order-update', params: { id: order.ID } }">
                                        <a class="dropdown-item" href="javascript:void(0);">
                                            <i class="bx bx-edit-alt me-1"></i>Edit
                                        </a>
                                    </router-link>
                                    <!-- <a @click="confirmDeleteStore(store)" class="dropdown-item" href="javascript:void(0);">
                                        <i class="bx bx-trash me-1"></i> Delete
                                    </a> -->
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-body">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <li class="page-item prev">
                        <a class="page-link" href="javascript:void(0);" @click="changePage(currentPage - 1)">
                            <i class="tf-icon bx bx-chevrons-left"></i>
                        </a>
                    </li>
                    <li v-for="page in totalPages" :key="page" class="page-item" :class="{ active: page === currentPage }">
                        <a class="page-link" href="javascript:void(0);" @click="changePage(page)">{{ page }}</a>
                    </li>
                    <li class="page-item next">
                        <a class="page-link" href="javascript:void(0);" @click="changePage(currentPage + 1)">
                            <i class="tf-icon bx bx-chevrons-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
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
        const searchKeyword = ref('');
        const currentPage = ref(1);
        const customer = ref([]);
        const itemsPerPage = 10;
        const users = ref([]);
        let totalPages = ref(0);
        const stores = ref([]);
        const order = ref([]);
        const status = ref([]);
        const getOrder = () => {
            axios
                .get(`${baseUrl}/api/order`, {
                    params: {
                        page: currentPage.value,
                        per_page: itemsPerPage,
                        keyword: searchKeyword.value,
                    },
                })
                .then((response) => {
                    order.value = response.data.order.data;
                    customer.value = response.data.customer;
                    console.log(customer.value);
                    totalPages.value = response.data.order.last_page;
                    stores.value = response.data.stores;
                    users.value = response.data.users;
                    status.value = response.data.status
                })
                .catch((error) => {
                    console.log(error);
                });
        };
        const changePage = (page) => {
            currentPage.value = page;
        };
        const searchOrder = () => {
            currentPage.value = 1;
            getOrder();
        };
        getOrder();
        return {
            order,
            searchKeyword,
            currentPage,
            totalPages,
            changePage,
            searchOrder,
            customer,
            stores,
            users,
            status,
        };
    },
});
</script>
