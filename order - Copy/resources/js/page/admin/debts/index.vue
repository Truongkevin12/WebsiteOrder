<template>
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Công nợ /</span> Danh sách</h4>
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="col-md-3 product_status">
            <input class="form-control" id="html5-search-input" v-model="searchKeyword" @input="searchProducts" type="text" placeholder="Nhập mã đơn hàng ...">
        </div>
        <div class="col-md-4 product_status">
            <select class="form-select" v-model="selectedCustomer" @change="filterByCustomer">
                <option value="">Tất cả khách hàng</option>
                <option v-for="customerItem in customer" :value="customerItem.ID" :key="customerItem.ID">{{ customerItem.customer_name }}</option>
            </select>
        </div>
        <div class="col-md-4 product_stock">
            <select id="ProductStock" class="form-select text-capitalize">
                <option value="0">Chưa thanh toán</option>
                <option value="1">Đã thanh toán</option>
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
                        <th>Tên khách hàng</th>
                        <th>Hạn thanh toán</th>
                        <th>Chưa thanh toán</th>
                        <th>Đã thanh toán</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(debt, index) in debts" :key="index">
                        <td class="text-danger">{{ index + 1 }}</td>
                        <td class="text-danger">{{ debt.output_code }}</td>
                        <td class="text-danger">{{ customer.find(cust => cust.ID === debt.customer_id)?.customer_name }}</td>
                        <td class="text-danger">{{ debt.expdate }}</td>
                        <td class="text-danger"> Quá hạn {{ calculateRemainingDays(debt.expdate) }} ngày</td>
                        <td class="text-danger">{{ debt.paid.toLocaleString() }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end">
            <li class="page-item prev">
                <a class="page-link" href="javascript:void(0);" @click="changePage(currentPage - 1)">
                    <i class="tf-icon bx bx-chevrons-left"></i>
                </a>
            </li>
            <li v-for="page in visiblePages" :key="page" class="page-item" :class="{ active: page === currentPage }">
                <a class="page-link" href="javascript:void(0);" @click="changePage(page)">{{ page }}</a>
            </li>
            <li v-if="showEllipsisBefore" class="page-item">
                <a class="page-link" href="javascript:void(0);">...</a>
            </li>
            <li class="page-item next">
                <a class="page-link" href="javascript:void(0);" @click="changePage(currentPage + 1)">
                    <i class="tf-icon bx bx-chevrons-right"></i>
                </a>
            </li>
        </ul>
    </nav>
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
    setup() {
        const toast = useToast();
        const globalState = inject('globalState');
        const baseUrl = globalState.baseUrl;
        const customer = ref([]);
        const debts = ref([]);
        const searchKeyword = ref('');
        const currentPage = ref(1);
        const itemsPerPage = 50;
        const totalPages = ref(0);
        const selectedCustomer = ref(''); // Initialize with an empty string
        const filteredDebts = computed(() => {
            if (!selectedCustomer.value) {
                return debts.value; // No customer selected, return all debts
            } else {
                return debts.value.filter(debt => debt.customer_id === selectedCustomer.value);
            }
        });

        const filterByCustomer = () => {
            currentPage.value = 1; // Reset pagination when changing filters
            getDebts();
        };
        watch([currentPage, selectedCustomer], () => {
            getDebts();
        });
        const getDebts = () => {
            axios
                .get(`${baseUrl}/api/debts`, {
                    params: {
                        page: currentPage.value,
                        per_page: itemsPerPage,
                        keyword: searchKeyword.value,
                        customer_id: selectedCustomer.value, // Pass selected customer_id as a parameter
                    },
                })
                .then((response) => {
                    debts.value = response.data.debts.data;
                    customer.value = response.data.customer;
                    totalPages.value = response.data.debts.last_page;
                })
                .catch((error) => {
                    console.log(error);
                });
        };
        const calculateRemainingDays = (expdate) => {
            const currentDate = new Date();
            const debtExpirationDate = new Date(expdate);
            const timeDifference = debtExpirationDate.getTime() - currentDate.getTime();
            const remainingDays = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));
            return Math.abs(remainingDays); // Lấy giá trị tuyệt đối của remainingDays
        };

        const visiblePages = computed(() => {
            const totalVisiblePages = 10; // Number of visible page links
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

        watch(currentPage, () => {
            getDebts();
        });
        const changePage = (page) => {
            currentPage.value = page;
        };
        const searchProducts = () => {
            currentPage.value = 1;
            getDebts();
        };
        getDebts();
        return {
            customer,
            debts,
            searchKeyword,
            currentPage,
            totalPages,
            changePage,
            searchProducts,
            calculateRemainingDays,
            visiblePages,
            showEllipsisBefore,
            selectedCustomer,
            filteredDebts,
            filterByCustomer
        };
    },
});
</script>
