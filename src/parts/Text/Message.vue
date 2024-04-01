<template>
    <p class="text-basic font-bold text-center my-1" :class="{'text-green-600': message.type == 'success', 'text-red-600': message.type == 'error'}">{{message.text}}</p>
</template>

<script>
    module.exports = {
        props:["message"],

        data(){
            return {
                "message": {"type": "", "text": ""}
            }
        }
    }
</script>