<template>
    <li class="flex items-center pl-3 py-2 border-y w-full cursor-pointer hover:bg-gray-200" @click="router.push(url)">
        <h1 class="text-xl font-semibold flex-1">{{text}}</h1>
        <img src="https://ss1.xrea.com/isym.s223.xrea.com/img/svg/arrow-go.svg" class="w-6 h-6 mr-3" alt="">
    </li>
</template>

<script>
    module.exports = {
        props: ["text", "url"]
    }
</script>