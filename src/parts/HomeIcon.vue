<template>
    <li @click="$emit('onclick')" class="flex-1">
        <router-link class="mx-auto w-14 h-14 block p-1  mb-0 md:bg-transparent md:p-0 text-center" :class="{'bg-blue-500': focus == url}" :to=url>
            <img class="w-full p-3 py-0 rounded-full" :src="`https://ss1.xrea.com/isym.s223.xrea.com/img/${img}`" alt="" />
            <p class="text-gray-300 text-sm">{{title}}</p>
        </router-link>
    </li>
</template>

<script>
    module.exports = {
        props:["url", "img", "title", "focus"]
    }
</script>