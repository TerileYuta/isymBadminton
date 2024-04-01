<template>
    <div class="flex my-5">
        <button @click="load = true" class="text-white flex justify-center w-48 mx-auto bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mb-2">
            <svg :class="{'animate-spin': load, 'hidden': !load}" class="border-2 border-white border-t-transparent rounded-full h-5 w-5 mr-3" viewBox="0 0 24 24"></svg>
            <span>{{title}}</span>
        </button>
    </div>
</template>

<script>
    module.exports = {
        props: ["title"],

        data:function(){
            return{
                load: false,
            }
        },

        methods:{
            reset: function(){
                this.load = false;
            }
        } 
    }
</script>