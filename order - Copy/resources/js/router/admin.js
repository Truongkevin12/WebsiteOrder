const admin = [
    {
        path: "/admin",
        component: () =>import ("../layout/admin.vue"),
        children: [
            {
                path: "users",
                name: "admin-users",
                component: () =>import ("../page/admin/users/index.vue"),
            },
                {
                    path: "users/create",
                    name: "admin-users-create",
                    component: () =>import ("../page/admin/users/create.vue"),
                },
                {
                    path: "users/:id/update",
                    name: "admin-users-update",
                    component: () =>import ("../page/admin/users/edit.vue"),
                },
                {
                    path: "users/:user/roles",
                    name: "admin-users-roles",
                    component: () =>import ("../page/admin/users/roles.vue"),
                },
            {
                path: "user/customer",
                name: "admin-users-customer",
                component: () =>import ("../page/admin/usersCustomer/index.vue"),
            },
                {
                    path: "users/create",
                    name: "admin-users-create",
                    component: () =>import ("../page/admin/users/create.vue"),
                },
                {
                    path: "users/:id/update",
                    name: "admin-users-update",
                    component: () =>import ("../page/admin/users/edit.vue"),
                },
            {
                path: "user/user_admin",
                name: "admin-users-admin",
                component: () =>import ("../page/admin/usersAdmin/index.vue"),
            },
            {
                path: "user/user_other",
                name: "admin-users-other",
                component: () =>import ("../page/admin/usersOther/index.vue"),
            },

            {
                path: "customer",
                name: "admin-customer",
                component: () =>import ("../page/admin/customer/index.vue"),
            },
                {
                    path: "customer/create",
                    name: "admin-customer-create",
                    component: () =>import ("../page/admin/customer/create.vue"),
                },
                {
                    path: "customer/:id/update",
                    name: "admin-customer-update",
                    component: () =>import ("../page/admin/customer/edit.vue"),
                },
                {
                    path: "customer/:customer",
                    name: "admin-customer-detail",
                    component: () => import("../page/admin/customer/list.vue"),
                },
            {
                path: "products",
                name: "admin-products",
                component: () =>import ("../page/admin/products/index.vue"),
            },
                {
                    path: "products/create",
                    name: "admin-products-create",
                    component: () =>import ("../page/admin/products/create.vue"),
                },
                {
                    path: "products/:products",
                    name: "admin-products-detail",
                    component: () => import("../page/admin/products/list.vue"),
                },
                {
                    path: "products/:id/update",
                    name: "admin-products-update",
                    component: () =>import ("../page/admin/products/edit.vue"),
                },
            {
                path: "contact",
                name: "admin-contact",
                component: () =>import ("../page/admin/contact/index.vue"),
            },
            {
                path: "status",
                name: "admin-status",
                component: () =>import ("../page/admin/status/index.vue"),
            },
                {
                    path: "status/create",
                    name: "admin-status-create",
                    component: () =>import ("../page/admin/status/create.vue"),
                },
                {
                    path: "status/:id/update",
                    name: "admin-status-update",
                    component: () =>import ("../page/admin/status/edit.vue"),
                },
            {
                path: "setting",
                name: "admin-setting",
                component: () =>import ("../page/admin/setting/index.vue"),
            },
            {
                path: "stores",
                name: "admin-stores",
                component: () =>import ("../page/admin/stores/index.vue"),
            },
                {
                    path: "stores/create",
                    name: "admin-stores-create",
                    component: () =>import ("../page/admin/stores/create.vue"),
                },
                {
                    path: "stores/:id/update",
                    name: "admin-stores-update",
                    component: () =>import ("../page/admin/stores/edit.vue"),
                },
            {
                path: "groupusers",
                name: "admin-groupusers",
                component: () =>import ("../page/admin/users_group/index.vue")
            },
                {
                    path: "groupusers/create",
                    name: "admin-groupusers-create",
                    component: () =>import ("../page/admin/users_group/create.vue")
                },
                {
                    path: "groupusers/:id/update",
                    name: "admin-groupusers-update",
                    component: () =>import ("../page/admin/users_group/edit.vue"),
                },
            {
                path: "order",
                name: "admin-order",
                component: () =>import ("../page/admin/order/index.vue")
            },
                {
                    path: "order/:id/update",
                    name: "admin-order-update",
                    component: () =>import ("../page/admin/order/edit.vue"),
                },
                {
                    path: "order/:order",
                    name: "admin-order-detail",
                    component: () => import("../page/admin/order/roles.vue"),
                },
            {
                path: "account",
                name: "admin-account",
                component: () =>import ("../page/admin/account/index.vue")
            },
            {
                path: "debts",
                name: "admin-debts",
                component: () =>import ("../page/admin/debts/index.vue")
            },
            {
                path: "category",
                name: "admin-category",
                component: () =>import ("../page/admin/category/index.vue")
            },
                {
                    path: "category/create",
                    name: "admin-category-create",
                    component: () =>import ("../page/admin/category/create.vue")
                },
                {
                    path: "category/:id/update",
                    name: "admin-category-update",
                    component: () =>import ("../page/admin/category/edit.vue"),
                },
            {
                path: "analytic",
                name: "admin-analytic",
                component: () =>import ("../page/admin/analytic/index.vue")
            },
            {
                path: "summary",
                name: "admin-summary",
                component: () =>import ("../page/admin/summary/index.vue")
            },
        ]
    }
]
export default admin;
