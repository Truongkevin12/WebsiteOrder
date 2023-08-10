<template>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo"> </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-item">
            <a href="" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        <li class="menu-item">
            <router-link :to="{ name: 'admin-order' }" class="menu-link">
                <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                <div data-i18n="Authentications">Đặt hàng</div>
            </router-link>
        </li>
        <li class="menu-item">
            <router-link :to="{ name: 'admin-stores' }" class="menu-link">
                <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                <div data-i18n="Authentications">Danh sách kho</div>
            </router-link>
        </li>
        <li class="menu-item">
            <a href="" class="menu-link menu-toggle">
                <i class="menu-icon bx bx-category"></i>
                <div data-i18n="Authentications">Nhà sản xuất</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item active">
                    <a href="form-layouts-vertical.html" class="menu-link">
                        <div data-i18n="Vertical Form">Vertical Form</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="form-layouts-horizontal.html" class="menu-link">
                        <div data-i18n="Horizontal Form">
                            Horizontal Form
                        </div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <router-link :to="{ name: 'admin-customer' }" class="menu-link">
                <i class="menu-icon bx bx-group"></i>
                <div data-i18n="Authentications">Khách hàng</div>
            </router-link>
        </li>
        <li class="menu-item">
            <router-link :to="{ name: 'admin-users-customer' }" class="menu-link">
                <i class="menu-icon bx bx-group"></i>
                <div data-i18n="Authentications">Khách hàng-user</div>
            </router-link>
        </li>
        <li class="menu-item">
            <router-link :to="{ name: 'admin-users-admin' }" class="menu-link">
                <i class="menu-icon bx bx-user bx bx-lock-open-alt"></i>
                <div data-i18n="Authentications">Nhân viên kinh doanh</div>
            </router-link>
        </li>
        <li class="menu-item">
            <router-link :to="{ name: 'admin-users-other' }" class="menu-link">
                <i class="menu-icon bx bx-user bx bx-lock-open-alt"></i>
                <div data-i18n="Authentications">Nhân viên khác</div>
            </router-link>
        </li>
        <li class="menu-item">
            <router-link :to="{ name: 'admin-users' }" class="menu-link">
                <i class="menu-icon bx bx-user bx bx-lock-open-alt"></i>
                <div data-i18n="Authentications">Người dùng</div>
            </router-link>
        </li>
        <li class="menu-item">
            <router-link :to="{ name: 'admin-debts' }" class="menu-link">
                <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                <div data-i18n="Authentications">Công nợ</div>
            </router-link>
        </li>
        <li class="menu-item">
            <router-link :to="{ name: 'admin-category' }" class="menu-link">
                <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                <div data-i18n="Authentications">Danh mục</div>
            </router-link>
        </li>
        <li class="menu-item">
            <router-link :to="{ name: 'admin-products' }" class="menu-link">
                <i class="menu-icon tf-icons bx bxl-product-hunt"></i>
                <div data-i18n="Authentications">Sản phẩm</div>
            </router-link>
        </li>
        <li class="menu-item">
            <router-link :to="{ name: 'admin-groupusers' }" class="menu-link">
                <i class="menu-icon tf-icons bx bxl-product-hunt"></i>
                <div data-i18n="Authentications">Nhóm người dùng</div>
            </router-link>
        </li>

        <li class="menu-item">
            <router-link :to="{ name: 'admin-setting' }" class="menu-link">
                <i class="menu-icon bx bx-cog"></i>
                <div data-i18n="Authentications">Thiết lập</div>
            </router-link>
        </li>
        <li class="menu-item">
            <router-link :to="{ name: 'admin-status' }" class="menu-link">
                <i class="menu-icon bx bx-cog"></i>
                <div data-i18n="Authentications">Trạng thái</div>
            </router-link>
        </li>
        <li class="menu-item">
            <router-link :to="{ name: 'admin-contact' }" class="menu-link">
                <i class="bx bxs-contact menu-icon"></i>
                <div data-i18n="Authentications">Liên hệ</div>
            </router-link>
        </li>
        <li class="menu-item">
            <router-link :to="{ name: 'admin-summary' }" class="menu-link">
                <i class="menu-icon bx bx-news"></i>
                <div data-i18n="Authentications">Tổng hợp</div>
            </router-link>
        </li>
        <li class="menu-item">
            <router-link :to="{ name: 'admin-analytic' }" class="menu-link">
                <i class="menu-icon bx bx-bar-chart-alt"></i>
                <div data-i18n="Authentications">Thống kê</div>
            </router-link>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon bx bx-import"></i>
                <div data-i18n="Authentications">Import dữ liệu</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon bx bx-cloud-upload"></i>
                <div data-i18n="Authentications">Import dữ liệu</div>
            </a>
        </li>
        <li class="menu-item">
            <router-link :to="{ name: 'admin-account' }" class="menu-link">
                <i class="menu-icon bx bxs-user-account"></i>
                <div data-i18n="Authentications">Tài khoản của tôi</div>
            </router-link>
        </li>
    </ul>
</aside>
</template>

<script>
import {
    fromJSON
} from "postcss";
import {
    defineComponent,
    reactive,
    toRefs
} from "vue";
export default defineComponent({
    setup() {
        const state = reactive({
            selectedKeys: ["admin-roles"],
            openKeys: [],
        });
        return {
            ...toRefs(state),
        };
    },
});
</script>
