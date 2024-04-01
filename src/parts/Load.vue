<template>
    <div class="flex justify-center" :class="{'hidden': !show}">
        <div class="animate-ping h-4 w-4 bg-blue-600 rounded-full"></div>
    </div>
</template>

<script>
    module.exports = {
        props: ["show"]
    };
</script>