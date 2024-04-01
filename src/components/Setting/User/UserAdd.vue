<template>
    <div>
        <HeadMenu text="ユーザーを追加"></HeadMenu>
        <table class="table-fixed w-full">
            <tr class="my-3">
                <td class="text-lg font-bold">入学年</td>
                <td>
                    <TextForm type="number" placeholder="入学年を入力" :text.sync="ey"></TextForm>
                </td>
            </tr>
            <tr>
                <td class="text-lg font-bold">名前</td>
                <td>
                    <TextForm type="text" placeholder="名前を入力" :text.sync="name"></TextForm>
                </td>
            </tr>
            <tr>
                <td class="text-lg font-bold">権限</td>
                <td>
                    <SelectForm :list="[{'name': '選手'}, {'name': 'マネージャー'}, {'name': '顧問'}]" :select.sync="type"></SelectForm>
                </td>
            </tr>
            <tr class="my-3">
                <td class="text-lg font-bold">パスワード</td>
                <td>
                    <TextForm type="text" placeholder="パスワードを入力" :text.sync="password"></TextForm>
                </td>
            </tr>
        </table>
        <Message :message="message"></Message>
        <DecisionBtn ref="decision" title="追加" @click.native="action()"></DecisionBtn>
    </div>
</template>

<script>
    module.exports = {
        data(){
            return{
                ey: "",
                name: "",
                type: "",
                password: "",
                message: "",
            }
        },

        components:{
            "headmenu": httpVueLoader("../../../parts/HeadMenu.vue"),
            "decisionbtn": httpVueLoader("../../../parts/Button/DecisionBtn.vue"),
            "textform": httpVueLoader("../../../parts/Form/TextForm.vue"),
            "selectform": httpVueLoader("../../../parts/Form/SelectForm.vue"),
            "message": httpVueLoader("../../../parts/Text/Message.vue"),
        },

        methods:{
            action: async function(){
                var result = await axiosLib("api/user/add", {'name': this.name, 'type': this.type, 'ey': this.ey, 'password': this.password});

                if(result == "NoArray"){
                    this.$refs.decision.reset();
                    this.message = {"type": "success", "text": "メンバーを追加しました"};
                }
            }
        }
    }
</script>