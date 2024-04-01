<template>
    <li class="flex items-center pl-3 py-2 border-y w-full">
        <h1 class="text-xl font-medium flex-1">{{text}}</h1>
        <button class="border p-2">編集</button>
    </li>
</template>

<script>
    module.exports = {
        props: ["text", "id"]
    }
</script>