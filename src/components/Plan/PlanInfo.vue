<template>
    <div>
        <HeadMenu :text="`${year}年${month}月${day}日`"></HeadMenu>
        <h2 class="text-lg m-1" v-for="(comment, index) in plan.comment" :key="index" v-html="comment"></h2>


        <AreaForm title="日記" :value="diary.documents" :text.sync="diary"></AreaForm>
        <DecisionBtn ref="decision" title="完了" @click.native="action()"></DecisionBtn>
    </div>
</template>

<script>
    module.exports = {
        data: function(){
            return{
                id:"",
                plan: "",
                diary: "",
                year: "",
                month: "",
                day: "",
                message: {},
            }
        },

        components:{
            "headmenu": httpVueLoader("../../parts/HeadMenu.vue"),
            "areaform": httpVueLoader('../../parts/Form/AreaForm.vue'),
            "decisionbtn": httpVueLoader('../../parts/Button/DecisionBtn.vue'),
            "message": httpVueLoader("../../parts/Text/Message.vue"),
        },

        mounted: async function(){
            this.id = this.$route.params.id;
            this.year = this.id.slice(0,4);
            this.month = this.id.slice(4,6);
            this.day = this.id.slice(6, this.id.length);


            var result = await axiosLib("api/plan/get", {"year": this.year, "month": this.month, "day": this.day});
            if(result.type == "success"){
                this.plan = result.data;
            }

            var result = await axiosLib("api/diary/get", {"year": this.year, "month": this.month, "day": this.day, "name": store.state.userId});
            if(result.type == "success"){
                this.diary = result.data[0];
            }
        },


        methods: {
            action:async function(){
                var result = await axiosLib("api/diary/action", {"year": this.year, "month": this.month, "day": this.day, "name": store.state.userId, "document": this.diary})
                
                if(result.type == "success"){
                    this.$router.go(-1);
                }
            }
        }
    }
</script>