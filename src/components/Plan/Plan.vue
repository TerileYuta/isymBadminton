<template>
    <div>
        <div class="flex m-3">
            <button @click="reduceMonth()" type="button" class="text-white bg-blue-600 w-10 h-10 inline-flex hover:bg-blue-800 rounded-full text-sm p-2 text-center items-center mr-2">
                <img src="https://ss1.xrea.com/isym.s223.xrea.com/img/svg/arrow-left.svg" class="w-full" alt="">
            </button>
            <p class="text-xl my-2 flex-1 font-bold text-center">{{date.getFullYear()}}年{{date.getMonth() + 1}}月</p>
            <button @click="addMonth()" type="button" class="text-white bg-blue-600 w-10 h-10 inline-flex hover:bg-blue-800 rounded-full text-sm p-2 text-center items-center mr-2">
                <img src="https://ss1.xrea.com/isym.s223.xrea.com/img/svg/arrow-right.svg" class="w-full" alt="">
            </button>
        </div>
        <hr>
        <div class="flex text-basic w-full p-2 border-b" :class="{'bg-gray-100': dayData.holiday}" v-for="(dayData, index) in plan" :key="index">
            <div class="w-1/5 text-center font-bold border-r cursor-pointer" @click="router.push(`/plan/info/${date.getFullYear()}${date.getMonth() + 1}${dayData.day}`)">
                <p>{{dayData.day}}日</p>
                <p :class="{'text-red-600': dayData.holiday}">（{{dayData.dayOfWeek}}）</p>
            </div>
            <div class="w-4/5 break-words pl-2 plan-comment">
                <p v-for="(comment, index) in dayData.comment" :key="index" v-html="comment"></p>
            </div>
        </div> 
    </div>
</template>

<script>
    module.exports = {
        data: function(){
            return{
                date: new Date(),
                dayOfWeekList: ["日","月","火","水","木","金","土"],
                plan:[],
            }
        },
        
        components:{
            "selectform": httpVueLoader('../../parts/Form/SelectForm.vue'),
        },
        
        mounted: async function(){
            this.getPlan();
        },
    
        watch: {
            "date": function(){this.getPlan();},
        },

        methods: {
            getPlan: async function(){ 
                var result = await axiosLib("api/plan/get", {"year": this.date.getFullYear(), "month": this.date.getMonth() + 1});
                
                if(result.type == "success"){
                    var planList = result.data;
                }

                var newPlanList = [];
    
                var maxDay = new Date(this.date.getFullYear(), this.date.getMonth() + 1, 0).getDate();

                for(var i = 1; i <= maxDay; i ++){
                    var list = {"day": i, "dayOfWeek": this.getDay(i), "holiday": this.idHoliday(i), "comment": ""};

                    if(i in planList){
                        list["id"] = planList[i]["id"];
                        list["comment"] = planList[i]["comment"];
                    }

                    if((list.dayOfWeek == "土") || (list.dayOfWeek == "日")){
                        list.holiday = true;
                    }

                    newPlanList.push(list);;
                }

                this.plan = newPlanList;
            },

            getDay: function(day){
                const date = new Date(`${this.date.getFullYear()}/${this.date.getMonth() + 1}/${day}`);
                var dayOfWeek = date.getDay();
                return this.dayOfWeekList[dayOfWeek];
            },

            idHoliday(day){
                const date = new Date(`${this.date.getFullYear()}/${this.date.getMonth() + 1}/${day}`);
                var isholiday = JapaneseHolidays.isHoliday(date);

                if(isholiday){
                    return true;
                }else{
                    return false;
                }
            }, 

            addMonth: function(){
                var date = new Date(this.date.getFullYear(), this.date.getMonth(), 0);
                date.setMonth(date.getMonth() + 2);
                this.date = date;
            },

            reduceMonth: function(){
                var date = new Date(this.date.getFullYear(), this.date.getMonth(), 0);
                date.setMonth(date.getMonth());
                this.date = date;
            },
        }
    }
</script>