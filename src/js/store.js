const store = new Vuex.Store({
    state: {
        userId: "",
        userToken: "",
        userName: "",
        userType: "",
    },

    mutations: {
        updateUser(state, data){
            state.userId = data.user.id;
            state.userToken = data.user.token;
            state.userName = data.user.name;
            state.userType = data.user.type;
        }
    },

    actions:{
        auth(context, user){
            context.commit("updateUser", user);
        }
    },

    modules: {}
});