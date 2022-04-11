import Cookie from 'js-cookie'

export default {
    state: {
        token: '',
        email: '',
        loading: false,
        stacks:[],
        cards: [],
        tasks: [],
        isLoggedIn: false
    },
    mutations: {
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
        }
    }
}