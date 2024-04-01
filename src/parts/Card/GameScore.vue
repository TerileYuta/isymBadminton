<template>
    <div>
        <div class="flex justify-end">
            <IconMenu>
                <ul class="text-sm text-gray-700 w-full">
                    <li class="block py-2 text-center cursor-pointer hover:bg-gray-100" @click="router.push(`/score/action?id=${game.id}`)">
                       編集
                    </li>
                    <li class="block py-2 text-center text-red-600 cursor-pointer hover:bg-gray-100">
                        削除
                    </li>
                </ul>
            </IconMenu>
        </div>
        <div class="text-center">
            <h2 class="text-lg font-bold">
                {{game.season}}年度-{{game.tournament}}
            </h2>
            <h2 class="text-base text-gray-400">{{game.date}}</h2>
            <h2 class="text-lg">{{game.gn}}</h2>
        </div>
        <div class="flex">
            <div class="flex-1 text-center flex justify-center items-center">
                <div>
                    <router-link :to="'/member/info/' + game.a1.id">{{game.a1.name}}</router-link>
                    <p class="text-sm text-basic">({{game.a1.school}})</p>
                </div>
                
                <div :class="{'hidden': (game.a2 == '')}">
                    <router-link :to="'/member/info/' + game.a2.id">{{game.a2.name}}</router-link>
                    <br>
                    <p class="text-sm text-basic">({{game.a2.school}})</p>
                </div>
            </div>
            <div class="flex-1 text-center">
                <div class="flex m-3">
                    <h2 class="flex-1 text-lg p-1 h-8 text-white" :class="{'bg-blue-600': judge(game.ag1, game.ag2), 'bg-gray-600': !judge(game.ag1, game.ag2)}">{{game.ag1}}</h2>
                    <h2 class="flex-1 text-lg p-1 h-8">-</h2>
                    <h2 class="flex-1 text-lg p-1 h-8 text-white" :class="{'bg-blue-600': judge(game.bg1, game.ag1), 'bg-gray-600': !judge(game.bg1, game.ag1)}">{{game.bg1}}</h2>
                </div>
                <div class="flex m-3" :class="{'hidden': ((game.ag2 == 0) && (game.bg2 == 0))}">
                    <h2 class="flex-1 text-lg p-1 h-8 text-white" :class="{'bg-blue-600': judge(game.ag2, game.bg2), 'bg-gray-600': !judge(game.ag2, game.bg2)}">{{game.ag2}}</h2>
                    <h2 class="flex-1 text-lg p-1 h-8">-</h2>
                    <h2 class="flex-1 text-lg p-1 h-8 text-white" :class="{'bg-blue-600': judge(game.bg2, game.ag2), 'bg-gray-600': !judge(game.bg2, game.ag2)}">{{game.bg2}}</h2>
                </div>
                <div class="flex m-3" :class="{'hidden': ((game.ag3 == 0) && (game.bg3 == 0))}">
                    <h2 class="flex-1 text-lg p-1 h-8 text-white" :class="{'bg-blue-600': judge(game.ag3, game.bg3), 'bg-gray-600': !judge(game.ag3, game.bg3)}">{{game.ag3}}</h2>
                    <h2 class="flex-1 text-lg p-1 h-8">-</h2>
                    <h2 class="flex-1 text-lg p-1 h-8 text-white" :class="{'bg-blue-600': judge(game.bg3, game.ag3), 'bg-gray-600': !judge(game.bg3, game.ag3)}">{{game.bg3}}</h2>
                </div>
            </div>
            <div class="flex-1 text-center flex justify-center items-center">
                <div>
                    <router-link :to="'/member/info/' + game.b1.id">{{game.b1.name}}</router-link>
                    <br>
                    <p class="text-sm text-basic">({{game.b1.school}})</p>
                </div>
                <div :class="{'hidden': (game.b2 == '')}">
                    <router-link :to="'/member/info/' + game.b2.id">{{game.b2.name}}</router-link>
                    <br>
                    <p class="text-sm text-basic">({{game.b2.school}})</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    module.exports = {
        props:["game"],

        methods:{
            judge(a, b){
                if((a == 21) || ((a >= 22) && (a - b == 2))){
                    return true;
                }else{
                    return false;
                }
            }
        },

        components: {
            "iconmenu": httpVueLoader("../Button/IconMenuBtn.vue")
        }
    };
</script>