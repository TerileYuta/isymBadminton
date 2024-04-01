<template>
    <div>
        <HeadMenu text="タイムラインへ投稿"></HeadMenu>
        <TextForm type="text" placeholder="タイトルを入力" :text.sync="title"></TextForm>
        <AreaForm title="投稿" :text.sync="documents"></AreaForm>
        <DecisionBtn ref="decision" title="投稿" @click.native="action()"></DecisionBtn>
    </div>
</template>

<script>
    module.exports = {
        data(){
            return{                
                title: "",
                documents: "",
                message: "",
            }
        },

        components:{
            "headmenu": httpVueLoader("../../parts/HeadMenu.vue"),
            "decisionbtn": httpVueLoader("../../parts/Button/DecisionBtn.vue"),
            "textform": httpVueLoader("../../parts/Form/TextForm.vue"),
            "areaform": httpVueLoader("../../parts/Form/AreaForm.vue"),
        },

        methods:{
            action:async function(){
                var result = await axiosLib("api/timeline/action", {"title": this.title, "documents": this.documents});

                if(result.data){
                    this.$refs.decision.reset();
                    this.$router.go(-1)
                }

            },
        }
    }
</script>