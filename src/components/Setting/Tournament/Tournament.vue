<template>
    <div>
        <HeadMenu text="登録大会一覧"></HeadMenu>
        <ul>
            <ListCard  v-for="(tournament, index) in tournamentlList" :key="index" :text="tournament.name" :id="tournament.id"></ListCard>
        </ul>
    </div>
</template>

<script>
    module.exports = {
        data: function(){
            return {
                tournamentlList: [],
            }
        },

        components: {
            "headmenu": httpVueLoader("../../../parts/HeadMenu.vue"),
            "listcard": httpVueLoader("../../../parts/Card/ListCard.vue"),
        },

        mounted:async function(){
            var result = await axiosLib("api/setting/get_tournament");
            this.tournamentlList = result.data
        }
    }
</script>