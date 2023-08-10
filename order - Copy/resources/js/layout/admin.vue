<template>
    <AdminHeader/>
    <router-view></router-view>
</template>
<script>
import AdminHeader from "../components/AdminHeader.vue";
export default {
    components:{
        AdminHeader,
    }
}
</script>
