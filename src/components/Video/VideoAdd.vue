<template>
    <div>
        <HeadMenu text="動画を追加"></HeadMenu>

        <TextForm type="text" placeholder="タイトルを入力" :text.sync="title"></TextForm>

        <TextForm type="text" placeholder="URL" :text.sync="video"></TextForm>
        <AreaForm title="概要" :text.sync="documents"></AreaForm>
        <AreaForm title="タグ" :text.sync="tag"></AreaForm>
        
        <DecisionBtn ref="decision" title="追加" @click.native="action()"></DecisionBtn>
    </div>
</template>

<script>
    module.exports = {
        data(){
            return{                
                title: "",
                documents: "",
                video: "",
                tag: "",
            }
        },

        components:{
            "decisionbtn": httpVueLoader("../../parts/Button/DecisionBtn.vue"),
            "headmenu": httpVueLoader("../../parts/HeadMenu.vue"),
            "textform": httpVueLoader("../../parts/Form/TextForm.vue"),
            "areaform": httpVueLoader("../../parts/Form/AreaForm.vue"),
        },

        methods:{
            getVideoId:function(url){
                var id = "";

                if(url.split("watch").length > 1){
                    id = url.split("https://www.youtube.com/watch?v=")[1]
                    
                    return id;
                }else{
                    id = url.split("https://youtu.be/")[1]

                    return id;
                }
            },

            createVideoIdText: function(){
                var videoIdText = "";

                this.video.split("\n").forEach(url =>{
                    videoIdText += this.getVideoId(url) + "\n";
                });

                return videoIdText;
            },

            action:async function(){
                const data = {
                    "title": this.title,
                    "documents": this.documents,
                    "youtube_id": this.createVideoIdText(),
                    "tag": this.tag,
                };

                var result = await axiosLib("api/video/action", data); 

                if(result.type == "success"){
                    this.$router.go(-1);
                }
            },
        }
    }
</script>