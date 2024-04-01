<template>
    <div>
        <HeadMenu text="アクセスマネージャー"></HeadMenu>
        
        <details v-for="(route, index) in routeList" :key="index" class="border-b p-5">
            <summary><span class="text-xl font-bold">{{route.url}}</span></summary>
            <div class="mt-2">
                <table class="table-fixed w-full">
                    <tr>
                        <td>ゲスト</td>
                        <td>
                            <SwitchBtn @update="update(route.id, 'guest')" :value="route.guest"></SwitchBtn>
                        </td>
                    </tr>
                    <tr>
                        <td>選手</td>
                        <td>
                            <SwitchBtn @update="update(route.id, 'player')" :value="route.player"></SwitchBtn>
                        </td>
                    </tr>
                    <tr>
                        <td>マネージャー</td>
                        <td>
                            <SwitchBtn @update="update(route.id, 'manager')" :value="route.manager"></SwitchBtn>
                        </td>
                    </tr>
                    <tr>
                        <td>顧問</td>
                        <td>
                            <SwitchBtn @update="update(route.id, 'directer')"  :value="route.directer"></SwitchBtn>
                        </td>
                    </tr>
                </table>
            </div>
        </details>

    </div>
</template>

<script>
    module.exports = {
        data: function(){
            return {
                routeList: [],
            }
        },

        components: {
            "headmenu": httpVueLoader("../../../parts/HeadMenu.vue"),
            "listcard": httpVueLoader("../../../parts/Card/ListCard.vue"),
            "switchbtn": httpVueLoader("../../../parts/Button/Switch.vue"),
        },

        mounted:async function(){
            var result = await axiosLib("api/setting/get_route");
            this.routeList = result.data;


        },

        methods: {
            update :async function(id, type){
                var result = await axiosLib("api/setting/route/action", {"id": id, "type": type});
            }
        }
    }
</script>