<template>
    <div>
        <div class="mx-1 md:w-3/4 md:mx-auto mb-8 mt-2">
            <SelectForm :list="schoolList" :value="school" :select.sync="school"></SelectForm>
            <SearchForm placeholder="メンバーを検索" :text.sync="name"></SearchForm>
        </div>

        <div class="flex flex-wrap">
            <div v-for="(i) in [...Array(10)].map((_, i) => i)" :key="i" class="md:w-32 w-1/2 mx-auto m-2 border-2 text-center cursor-pointer shadow rounded" :class="{'hidden': !loading}">
                <div class="md:w-16 w-12 mx-auto p-2 h-6 m-2 animate-pulse bg-slate-200"></div>
                <div class="mx-auto rounded-full border w-36 h-36 m-2 animate-pulse bg-slate-200"></div>
                <div class="w-3/4 mx-auto rounded mb-2 h-6 animate-pulse bg-slate-200"></div>
            </div>
            <div v-for="(member, index) in memberList" :key="index" class="md:w-32 w-1/2 mx-auto m-2 border-2 text-center cursor-pointer rounded-lg shadow">
                <p class="text-basic font-bold w-full p-2">{{member.school}}</p>
                <img src="https://ss1.xrea.com/isym.s223.xrea.com/img/person.png" class="mx-auto rounded-full border w-3/4 my-3" alt="">
                <router-link :to="'/member/info/' + member.id">
                    <h2 class="text-lg font-bold  hover:underline">
                        {{member.name}}
                        ({{year - Number(member.ey) + 1}}年)
                    </h2>
                </router-link>
            </div>
        </div>

        <AddBtn url="/member/add"></AddBtn>
    </div>
</template>

<script>
    module.exports = {
        data: function(){
            return{
                memberList: null,
                schoolList: null,
                name: "",
                school: "石山",

                year: new Date().getFullYear(),

                loading: true,
            }
        },

        components: { 
            "addbtn": httpVueLoader('../../parts/Button/AddBtn.vue'),
            "selectform": httpVueLoader('../../parts/Form/SelectForm.vue'),
            "searchform": httpVueLoader('../../parts/Form/SearchForm.vue'),
        },

        watch:{
            name: function(){this.find()},
            school: function(){this.find()},
        },

        mounted: async function(){
            var result = await axiosLib("api/setting/get_school");
            this.schoolList = result.data;

            this.find();
        },

        methods:{
            find: async function(){
                var result = await axiosLib("api/member/get", {"name": this.name, "school": this.school});
                if(result.data != "NoArray"){
                    this.memberList = result.data;

                    this.loading = false;
                }else{
                    this.memberList = [];
                }
            },
        }
    }
</script>