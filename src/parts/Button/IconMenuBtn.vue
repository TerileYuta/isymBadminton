<template>
    <div>
        <div class="w-20 flex justify-end">
            <img @click="activeChange()" src="https://ss1.xrea.com/isym.s223.xrea.com/img/svg/more.svg" class="w-6 h-6 rounded-full cursor-pointer hover:bg-gray-200" alt="">
        </div>
            
        <div class="z-50 w-16 mt-1 border rounded absolute" :class="{'hidden': !active}">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    module.exports = {
        data: function(){
            return{
                active: false,
            }
        },

        methods: {
            activeChange: function(){
                this.active =! this.active;
            }
        }
    }
</script>