<template>
    <div>
        <div class="flex justify-end">
            <h1 class="text-xl font-bold text-end">{{$root.name}}</h1>
            <img class="h-8 w-8 p-1 cursor-pointer rounded-full hover:bg-gray-200" src="https://ss1.xrea.com/isym.s223.xrea.com/img/svg/setting.svg" alt="" @click="router.push(`/setting`)">
        </div>

        <HeadLine text="次回の練習"></HeadLine>

        <div class="mx-auto p-6 m-3 w-64 h-64 bg-white rounded-lg border border-gray-200 shadow-md"  @click="router.push(`/plan/info/${year}${month}${plan.day}`)">
            <AnimatePulse class="w-16 h-6 m-1 mx-auto" :loading="loading">
                <h1 class="text-xl text-center font-bold">{{year}}</h1>
            </AnimatePulse>
            <AnimatePulse class="w-full h-8 m-1 mx-auto" :loading="loading">
                <h1 class="text-3xl text-center font-bold">{{month}}月{{plan.day}}日</h1>
            </AnimatePulse>
            <AnimatePulse class="w-16 h-8 m-1 mx-auto" :loading="loading">
                <h1 class="text-2xl text-center font-bold" :class="{'text-red-600': plan.holiday}">（{{plan.dayOfWeek}}）</h1>
            </AnimatePulse>
            <AnimatePulse class="w-32 h-6 m-1 mx-auto" :loading="loading">
                <span class="mt-5"></span>
                <p class="text-xl font-medium text-gray-900 text-center truncate" v-for="(comment, index) in plan.comment" :key="index" v-html="comment"></p>
            </AnimatePulse>
        </div>
        <a class="text-lg text-blue-600 underline font-bold" href="mailto:yuichiro.hashimoto.0216@gmail.com,badminton@brmstar.net "><p class="text-end">欠席連絡</p></a>

        <HeadLine text="最近の練習日記"></HeadLine>
        <div v-for="(diary, index) in diaryList" :key="index" class="flex flex-wrap shadow-lg rounded md:p-8 p-3 p-2 mt-5 m-2 cursor-pointer"  @click="router.push(`/plan/info/${diary.year}${diary.month}${diary.day}`)">
            <h1 class="text-xl font-bold w-full md:w-1/4">{{diary.month}}/{{diary.day}}<span class="text-xl text-center font-bold" :class="{'text-red-600': diary.holiday}">（{{diary.dayOfWeek}}）</span></h1>
            <h2 class="text-lg truncate">{{diary.documents}}</h2>                        

        </div>
    </div>
</template>

<script>
    module.exports = {
        data: function(){
            return{
                year: "",
                month: "",
                day: "",
                plan: [],
                dayOfWeekList: ["日","月","火","水","木","金","土"],

                diaryList: [],

                loading: true,
            }
        },

        components:{
            "headline": httpVueLoader("../../parts/Text/HeadLine.vue"),
            "gamescore": httpVueLoader("../../parts/Card/GameScore.vue"),
            "animatepulse": httpVueLoader('../../parts/Animation/Pulse.vue'),
        },

        mounted: function(){
            var date = new Date();

            this.year = date.getFullYear();
            this.month = date.getMonth() + 1;
            this.day = date.getDate();

            this.getLatestPlan();
        },

        methods:{
            getLatestPlan:async function(){
                var result = await axiosLib("api/plan/get/latest", {"year": this.year, "month": this.month, "day": this.day});
                
                if(result.type == "success"){
                    var data = result.data;
                    var plan = {"day": data.day, "dayOfWeek": this.getDay(`${this.year}/${this.month}/${data.day}`), "holiday": this.idHoliday(`${this.year}/${this.month}/${data.day}`), "comment": data.comment};
    
                    if((plan.dayOfWeek == "土") || (plan.dayOfWeek == "日")){
                        plan.holiday = true;
                    }
                    
                    this.plan = plan;
                    this.loading = false;
                }

                var diaryResult = await axiosLib("api/diary/get", {"name": store.state.userId});
                
                if(diaryResult.type == "success"){
                    diaryResult.data.forEach((diary)=>{
                        diary["dayOfWeek"] = this.getDay(`${diary.year}/${diary.month}/${diary.day}`);
                        diary["holiday"] = this.idHoliday(`${diary.year}/${diary.month}/${diary.day}`);

                        if((diary.dayOfWeek == "土") || (diary.dayOfWeek == "日")){
                            diary.holiday = true;
                        }
                    });                    
    
                    this.diaryList = diaryResult.data;
                }
            },

            getDay: function(date){
                var date = new Date(date);
                var dayOfWeek = date.getDay();

                return this.dayOfWeekList[dayOfWeek];
            },

            idHoliday(date){
                var date = new Date(date);
                var isholiday = JapaneseHolidays.isHoliday(date);

                if(isholiday){
                    return true;
                }else{
                    return false;
                }
            }, 
        },
    }
</script>