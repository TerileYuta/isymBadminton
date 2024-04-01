<template>
    <router-link :to="url" class="fixed bottom-16 right-0 h-16 w-16 bg-blue-700 rounded-full m-5">
        <img class="w-full h-full" src="https://ss1.xrea.com/isym.s223.xrea.com/img/svg/add-circle.svg" alt="">
    </router-link>
</template>

<script>
    module.exports = {
        props:["url"]
    }
</script>