<template>
    <div>
        <HeadMenu text="一覧へ戻る">
            <IconMenu class="ml-auto">
                <ul class="text-sm text-gray-700 w-full">
                    <li class="block py-2 text-center cursor-pointer hover:bg-gray-100" @click="router.push(`/menu/action?id=${menu.id}`)">
                        編集
                    </li>
                    <li class="block py-2 text-center text-red-600 cursor-pointer hover:bg-gray-100">
                        削除
                    </li>
                </ul>
            </IconMenu>
        </HeadMenu>
        <div class="mt-2">
            <h1 class="text-2xl font-bold">{{menu.title}}</h1>
            <TextGroup title="練習内容" :document="menu.documents"></TextGroup>
            <TextGroup title="ポイント" :document="menu.points"></TextGroup>
            <TextGroup title="練習目的" :document="menu.focus"></TextGroup>
            <TextGroup title="セット数" :document="menu.set_count"></TextGroup>
            <TextGroup title="目安時間" :document="menu.time"></TextGroup>
            <VideoGroup title="参考動画" :video="menu.video"></VideoGroup>
    
            <div v-if="menu.tag != ''" >
                <hr class="mt-5">
                <ul class="flex flex-wrap mt-5">
                    <li v-for="(tag, index) in (menu.tag).split('\n')" :key="index" class="text-basic px-2 bg-gray-100 rounded-full mx-1">{{tag}}</li>
                </ul>      
            </div>
        </div>
    </div>
</template>

<script>
    module.exports = {
        data: function(){
            return{
                menu: "",
            }
        },

        components:{
            "headmenu": httpVueLoader("../../parts/HeadMenu.vue"),
            "textgroup": httpVueLoader('../../parts/Text/TextGroup.vue'),
            "videogroup": httpVueLoader('../../parts/Text/VideoGroup.vue'),
            "iconmenu": httpVueLoader("../../parts/Button/IconMenuBtn.vue"),
        },

        mounted: async function(){
            var id = this.$route.params.id;
            var result = await axiosLib("api/menu/get", {"id": id});
            
            if(result.type == "success"){
                this.menu = result.data[0];
            }
        }
    }
</script>