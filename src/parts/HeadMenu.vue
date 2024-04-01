<template>
    <div class="flex py-1">
        <div class="flex items-center" @click="$router.go(-1)">
            <img src="https://ss1.xrea.com/isym.s223.xrea.com/img/svg/arrow-back.svg" class="h-6 w-6 rounded-full mr-2 cursor-pointer hover:bg-gray-200" alt="">
            <h2 class="text-xl font-bold">{{text}}</h2>
        </div>
        <slot></slot>
    </div>
</template>

<script>
    module.exports = {
        props: ["text"]
    }
</script>