<template>
    <div>
        <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 w-full">
            <ul class="flex flex-wrap -mb-px">
                <li v-for="(menu, index) in menulist" :key="index" class="flex-1" @click="activeTag = menu.value">
                    <p class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 cursor-pointer">{{menu}}</p>
                </li>
            </ul>
        </div>
        <slot>
            
        </slot>
    </div>
</template>

<script>
    module.exports = {
        props: ["menulist"],

        data: function(){
            return{
                activeTag: "comment",
            }
        },
    }
</script>