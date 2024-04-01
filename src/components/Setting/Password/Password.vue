<template>
    <div>
        <HeadMenu text="パスワードを変更"></HeadMenu>
        <TextForm type="password" placeholder="新しいパスワードを入力" :text.sync="newPassword"></TextForm>
        <TextForm type="password" placeholder="確認" :text.sync="checkPassword"></TextForm>
        <Message :message="message"></Message>
        <DecisionBtn ref="decision" title="変更" @click.native="action()"></DecisionBtn>
    </div>
</template>

<script>
    module.exports = {
        data: function(){
            return {
                newPassword: "",
                checkPassword: "",
                message: {},
            }
        },

        components: {
            "headmenu": httpVueLoader("../../../parts/HeadMenu.vue"),
            "message": httpVueLoader("../../../parts/Text/Message.vue"),
            "textform": httpVueLoader("../../../parts/Form/TextForm.vue"),
            "decisionbtn": httpVueLoader("../../../parts/Button/DecisionBtn.vue"),
        },

        methods: {
            action: async function(){
                if(this.newPassword == this.checkPassword){
                    var result = await axiosLib("api/user/password", {"id": store.state.userId, "password": this.newPassword});

                    if(result.data == "NoArray"){
                        this.$refs.decision.reset();
                        this.message = {"type": "success", "text": "パスワードを変更しました"};
                    }
                }else{
                    this.message = {"type": "error", "text": "パスワードが一致しません"};
                    this.checkPassword = "";
                    this.$refs.decision.reset();
                }

            },
        }
    }
</script>