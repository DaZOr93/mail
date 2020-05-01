import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        toggleBar: false,
        toggleUser: false
    },
    mutations: {
        toggleBar(state) {
            state.toggleBar = !state.toggleBar
        }
    },
    actions: {
        login() {
            let token = "";
            axios.post("https://team1-group-project.azurewebsites.net/api/auth/login", {
                    email: 'bogdan.lopatkin@gmail.com',
                    password: '16827209'
                }
            )
                .then((response) => {
                  token = response.data.access_token;
                });

           setTimeout( () => {
               console.log('token = ' + token);
               axios.get('https://team1-group-project.azurewebsites.net./oauth/authorize', {
                   headers: {Authorization: "Bearer " + token}
               })
                   .then((response) => {
                       console.log(response);
                   })
                   .catch((error) => {
                       console.log(error);
                   });
           } ,3000)
        },
        auth() {
            axios.get('https://team1-group-project.azurewebsites.net./oauth/authorize', {
                headers: {Authorization: "Bearer " + '2222'}
            })
                .then((response) => {
                    console.log(response);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    getters: {
        toggleBar(state) {
            return state.toggleBar;
        },
        toggleUser(state) {
            return state.toggleUser;
        }

    }
})
