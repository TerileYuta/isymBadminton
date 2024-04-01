<template>
    <div class="mx-auto md:w-1/2 m-1">
        <AnimatePulse class="w-48 h-8" :loading="loading">
            <HeadMenu :text="info.name"></HeadMenu>
        </AnimatePulse>
        <div class="flex">
            <div class="flex-1">
                <img class="w-64" src="https://ss1.xrea.com/isym.s223.xrea.com/img/person.png" alt=""/>
            </div>
            <div class="flex-1">
                <table class="table-fixed w-full">
                    <tr>
                        <td class="text-lg font-bold">学校</td>
                        <td class="text-lg">
                            <AnimatePulse class="w-16 h-6" :loading="loading">
                                <p>{{info.school}}</p>
                            </AnimatePulse>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-lg font-bold">入学年</td>
                        <td class="text-lg">
                            <AnimatePulse class="w-16 h-6" :loading="loading">
                                <p>{{info.ey}}</p>
                            </AnimatePulse>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-lg font-bold">タイプ</td>
                        <td class="text-lg">
                            <AnimatePulse class="w-16 h-6" :loading="loading">
                                <p>{{info.type}}</p>
                            </AnimatePulse>
                        </td>
                    </tr>
                </table>
                <h2 class="text-lg mt-3">{{info.memo}}</h2>
            </div>
        </div>
        <div class="flex  justify-end">
            <button type="button" @click="$refs.addModalRef.showModal()" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1 text-center mr-2 mb-2">編集</button>
        </div>
        <HeadLine text="ゲームログ"></HeadLine>
        <div  v-for="(i) in [...Array(10)].map((_, i) => i)" :key="i" class="border rounded md:p-8 p-1 pt-4 mt-5" :class="{'hidden': !loading}">
            <AnimatePulse class="w-1/2 h-6 m-1 mx-auto" :loading="true"></AnimatePulse>
            <div class="flex">
                <div class="flex-1 text-center flex justify-center items-center">
                    <div>
                        <AnimatePulse class="w-24 m-1 mx-auto h-6" :loading="true"></AnimatePulse>
                        <AnimatePulse class="w-12 m-1 mx-auto h-6" :loading="true"></AnimatePulse>
                    </div>
                </div>
                <div class="flex-1 text-center">
                    <div class="flex m-3">
                        <AnimatePulse class="w-3/4 h-8" :loading="true"></AnimatePulse>
                        <h2 class="flex-1 text-lg p-1 h-8">-</h2>
                        <AnimatePulse class="w-3/4 h-8" :loading="true"></AnimatePulse>
                    </div>
                    <div class="flex m-3">
                        <AnimatePulse class="w-3/4 h-8" :loading="true"></AnimatePulse>
                        <h2 class="flex-1 text-lg p-1 h-8">-</h2>
                        <AnimatePulse class="w-3/4 h-8" :loading="true"></AnimatePulse>
                    </div>
                </div>
                <div class="flex-1 text-center flex justify-center items-center">
                    <div>
                        <AnimatePulse class="w-24 m-1 mx-auto h-6" :loading="true"></AnimatePulse>
                        <AnimatePulse class="w-12 m-1 mx-auto h-6" :loading="true"></AnimatePulse>
                    </div>
                </div>
            </div>
        </div>
        <div v-for="(game, index) in gameLog" :key="index" class="border rounded md:p-8 p-1 pt-4 mt-5">
            <GameScore :game="game"></GameScore>
        </div>                    
    </div>
</template>

<script>
    module.exports = {
        data(){
            return{
                info:"",
                loading: true,

                gameLog: [],
            }
        },

        components: { 
            "headmenu": httpVueLoader("../../parts/HeadMenu.vue"),
            "headline": httpVueLoader('../../parts/Text/HeadLine.vue'),
            "gamescore": httpVueLoader('../../parts/Card/GameScore.vue'),
            "animatepulse": httpVueLoader('../../parts/Animation/Pulse.vue'),
        },

        mounted: function(){
            var id = this.$route.params.id;

            this.find(id);
        },

        watch:{
            "$route.params.id":function(){
                var id = this.$route.params.id;

                this.find(id);
            }
        },

        methods:{
            find: async function(id){
                this.loading = true;

                var result = await axiosLib("api/score/get", {"a1": id, "a2": id, "b1": id, "b2": id, "type": "or"});
                this.gameLog = result.data;

                var result = await axiosLib("api/member/get", {"id": id});
                this.info = result.data[0];

                this.loading = false;
            }
        }
    }
</script>