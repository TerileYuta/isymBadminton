<template>
    <div>
        <div class="flex mx-1 md:w-3/4 md:mx-auto mt-2 mb-8">
            <SearchForm :value="$route.query.word" placeholder="動画を検索" :text.sync="word"></SearchForm>
        </div>

        <div class="mb-20">
            <div v-for="(i) in [...Array(10)].map((_, i) => i)" :key="i" class="shadow-lg rounded md:p-8 p-3 p-2 mt-5 m-2" :class="{'hidden': !loading}">
                <div class="w-full h-64 p-2 m-2 animate-pulse bg-slate-200"></div>
                <div class="w-3/4 m-2 rounded mb-2 h-6 animate-pulse bg-slate-200"></div>
                <div class="w-3/4 m-2 rounded mb-2 h-6 animate-pulse bg-slate-200"></div>
                <ul class="flex">
                    <div class="w-10 m-2 rounded mb-2 h-6 animate-pulse bg-slate-200"></div>
                    <div class="w-10 m-2 rounded mb-2 h-6 animate-pulse bg-slate-200"></div>
                    <div class="w-10 m-2 rounded mb-2 h-6 animate-pulse bg-slate-200"></div>
                </ul>
            </div>
            <div v-for="(video, index) in videoList" :key="index" class="w-full md:w-1/2 shadow-lg rounded md:mx-auto md:p-8 p-3 p-2 mt-5 m-2">
                <img class="w-full" :src="`http://img.youtube.com/vi/${video.youtube_id}/hqdefault.jpg`" alt=""/>
                <router-link :to="'./video/info/' + video.id"><p  class="mt-2 text-xl font-bold hover:underline">{{video.title}}</p></router-link>                     
                <p class="text-gray-500 text-end">{{video.update_at}}</p>     
                <ul class="flex flex-wrap mt-5">
                    <li v-for="(tag, index) in (video.tag).split('\n')" :key="index" class="text-basic px-2 bg-gray-100 rounded-full mx-1 w-24 truncate text-center">{{tag}}</li>
                </ul>      
            </div>
        </div>

        <AddBtn text="追加" url="/video/add"></AddBtn>
    </div>
</template>

<script>
    module.exports = {
        data: function(){
            return{
                word: this.$route.query.word || "",
                videoList: [],

                loading: true,
            }
        },

        mounted: function(){
            this.find();
        },

        components:{
            "addbtn": httpVueLoader('../../parts/Button/AddBtn.vue'),
            "searchform": httpVueLoader('../../parts/Form/SearchForm.vue'),
        },

        watch:{
            word: function(){this.find()}
        },

        methods:{
            find: async function(){
                this.$router.push({query: {word: this.word}});

                this.loading = true;
                var result = await axiosLib("api/video/get", {"word": this.word});

                if(result.type = "success"){
                    this.videoList = result.data;
                }
                
                this.loading = false;
            },
        }
    }
</script>