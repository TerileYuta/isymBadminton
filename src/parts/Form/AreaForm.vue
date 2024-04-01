<template>
    <div>
        <label  class="block m-2 text-sm font-medium text-gray-900">{{title}}</label>
        <textarea v-model="text" @change="$emit('update:text', text)" rows="8" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"></textarea>
    </div>
</template>

<script>
    module.exports = {
        props:["title", "value"],

        data:function(){
            return{
                text: "",
            }
        },

        watch: {
            value:function(){
                this.text = this.value;
            }
        }
    }
</script>