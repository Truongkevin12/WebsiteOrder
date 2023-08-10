<template>
    <router-view></router-view>
</template>
<script setup>
    import { onMounted } from 'vue'

    onMounted(() => {
        var jsElement = document.createElement('script');
        jsElement.setAttribute('src','assets/js/main.js');
        // document.head.appendChild(jsElement);

        var jsElementMenu = document.createElement('script');
        jsElementMenu.setAttribute('src','assets/js/menu.js');
        document.head.appendChild(jsElementMenu);

        // document.head.appendChild(jsElement);

        console.log(jsElement);
        console.log('Attach script is ok!');
    })
</script>
