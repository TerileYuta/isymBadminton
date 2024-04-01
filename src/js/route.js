//ルーティング
const routes = [
    { 
        path: "/login", 
        component: httpVueLoader('./src/components/User/Login.vue'),
        meta: {requiresAuth: false},
    },

    { 
        path: "/logout", 
        component: httpVueLoader('./src/components/User/Logout.vue'),
        meta: {requiresAuth: false}
    },

    { 
        path: "/error", 
        component: httpVueLoader('./src/components/Error.vue'),
        meta: {requiresAuth: false}
    },

    { 
        path: "/setting",
        component: httpVueLoader('./src/components/Setting/Setting.vue'),
        meta: {requiresAuth: true}
    },

    { 
        path: "/setting/school",
        component: httpVueLoader('./src/components/Setting/School/School.vue'),
        meta: {requiresAuth: true}
    },

    { 
        path: "/setting/tournament",
        component: httpVueLoader('./src/components/Setting/Tournament/Tournament.vue'),
        meta: {requiresAuth: true}
    },

    { 
        path: "/setting/user/add", 
        component: httpVueLoader('./src/components/Setting/User/UserAdd.vue'),
        meta: {requiresAuth: true}
    },

    { 
        path: "/setting/password", 
        component: httpVueLoader('./src/components/Setting/Password/Password.vue'),
        meta: {requiresAuth: true}
    },

    { 
        path: "/setting/route", 
        component: httpVueLoader('./src/components/Setting/Route/Route.vue'),
        meta: {requiresAuth: true}
    },

    { 
        path: "/", 
        component: httpVueLoader('./src/components/Home/Home.vue'),
        meta: {requiresAuth: true}
    },

    { 
        path: "/plan",
        component: httpVueLoader('./src/components/Plan/Plan.vue'),
        meta: {requiresAuth: false}  
    },

    { 
        path: "/plan/info/:id",
        component: httpVueLoader('./src/components/Plan/PlanInfo.vue'),
        meta: {requiresAuth: true}
    },

    { 
        path: "/score", 
        component: httpVueLoader('./src/components/Score/Score.vue'),
        meta: {requiresAuth: true}
    },
    { 
        path: "/score/action/", 
        component: httpVueLoader('./src/components/Score/ScoreAction.vue'),
        commeta: {requiresAuth: true}
    },
    { 
        path: "/score/info/:id", 
        component: httpVueLoader('./src/components/Score/ScoreInfo.vue'),
        meta: {requiresAuth: true}
    },

    { 
        path: "/menu",
        component: httpVueLoader('./src/components/Menu/Menu.vue'),
        meta: {requiresAuth: true}
    },
    { 
        path: "/menu/action", 
        component: httpVueLoader('./src/components/Menu/MenuAction.vue'),
        meta: {requiresAuth: true}
    },
    { 
        path: "/menu/info/:id", 
        component: httpVueLoader('./src/components/Menu/MenuInfo.vue'),
        meta: {requiresAuth: true}
    },

    { 
        path: "/member", 
        component: httpVueLoader('./src/components/Member/Member.vue'),
        meta: {requiresAuth: true}
    },
    { 
        path: "/member/add", 
        component: httpVueLoader('./src/components/Member/MemberAdd.vue'),
        meta: {requiresAuth: true}
    },
    { 
        path: "/member/info/:id", 
        component: httpVueLoader('./src/components/Member/MemberInfo.vue'),
        meta: {requiresAuth: true}
    },

    { 
        path: "/timeline", 
        component: httpVueLoader('./src/components/Timeline/TimeLine.vue'),
        meta: {requiresAuth: true}
    },
    { path: "/timeline/add", 
        component: httpVueLoader('./src/components/Timeline/TimeLineAdd.vue'),
        meta: {requiresAuth: true}
    },
    { 
        path: "/timeline/info/:id",
        component: httpVueLoader('./src/components/Timeline/TimeLineInfo.vue'),
        meta: {requiresAuth: true}
    },

    { 
        path: "/video",
        component: httpVueLoader('./src/components/Video/Video.vue'),
        meta: {requiresAuth: true}
    },

    { 
        path: "/video/info/:id",
        component: httpVueLoader('./src/components/Video/VideoInfo.vue'),
        meta: {requiresAuth: true}
    },

    { 
        path: "/video/add",
        component: httpVueLoader('./src/components/Video/VideoAdd.vue'),
        meta: {requiresAuth: true}
    },
];

const router = new VueRouter({
    routes
});

router.beforeEach(async (to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)){
        if(!store.state.userToken){
            if(localStorage.getItem("userInfo") != null){
                var data = JSON.parse(localStorage.getItem("userInfo"));
                
                store.dispatch("auth", {
                    user: data
                });

            }else{
                next({ path: '/login', query: { redirect: to.fullPath }});
                return;
            }
        }

        var path = to.path.replace(/\d/g, '');
        if(path != to.path){
            path += ":id";
        }

        var auth = await axiosLib("api/user/token/auth", {"token": store.state.userToken, "url": path});
        if(auth == 0){
            next({ path: '/error'});
        }else{
            next();
        }
    }else{
        next()
    }
});


