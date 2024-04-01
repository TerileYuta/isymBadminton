<template>
    <div class="mx-auto md:w-1/2 m-1">
        <HeadMenu text="試合結果"></HeadMenu>
        <GameScore :game="game"></GameScore>

        <Tab :menulist="['メモ', '動画', 'コメント']">           
            <div>
                <Comment type="s" :id="id"></Comment>
            </div>
        </Tab>
    </div>
</template>

<script>
    module.exports = {
        data(){
            return{
                game: null,
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
                var result = await axiosLib("api/score/get", {"id": this.id});
                
                if(result.type == "success"){
                    this.game = result.data[0];    
                }

            },
        }
    }
</script>