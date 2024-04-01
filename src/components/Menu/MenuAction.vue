<template>
    <div>
        <HeadMenu :text="`メニューを${mode}`"></HeadMenu>

        <TextForm type="text" :value="title" placeholder="タイトルを入力" :text.sync="title"></TextForm>
        <AreaForm title="練習内容" :value="documents" :text.sync="documents"></AreaForm>
        <AreaForm title="練習目的" :value="focus" :text.sync="focus"></AreaForm>
        <AreaForm title="ポイント" :value="points" :text.sync="points"></AreaForm>
        <AreaForm title="セット数" :value="set" :text.sync="set"></AreaForm>
        <AreaForm title="参考動画" :value="video" :text.sync="video"></AreaForm>
        <AreaForm title="タグ" :value="tag" :text.sync="tag"></AreaForm>
        
        <DecisionBtn ref="decision" title="完了" @click.native="action()"></DecisionBtn>
    </div>
</template>

<script>
    module.exports = {
        data(){
            return{                
                mode: "追加",

                id: "",
                title: "",
                documents: "",
                points: "",
                focus: "",
                set: "",
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

        mounted: async function(){
            this.id = this.$route.query.id || "";  

            if(this.id != ""){
                var result = await axiosLib("api/menu/get", {"id": this.id});
                var menu = result.data[0]; 

                this.mode = "編集";
                
                this.title = menu.title;
                this.documents = menu.documents;
                this.points = menu.points;
                this.focus = menu.focus;
                this.set = menu.set;
                this.video = menu.video;
                this.video = menu.video;
            }
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
                    if(url != ""){
                        videoIdText += this.getVideoId(url) + "\n";
                    }
                });

                return videoIdText;
            },

            action:async function(){
                const data = {
                    "id": this.id,
                    "title": this.title,
                    "documents": this.documents,
                    "points": this.points,
                    "focus": this.focus,
                    "set": this.set,
                    "video": this.createVideoIdText(),
                    "tag": this.tag,
                };

                var result = await axiosLib("api/menu/action", data); 

                if(result.type == "success"){
                    this.$router.go(-1);
                }
            },
        }
    }
</script>