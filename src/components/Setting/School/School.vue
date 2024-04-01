<template>
    <div>
        <HeadMenu text="登録高校一覧"></HeadMenu>
        <ul>
            <ListCard  v-for="(school, index) in schoolList" :key="index" :text="school.name" :id="school.id"></ListCard>
        </ul>
    </div>
</template>

<script>
    module.exports = {
        data: function(){
            return {
                schoolList: [],
            }
        },

        components: {
            "headmenu": httpVueLoader("../../../parts/HeadMenu.vue"),
            "listcard": httpVueLoader("../../../parts/Card/ListCard.vue"),
        },

        mounted:async function(){
            var result = await axiosLib("api/setting/get_school");
            this.schoolList = result.data
        }
    }
</script>