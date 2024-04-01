<template>
    <div class="w-screem h-screen pb-14 flex justify-center items-center">
        <div>
            <img class="mx-auto" src="https://ss1.xrea.com/isym.s223.xrea.com/img/svg/logo-192x192.svg" alt="">
            <h1 class="text-lg font-bold">石山高校男子バドミントン部</h1>
            <h2 class="text-basic font-bold text-red-600 text-center">{{errorMessage}}</h2>
            <TextForm type="number" placeholder="ID" :text.sync="id"></TextForm>
            <TextForm type="password" placeholder="パスワード" :text.sync="password"></TextForm>
            <DecisionBtn ref="decision" @click.native="login" title="ログイン"></DecisionBtn>
        </div>
    </div>
</template>

<script>
    module.exports = {
        data:function(){
            return {
                id: store.state.userId,
                password: "",
                errorMessage: "",
            }
        },

        components:{
            textform: httpVueLoader("../../parts/Form/TextForm.vue"),
            decisionbtn: httpVueLoader("../../parts/Button/DecisionBtn.vue"),
        },

        methods:{
            login: async function(){
                var result = await axiosLib("api/user/login", {'id': this.id, 'password': this.password});
                var data = result.data;

                if(data.login){
                    store.dispatch("auth", {
                        user: data
                    });

                    localStorage.setItem("userInfo", JSON.stringify(data));

                    this.$router.push(this.$route.query.redirect);
                }else{
                    this.errorMessage = "パスワードまたはIDが違います";
                    this.$refs.decision.reset();
                }   
            },

        }
    };
</script>