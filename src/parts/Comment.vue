<template>
    <div>
        <div class="flex mt-3 ml-2">
            <div class="relative z-0 mb-3 w-full mx-auto group">
                <input type="text" v-model="newComment" class="block py-2 px-0 w-full text-basic text-black bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">コメントを入力</label>
            </div>
            <h2 class="text-basic w-16 text-center mt-4 text-blue-400 cursor-pointer" @click="commentBtn()">投稿</h2>
        </div>
        <div v-for="(comment, index) in commentList" :key="index" class="ml-2 mt-1">
            <p class="text-basic">
                <span class="font-bold text-sm">{{comment.name}}</span>：{{comment.comment}}
            </p>
        </div>
    </div>
</template>

<script>
     module.exports = {
        props: ["type", "id"],

        data(){
            return{
                commentList: [],
                newComment: "",
            }
        },

        mounted: function(){
            this.find();
        },


        methods:{
            find: async function(){
                var commentResult = await axiosLib("api/comment/get", {"post_id": this.type + this.id});

                if(commentResult.type == "success"){
                    this.commentList = commentResult.data;
                }
            },

            commentBtn: async function(){
                var result = await axiosLib("api/comment/add", {"id": this.type + this.id, "name": store.state.userId, "comment": this.newComment});
                
                if(result.type == "success"){
                    this.newComment = "";
                    this.find();
                }

            },
        }
    }
</script>