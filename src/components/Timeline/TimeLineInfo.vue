<template>
    <div class="mx-auto md:w-1/2 m-1">
        <HeadMenu text="一覧へ戻る"></HeadMenu>
        <div class="rounded shadow-lg p-8 pb-4">
            <h1 class="text-2xl font-bold">{{post.title}}</h1>
            <p class="text-sm text-gray-400 text-right">{{post.update_at}}</p>
            <div class="mt-5">
                <p v-for="(row, index) in (post.documents).split('\n')" :key="index" class="text-basic">{{row}}</p>
            </div>
            <div class="flex mt-5">
                <div class="flex p-2 hover:bg-gray-200 rounded-full h-9 cursor-pointer mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16"  @click="goodBtn($event, post.id)">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                    </svg>
                    <h2 class="w-9 font-basic flex justify-center items-center">{{post.good}}</h2>
                </div>
            </div>
            <hr class="mb-5">
            <Comment type="t" :id="id"></Comment>
        </div>
    </div>
</template>

<script>
    module.exports = {
        data(){
            return{
                post: [],
                commentList: [],
                id:null,
                newComment: "",
            }
        },

        components:{
            "headmenu": httpVueLoader("../../parts/HeadMenu.vue"),
            "comment": httpVueLoader('../../parts/Comment.vue'),
        },

        mounted: function(){
            this.id = this.$route.params.id;

            this.find();
        },

        methods:{
            find: async function(){
                var result = await axiosLib("api/timeline/get", {"id": this.id});

                if(result.type == "success"){
                    this.post = result.data[0];    
                }

                var commentResult = await axiosLib("api/comment/get", {"post_id": `t${this.id}`});
                if(commentResult.type == "success"){
                    this.commentList = commentResult.data;
                }
            },

            goodBtn: async function(e,id){
                var result = await axiosLib("api/timeline/good", {"id": id});

                if(result.type == "success"){
                    e.target.classList.remove("hover:bg-gray-200");
                    e.target.classList.add("text-red-500");
                    
                    this.find();
                }
            },
        }
    }
</script>