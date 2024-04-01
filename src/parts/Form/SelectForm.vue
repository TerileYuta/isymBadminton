<template>
    <select @input="$emit('update:select', $event.target.value)" :value="value" :select="value" class="block py-2 px-0 w-full text-basic text-black bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer m-2 mt-0">
        <option v-for="(canadiate, index) in list" :key="index" :value="canadiate.name" :selected="{'true': value == canadiate.name}">{{canadiate.name}}</option>
    </select>
</template>

<script>
    module.exports = {
        props: ["list", "value"],

    }
</script>