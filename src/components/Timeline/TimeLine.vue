<template>
    <div>
        <div v-for="(i) in [...Array(10)].map((_, i) => i)" :key="i" class="shadow-lg rounded md:p-8 p-3 p-2 mt-5 m-2" :class="{'hidden': !loading}">
            <div class="w-24 p-2 h-8 m-2 animate-pulse bg-slate-200"></div>
            <div class="w-3/4 m-2 rounded mb-2 h-6 animate-pulse bg-slate-200"></div>
            <div class="w-3/4 m-2 rounded mb-2 h-6 animate-pulse bg-slate-200"></div>
            <div class="w-10 m-2 rounded mb-2 h-6 animate-pulse bg-slate-200"></div>
        </div>
        <div v-for="(post, index) in timeline" :key="index" class="rounded shadow-lg p-8 pb-4">
            <router-link class="text-2xl font-bold" :to="`timeline/info/${post.id}`">{{post.title}}</router-link>
            <p class="text-sm text-gray-400 text-right">{{post.update_at}}</p>
            <div class="mt-5">
                <p v-for="(row, index) in (post.documents).split('\n').slice(0,3)" :key="index" class="text-basic">{{row}}</p>
                <p>...</p>
            </div>
            <div class="flex mt-5">
                <div class="flex p-2 hover:bg-gray-200 rounded-full h-9 cursor-pointer mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16"  @click="goodBtn($event, post.id)">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                    </svg>
                    <h2 class="w-9 font-basic flex justify-center items-center">{{post.good}}</h2>
                </div>
            </div>
        </div>

        <AddBtn url="/timeline/add"></AddBtn>
    </div>
</template>

<script>
    module.exports = {
        data: function(){
            return{
                timeline: [],
                chatBox: false,
                loading: true,
            }
        },

        components:{
            "addbtn": httpVueLoader('../../parts/Button/AddBtn.vue'),
        },

        mounted:function(){
            this.find();
        },

        methods:{
            goodBtn: async function(e,id){
                var result = await axiosLib("api/timeline/good", {"id": id});

                if(result.type = "success"){
                    e.target.classList.remove("hover:bg-gray-200");
                    e.target.classList.add("text-red-500");
                }
            },

            find: async function(){
                this.loading = true;
                var result = await axiosLib("api/timeline/get");

                if(result.type == "success"){
                    this.timeline = result.data;
                }

                this.loading = false;
            }
        },
    }
</script>