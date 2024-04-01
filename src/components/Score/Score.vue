<template>
    <div>
        <div class="mx-1 md:w-3/4 md:mx-auto mt-2 mb-8">
            <SelectForm :value="year" :list="yearList" :select.sync="season"></SelectForm>
            <SelectForm value="" :list="tournamentList" :select.sync="tournament"></SelectForm>
        </div>

        <div class="mb-20">
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
            <div v-for="(game, index) in gameList" :key="index" class="shadow-lg md:w-2/3 mx-auto rounded md:p-8 p-1 pt-4 mt-5 m-2">
                <GameScore :game="game"></GameScore>
                <div class="text-end font-bold p-3">
                    <router-link :to="`./score/info/${game.id}`"><p class="hover:underline">詳しく見る</p></router-link>
                </div>
            </div>
        </div>

        <AddBtn text="追加" url="/score/action"></AddBtn>

        <ErrorModal></ErrorModal>
    </div>
</template>

<script>
    module.exports = {
        data: function(){
            return{
                gameList: null,

                season: new Date().getFullYear(),
                tournament: "",
                tournamentList: [],

                yearList: [],
                year: new Date().getFullYear(),

                loading: true,
            }
        },

        components: { 
            "addbtn": httpVueLoader("../../parts/Button/AddBtn.vue"),
            "selectform": httpVueLoader('../../parts/Form/SelectForm.vue'),
            "gamescore": httpVueLoader('../../parts/Card/GameScore.vue'),
            "animatepulse": httpVueLoader('../../parts/Animation/Pulse.vue'),
            
        },

        watch:{
            tournament:function(){ this.find()},
            season:function(){ this.find()},
        },

        mounted: async function(){
            var list = [];
            for(var i = 2021; i <= this.year; i ++){
                list.push({name: i});
            }
            this.yearList = list;

            var result = await axiosLib("api/setting/get_tournament");

            if(result.type == "success"){
                var tournamentList = result.data;
                tournamentList.push({name: ""});
                this.tournamentList = tournamentList;
                this.find();
            }
        },

        methods:{
            deleteScore: function(id){
                axios.post("api/score/delete", data)
                    .then((response) => {
                        this.find();
                        this.load = false;
                    })
                    .catch(err => {
                        //console.log("err:", err);
                    });
            },

            find: async function(){
                this.loading = true;

                var result = await axiosLib("api/score/get", {"season": this.season, "tournament": this.tournament});

                if(result.type == "success"){
                    this.gameList = result.data;
                }

                this.loading = false;
            },
        }
    }
</script>