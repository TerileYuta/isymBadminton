<template>
    <div :class="{'animate-pulse bg-slate-200 rounded': loading}">
        <span :class="{'hidden': loading}">
            <slot></slot>
        </span>
    </div>
</template>

<script>
    module.exports = {
        props:["loading"]
    }
</script>