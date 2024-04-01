<template>
    <div>
        <HeadMenu text="設定"></HeadMenu>
        <ul class="mt-3">
            <SettingMenu text="登録メンバー一覧" url="/member"></SettingMenu>
            <SettingMenu text="登録高校一覧" url="/setting/school"></SettingMenu>
            <SettingMenu text="登録大会一覧" url="/setting/tournament"></SettingMenu>
            <SettingMenu text="アクセスマネージャー" url="/setting/route"></SettingMenu>
            <SettingMenu text="パスワード変更" url="/setting/password"></SettingMenu>
            <SettingMenu text="ログアウト" url="/logout"></SettingMenu>
        </ul>
    </div>
</template>

<script>
    module.exports = {
        data: function(){
            return{

            }
        },

        components: {
            "settingmenu": httpVueLoader("../../parts/Card/SettingMenu.vue"),
            "headmenu": httpVueLoader("../../parts/HeadMenu.vue"),
        }
    }
</script>