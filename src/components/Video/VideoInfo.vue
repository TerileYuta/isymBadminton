<template>
    <div class="mx-auto md:w-1/2 m-1">
        <HeadMenu :text="video.title"></HeadMenu>
        <iframe class="mt-3" width="100%" style="aspect-ratio: 16 / 9;" :src="`https://www.youtube.com/embed/${video.youtube_id}`" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

        <Tab :menulist="['概要', 'コメント', 'タグ']">           
            <div>
                <Comment type="v" :id="id"></Comment>
            </div>
        </Tab>
    </div>
</template>

<script>
    module.exports = {
        data(){
            return{
                video: null,
                id:null,
                commentList: [],
                newComment: "",
            }
        },

        mounted: function(){
            this.id = this.$route.params.id;

            this.find();
        },

        components:{
            "gamescore": httpVueLoader('../../parts/Card/GameScore.vue'),
            "headmenu": httpVueLoader("../../parts/HeadMenu.vue"),
            "textgroup": httpVueLoader('../../parts/Text/TextGroup.vue'),
            "tab": httpVueLoader('../../parts/Tab.vue'),
            "comment": httpVueLoader('../../parts/Comment.vue'),
        },

        methods:{
            find: async function(){
                this.loading = true;
                var result = await axiosLib("api/video/get", {"id": this.id});
                if(result.type){
                    this.video = result.data[0];
                }

                this.loading = false;
            },
        }
    }
</script>