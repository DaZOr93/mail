export default { 

  state: {
    toggleCheckPassword: false,
    colors: [],
    newFolder: {
      name: '',
      description: '',
      color: '',
      password: '',
      confirm_password: '',
    },
  },

  mutations: {
    toggleCheckPassword(state) {
      state.toggleCheckPassword = !state.toggleCheckPassword
    },
    createNewFolder(state, payload) {
      state.newFolder = payload;
    },
  },

  actions: {
    colors(cnt) {
      axios.get('/api/colors')
          .then(r => cnt.commit('colors', r.data))
    },

    createNewFolder(cnt) {
      
    },
  },

  getters: { 
    toggleCheckPassword(state) {
      return state.toggleCheckPassword;
    },
    colors(state) {
      return state.colors;
    },
    folderName(state) {
      return state.newFolder.name;
    },
    folderDescription(state) {
      return state.newFolder.description;
    },
    folderColor(state) {
      return state.newFolder.color;
    },
    folderPassword(state) {
      return state.newFolder.password;
    },
  },

}