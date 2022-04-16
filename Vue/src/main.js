import Vue from 'vue'
import App from './App.vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import VueCardStack from 'vue-card-stack'
import vuetify from '@/plugins/vuetify' // path to vuetify export
import VueRouter from 'vue-router'
import router from './router'
import store from './store'
import axios from 'axios'
import apiConfigDev from '../apiConfig/apiConfigDev.json'
import apiConfigProd from '../apiConfig/apiConfigProd.json'
import locale from '../node_modules/element-ui/lib/locale/lang/en.js'
import Carousel3d from 'vue-carousel-3d'

Vue.config.productionTip = false
Vue.use(ElementUI, { locale })
Vue.use(vuetify)
Vue.use(VueRouter)
Vue.use(Carousel3d)

Vue.prototype.getStacks = function () {
	let self = this
	axios
		.get(axios.defaults.baseURL + 'stack.php' + '?email=' + this.$store.state.user.email)
		.then(function (response) {
			self.$store.commit('setStacks', response.data.stacks)
		})
		.catch(function (error) {
			console.log(error)
		})
}

Vue.prototype.getCards = function () {
	let self = this
	axios
		.get(axios.defaults.baseURL + 'card.php' + '?email=' + this.$store.state.user.email)
		.then(function (response) {
			self.$store.commit('setCards', response.data.cards)
			console.log('cards', self.$store.state.user.cards)
		})
		.catch(function (error) {
			console.log(error)
		})
}

function getRandomColor() {
	const colors = ['#00659d', '#00abbc', '#e2c58a', '#fc8890', '#b35d7f']
	return colors[Math.floor(Math.random() * colors.length)]
}

Vue.prototype.getTasks = function () {
	let self = this
	axios
		.get(axios.defaults.baseURL + 'task.php' + '?email=' + this.$store.state.user.email)
		.then(function (response) {
			const tasks = response.data.tasks
			for (let i = 0; i < tasks.length; i++) {
				tasks[i]['color'] = getRandomColor()
			}
			console.log('processed tasks', tasks)
			self.$store.commit('setTasks', tasks)
		})
		.catch(function (error) {
			console.log(error)
		})
}

Vue.prototype.getCardsByStackID = function (stackID) {
	const cards = this.$store.state.user.cards
	const res = []
	for (let i = 0; i < cards.length; i++) {
		if (cards[i]['stackID'] === stackID) res.push(cards[i])
	}
	return res
}

Vue.prototype.updateAllData = function () {
	this.getStacks()
	this.getCards()
	this.getTasks()
}

Vue.prototype.taskAxios = function () {
	let self = this
	return axios.request({
		url: axios.defaults.baseURL + 'task.php?email=' + self.$store.state.user.email,
		withCredentials: true,
	})
}

Vue.prototype.getCardIdByCardName = function (name) {
	const cards = this.$store.state.user.cards
	for (let i = 0; i < cards.length; i++) {
		if (cards[i].name === name) return cards[i].cardID
	}
	return undefined
}

if (process.env.NODE_ENV !== 'development') {
	axios.defaults.baseURL = apiConfigProd.api
	Vue.prototype.apiConfig = apiConfigProd
} else {
	axios.defaults.baseURL = apiConfigDev.api
	Vue.prototype.apiConfig = apiConfigDev
}

router.beforeEach((to, from, next) => {
	console.log('redirected from: ', from, ' to:', to)
	store.commit('getToken')
	// UserHome, SignupPage, LoginPage
	const token = store.state.user.token
	if (typeof token === 'undefined' || token === null || token.length === 0) {
		if (to.name !== 'LoginPage' && to.name !== 'SignupPage' && to.name !== 'UserHome') {
			next({ name: 'LoginPage' })
			console.log('blocked without token')
		} else {
			next()
		}
	} else if (token) {
		if (to.name === 'SignupPage' || to.name === 'LoginPage') {
			next({ name: 'UserHome' })
			console.log('blocked with token', token)
		} else if (from.name === 'UserHome' && to.name !== 'UserHome') {
			store.commit('setDisplayingCardID', undefined)
			next()
		} else {
			next()
		}
	}
})

export default {
	components: {
		VueCardStack,
	},
	data() {
		return {
			cards: [
				{ background: '#00659d' },
				{ background: '#00abbc' },
				{ background: '#e2c58a' },
				{ background: '#fc8890' },
				{ background: '#b35d7f' },
			],
		}
	},
}
new Vue({
	store,
	vuetify,
	render: (h) => h(App),
	router: router,
}).$mount('#app')
