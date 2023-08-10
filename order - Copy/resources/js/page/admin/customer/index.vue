<template>
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Khách hàng /</span> Danh sách</h4>
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between mb-4">
        <div class="card-flex align-items-center justify-content-between col-3">
            <input class="form-control" id="html5-search-input" v-model="searchKeyword" @input="searchProducts" type="text" placeholder="Nhập mã sản phẩm hoặc tên sản phẩm,hoạt chất ...">
        </div>
        <router-link :to="{ name: 'admin-customer-create' }">
            <button type="button" class="btn btn-primary float-end"> <i class='bx bx-plus'></i>Thêm khách hàng</button>
        </router-link>
    </div>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mã KH</th>
                        <th>Tên KH</th>
                        <th>Điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Chưa thanh toán</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(customer, index) in customers" :key="customer.ID">
                        <td>{{ index + 1 }}</td>
                        <td><i class="fab fa-react fa-lg text-info me-3"></i>{{ customer.customer_code }}</td>
                        <td>{{ customer.customer_name }}</td>
                        <td>{{ customer.customer_phone }}</td>
                        <td>{{ customer.customer_addr }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <router-link :to="{ name: 'admin-customer-update', params: { id: customer.ID } }">
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i>Edit</a>
                                    </router-link>
                                    <router-link :to="{ name: 'admin-customer-detail', params: { customer: customer.ID } }">
                                        <a class="dropdown-item" href="javascript:void(0);"><i class='bx bx-detail me-1'></i>Chi tiết</a>
                                    </router-link>
                                    <a @click="deleteCustomer(customer.ID)" class="dropdown-item" href="javascript:void(0);">
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
</template>

<script>
import axios from 'axios';
import { defineComponent, ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toast-notification';
import { inject } from 'vue';

export default defineComponent({
  setup() {
    const globalState = inject('globalState');
    const baseUrl = globalState.baseUrl;
    const customers = ref([]);
    const router = useRouter();
    const toast = useToast();
    const currentPage = ref(1);
    const itemsPerPage = 10;
    const totalPages = ref(0); // No need to watch totalPages

    const searchKeyword = ref('');
    const searchTimer = ref(null);

    const getCustomers = () => {
      axios
        .get(`${baseUrl}/api/customers`, {
          params: {
            page: currentPage.value,
            per_page: itemsPerPage,
            keyword: searchKeyword.value,
          },
        })
        .then((response) => {
          customers.value = response.data.customers.data;
          totalPages.value = response.data.customers.last_page;
        })
        .catch((error) => {
          console.log(error);
        });
    };

    // Use a debounced search function to avoid making too many API requests
    const performSearch = () => {
      clearTimeout(searchTimer.value);
      searchTimer.value = setTimeout(() => {
        currentPage.value = 1; // Reset page when performing a new search
        getCustomers();
      }, 300); // Adjust the debounce delay as needed
    };

    const changePage = (page) => {
      currentPage.value = page;
      getCustomers();
    };

    const deleteCustomer = (customerId) => {
      axios
        .delete(`${baseUrl}/api/customers/${customerId}`)
        .then(() => {
          toast.success('Xoá khách hàng thành công');
          customers.value = customers.value.filter(
            (customer) => customer.ID !== customerId
          );
        })
        .catch((error) => {
          console.log(error);
          toast.error('Failed to delete user');
        });
    };

    // Watch for changes in searchKeyword and trigger search after a delay
    watch(searchKeyword, performSearch);

    // Initial fetch of customers
    getCustomers();

    return {
      customers,
      deleteCustomer,
      searchKeyword,
      currentPage,
      totalPages,
      changePage,
    };
  },
});
</script>
