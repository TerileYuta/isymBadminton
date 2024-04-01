<template>
    <div>
        <HeadMenu text="試合結果を入力"></HeadMenu>
        <table class="table-fixed w-full">
            <tr>
                <td colspan="1" class="text-lg font-bold">シーズン</td>
                <td colspan="2">
                    <SelectForm :value="season" :list="seasonList" :select.sync="season"></SelectForm>
                </td>
            </tr>
            <tr>
                <td colspan="1" class="text-lg font-bold">大会名</td>
                <td colspan="2">
                    <SelectForm value="" :list="tournamentList" :select.sync="tournament"></SelectForm>
                </td>
            </tr>
            <tr>
                <td colspan="1" class="text-lg font-bold">A1</td>
                <td colspan="2">
                    <TextForm type="text" placeholder="名前を入力" list="nameA1List" :text.sync="nameA1" :value="nameA1"></TextForm>
                    <datalist id="nameA1List">
                        <option v-for="(member, index) in memberDataList" :key="index" :value="member.name + '-' + member.id">{{member.name + '(' + member.school + ')'}}</option>
                    </datalist>
                </td>
            </tr>
            <tr>
                <td colspan="1" class="text-lg font-bold">A2</td>
                <td colspan="2">
                    <TextForm type="text" placeholder="名前を入力" list="nameA2List" :text.sync="nameA2" :value="nameA2"></TextForm>
                    <datalist id="nameA2List">
                        <option v-for="(member, index) in memberDataList" :key="index" :value="member.name + '-' + member.id">{{member.name + '(' + member.school + ')'}}</option>
                    </datalist>
                </td>
            </tr>
            <tr>
                <td colspan="1" class="text-lg font-bold">B1</td>
                <td colspan="2">
                    <TextForm type="text" placeholder="名前を入力" list="nameB1List" :text.sync="nameB1" :value="nameB1"></TextForm>
                    <datalist id="nameB1List">
                        <option v-for="(member, index) in memberDataList" :key="index" :value="member.name + '-' + member.id">{{member.name + '(' + member.school + ')'}}</option>
                    </datalist>
                </td>
            </tr>
            <tr>
                <td colspan="1" class="text-lg font-bold">B2</td>
                <td colspan="2">
                    <TextForm type="text" placeholder="名前を入力" list="nameB2List" :text.sync="nameB2"  :value="nameB2"></TextForm>
                    <datalist id="nameB2List">
                        <option v-for="(member, index) in memberDataList" :key="index" :value="member.name + '-' + member.id">{{member.name + '(' + member.school + ')'}}</option>
                    </datalist>
                </td>
            </tr>
            <tr class="my-3">
                <td class="border p-1">
                    <TextForm type="number" placeholder="AG1" :text.sync="aG1" :value="aG1"></TextForm>
                </td>
                <td class="border p-1">
                    <TextForm type="number" placeholder="AG2" :text.sync="aG2" :value="aG2"></TextForm>
                </td>
                <td class="border p-1">
                    <TextForm type="number" placeholder="AG3" :text.sync="aG3" :value="aG3"></TextForm>
                </td>
            </tr>
            <tr class="my-3">
                <td class="border p-1">
                    <TextForm type="number" placeholder="BG1" :text.sync="bG1" :value="bG1"></TextForm>
                </td>
                <td class="border p-1">
                    <TextForm type="number" placeholder="BG2" :text.sync="bG2" :value="bG2"></TextForm>
                </td>
                <td class="border p-1">
                    <TextForm type="number" placeholder="BG3" :text.sync="bG3" :value="bG3"></TextForm>
                </td>
            </tr>
        </table>
        <AreaForm title="メモ" :text.sync="memo" :value="memo"></AreaForm>
        <DecisionBtn ref="decision" title="追加" @click.native="action()"></DecisionBtn>
    </div>
</template>

<script>
    module.exports = {
        data(){
            return{
                schoolList: null,
                memberDataList : [],

                id: "",

                nameA1: "",
                nameA2: "",
                nameB1: "",
                nameB2: "",

                aG1: null,
                aG2: null,
                aG3: null,
                bG1: null,
                bG2: null,
                bG3: null,

                memo: "",

                season: new Date().getFullYear(),
                seasonList: [],

                tournament: "",
                tournamentList: [],

                newName: "",
            }
        },

        components:{
            "headmenu": httpVueLoader("../../parts/HeadMenu.vue"),
            "decisionbtn": httpVueLoader("../../parts/Button/DecisionBtn.vue"),
            "textform": httpVueLoader("../../parts/Form/TextForm.vue"),
            "selectform": httpVueLoader("../../parts/Form/SelectForm.vue"),
            "areaform": httpVueLoader("../../parts/Form/AreaForm.vue"),
        },

        mounted: async function(){
            this.id = this.$route.query.id || "";

            if(this.id != ""){
                var result = await axiosLib("api/score/get", {"id": this.id});
                var game = result.data[0];    

                this.season = game.season;
                this.tournament = game.tournament;

                this.nameA1 = game.a1.name;
                this.nameA2 = game.a2.name || "";
                this.nameB1 = game.b1.name;
                this.nameB2 = game.b2.name || "";

                this.aG1 = game.ag1;
                this.aG2 = game.ag2;
                this.aG3 = game.ag3;
                this.bG1 = game.bg1;
                this.bG2 = game.bg2;
                this.bG3 = game.bg3;

                this.memo = game.memo;
            }

            var result = await axiosLib("api/setting/get_tournament");

            if(result.type == "success"){
                this.tournamentList = result.data;
            }

            var list = [];
            for(var i = 2021; i <= this.season; i ++){
                list.push({name: i});
            }

            this.seasonList = list;
        },

        watch:{
            nameA1: function(){this.findMember("A1")},
            nameA2: function(){this.findMember("A2")},
            nameB1: function(){this.findMember("B1")},
            nameB2: function(){this.findMember("B2")},
        },

        methods:{
            findMember: async function(player){
                var name = "";

                this.memberDataList = [];

                switch (player){
                    case "A1":
                        name = this.nameA1;
                        break;
                    case "A2":
                        name = this.nameA2;
                        break;
                    case "B1":
                        name = this.nameB1;
                        break;
                    case "B2":
                        name = this.nameB2;
                        break;
                } 

                var result = await axiosLib("api/member/get", {"name": name});
                this.memberDataList = result.data;

            },

            action:async function(){
                var data = {
                    "id": this.id,
                    "season": this.season,
                    "tournament": this.tournament,
                    "a": JSON.stringify({"a1": this.nameA1.split("-")[1], "a2" : this.nameA2.split("-")[1] || "", "g1": this.aG1, "g2": this.aG2 || 0, "g3": this.aG3 || 0}),
                    "b": JSON.stringify({"b1": this.nameB1.split("-")[1], "b2" : this.nameB2.split("-")[1] || "", "g1": this.bG1, "g2": this.bG2 || 0, "g3": this.bG3 || 0}),
                    "memo": this.memo || ""
                } 

                var result = await axiosLib("api/score/action", data);

                if(result.type == "success"){
                    this.$router.go(-1);
                }

                this.$refs.decision.reset();
            },
        }
    }
</script>