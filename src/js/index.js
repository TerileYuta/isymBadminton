//ServiceWorker
window.addEventListener('load', function () {
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register("./sw.js")
            .then(function (registration) {
                //console.log("serviceWorker registed.");
            }).catch(function (error) {
            //console.warn("serviceWorker error.", error);
        });
    }
});

var app = new Vue({
    el: '#app',
    router: router,
    store: store,

    data: function () {
        return {
            activePage: "Home",
            name: store.state.userName || "",
            errorModalActivity: false,
            errorTitle: "",
            errorCode: "",
            errorMessage: "",
            errotUrl : "",
        }
    },

    components:{
        "homeicon": httpVueLoader("./src/parts/HomeIcon.vue"),
        "errormodal": httpVueLoader('./src/parts/Modal/ErrorModal.vue'),
    },

    methods: {
        modalChange: function (title = "", code = "", message = "", url = "") {
            if(title != ""){
                this.errorModalActivity = true;
            }else{
                this.errorModalActivity = false;
            }

            this.errorTitle = title;
            this.errorCode = code;
            this.errorMessage = message;
            this.errotUrl = url;
        }
    }
});