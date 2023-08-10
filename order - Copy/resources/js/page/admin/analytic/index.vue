<template>
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Thống kê người quản lý /</span> Danh sách</h4>
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="col-md-5">
            <label for="html5-date-input" class="col-md-6">Thời gian từ</label>
            <input v-model="selectedCreated" @change="filterByCustomer" class="form-control" type="date" id="html5-date-input">
        </div>
        <div class="col-md-5">
            <label for="html5-date-input2" class="col-md-6">Đến</label>
            <input v-model="selectedUpdated" @change="filterByCustomer" class="form-control col-md-6" type="date" id="html5-date-input2">
        </div>
    </div>
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="mb-3 me-sm-2">
            <label for="exampleFormControlSelect1" class="form-label">Quản lý</label>
            <select v-model="selectedUser" @change="filterByCustomer" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                <option value="">Chọn người quản lý</option>
                <option v-for="user in users" :value="user.id" :key="user.id">{{ user.display_name }}</option>

            </select>
        </div>
        <div class="mb-3 me-sm-2">
            <label for="exampleFormControlSelect1" class="form-label">Khách hàng</label>
            <select v-model="selectedCustomer" @change="filterByCustomer" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                <option value="">Khách hàng</option>
                <option v-for="customerItem in customer" :value="customerItem.ID" :key="customerItem.ID">{{ customerItem.customer_name }}</option>
            </select>
        </div>
        <div class="mb-3 me-sm-2">
            <label for="exampleFormControlSelect1" class="form-label">Trạng thái</label>
            <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                <option selected>Trạng thái</option>
                <option v-for="status in status" :value="status.id">{{ status.name }}</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlSelect1" class="form-label">Chi nhánh</label>
            <select v-model="selectedStore" @change="filterByCustomer" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                <option value="">Chọn chi nhánh</option>
                <option v-for="store in stores" :value="store.ID">{{ store.store_name }}</option>
            </select>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mã đơn hàng</th>
                        <th>Người đặt</th>
                        <th>Mã khách hàng</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(orderPx, index) in orderPx" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ orderPx.output_code }}</td>
                        <td>{{ users.find(x=>x.id==orderPx.user_init)?.display_name }}</td>
                        <td>{{ customer.find(x=>x.ID==orderPx.customer_id)?.customer_code }}</td>
                        <td>{{ customer.find(x=>x.ID==orderPx.customer_id)?.customer_name }}</td>
                        <td v-if="orderPx.total_price">{{orderPx.total_price.toLocaleString()}}</td>
                        <td v-else>0</td>
                        <td>{{ orderPx.created }}</td>
                        <td>{{ orderPx.order_status }}</td>
                        <td>{{ users.find(x=>x.id==orderPx.user_init)?.ip_logged }}</td>
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
    watch,
    computed
} from 'vue';
import {
    useToast
} from 'vue-toast-notification';
import {
    inject
} from 'vue';

export default defineComponent({
    name: 'SalesSummary',
    setup() {
        const globalState = inject('globalState');
        const baseUrl = globalState.baseUrl;
        const users = ref([]);
        const orderPx = ref([]);
        const stores = ref([]);
        const status = ref([]);
        const customer = ref([]);
        const users_group = ref([]);
        const selectedStore = ref('');
        const currentPage = ref(1);
        const itemsPerPage = 50;
        const totalPages = ref(0);
        const selectedCustomer = ref('');
        const searchKeyword = ref('');
        const toast = useToast();
        const selectedUser = ref('');
        const filterByCustomer = () => {
            currentPage.value = 1;
            getSummary();
        };
        watch([currentPage, selectedCustomer, selectedStore, selectedUser], () => {
            getSummary();
        });

        const getSummary = () => {
            axios
                .get(`${baseUrl}/api/summary`, {
                    params: {
                        page: currentPage.value,
                        per_page: itemsPerPage,
                        keyword: searchKeyword.value,
                        customer_id: selectedCustomer.value,
                        store_id: selectedStore.value,
                        user_init: selectedUser.value,
                    },
                })
                .then((response) => {
                    orderPx.value = response.data.orderPx.data;
                    status.value = response.data.status;
                    stores.value = response.data.stores;
                    customer.value = response.data.customer;
                    users.value = response.data.users;
                    users_group.value = response.data.users_group;
                    totalPages.value = response.data.orderPx.last_page;
                })
                .catch((error) => {
                    console.log(error);
                });
        };
        const visiblePages = computed(() => {
            const totalVisiblePages = 10;
            const halfVisiblePages = Math.floor(totalVisiblePages / 2);
            const startPage = Math.max(currentPage.value - halfVisiblePages, 1);
            const endPage = Math.min(startPage + totalVisiblePages - 1, totalPages.value);
            return Array.from({
                length: endPage - startPage + 1
            }, (_, i) => startPage + i);
        });
        const showEllipsisBefore = computed(() => {
            return visiblePages.value[0] > 1;
        });

        const changePage = (page) => {
            if (page < 1 || page > totalPages.value) return;
            currentPage.value = page;
        };
        getSummary();
        return {
            orderPx,
            users,
            stores,
            status,
            customer,
            users_group,
            selectedCustomer,
            filterByCustomer,
            changePage,
            showEllipsisBefore,
            selectedStore,
            selectedUser,
        };
    },
});
</script>
