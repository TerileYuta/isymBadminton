<template>
    <div>
        <HeadMenu text="一般メンバーを追加"></HeadMenu>
        <table class="table-fixed w-full">
            <tr class="my-3">
                <td class="text-lg font-bold">名前</td>
                <td>
                    <TextForm type="text" placeholder="名前を入力" :text.sync="name"></TextForm>
                </td>
            </tr>
            <tr class="my-3">
                <td class="text-lg font-bold">入学年</td>
                <td>
                    <TextForm type="number" placeholder="入学年を入力" :text.sync="ey"></TextForm>
                </td>
            </tr>
            <tr class="my-3">
                <td class="text-lg font-bold">学校名</td>
                <td>
                    <SelectForm :list="schoolList" :select.sync="school"></SelectForm>
                </td>
            </tr>
            <tr class="my-3">
                <td class="text-lg font-bold">タイプ</td>
                <td>
                    <SelectForm :list="typeList" :select.sync="type"></SelectForm>
                </td>
            </tr>
        </table>
        <Message :message="message"></Message>
        <DecisionBtn ref="decision" title="追加" @click.native="action"></DecisionBtn>
    </div>
</template>

<script>
    module.exports = {
        data(){
            return{
                schoolList: null,
                typeList: [{name: "選手"},{name: "マネージャー"},{name: "顧問"},],

                name: "",
                school: "石山",
                ey:"",
                type: "選手",

                message: "",

                id: null
            }
        },

        components:{
            "headmenu": httpVueLoader("../../parts/HeadMenu.vue"),
            "decisionbtn": httpVueLoader("../../parts/Button/DecisionBtn.vue"),
            "textform": httpVueLoader("../../parts/Form/TextForm.vue"),
            "selectform": httpVueLoader("../../parts/Form/SelectForm.vue"),
            "message": httpVueLoader("../../parts/Text/Message.vue"),
        },

        mounted: async function(){
            var result = await axiosLib("api/setting/get_school");
            this.schoolList = result.data
        },

        methods:{
            action: async function(){
                var result = await axiosLib("api/member/action", {"name": this.name, "school": this.school, "ey": this.ey, "type": this.type, "id": this.id});

                if(result){
                    this.$refs.decision.reset();
                    this.name = "";
                    this.message = {"type": "success", "text": "練習日記を保存しました"};
                }
            },
        }
    }
</script>