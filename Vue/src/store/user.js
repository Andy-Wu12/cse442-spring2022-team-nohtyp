import Cookie from 'js-cookie'

export default {
    methods: {
    },
    state: {
        token: '',
        email: '',
        loading: false,
        stacks:[],
        cards: [],
        tasks: [],
        isLoggedIn: false,
        editing: ''
    },
    mutations: {
        getStackNameByStackId(id) {
            const stacks = this.$store.state.user.stacks
            console.log(stacks[0])
            for (let i = 0; i < stacks.length; i++) {
                if (stacks[i].stackID === id)
                    return stacks[i].name
            }
            return -1
        },
        setToken(state, val) {
            state.token = val
            Cookie.set('token', val)
        },
        clearToken(state) {
            state.token = ''
            Cookie.remove('token')
        },
        getToken(state) {
            state.token = state.token || Cookie.get('token')
        },
        setEmail(state, val) {
            state.email = val
            Cookie.set('email', val)
        },
        clearEmail(state) {
            state.email = ''
            Cookie.remove('email')
        },
        getEmail(state) {
            state.email = state.email || Cookie.get('email')
        },
        setLoading(state, val) {
            state.loading = val
        },
        clearTasks(state) {
            state.tasks = []
        },
        setStacks(state, val) {
            state.stacks = val
        },
        setCards(state, val) {
            state.cards = val
        },
        setTasks(state, val) {
            state.tasks = val
        },
        setIsLoggedIn(state, val) {
            state.isLoggedIn = val
        },
        setEditing(state, val) {
            state.editing = val
        }
    }
}