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
import * as echarts from 'echarts'
import VueTour from 'vue-tour'

require('vue-tour/dist/vue-tour.css')

Vue.config.productionTip = false
Vue.use(ElementUI, { locale })
Vue.use(vuetify)
Vue.use(VueRouter)
Vue.use(Carousel3d)
Vue.prototype.$echarts = echarts
Vue.use(VueTour)

Vue.prototype.getStacks = function () {
	let self = this
	axios
		.get(axios.defaults.baseURL + 'stack.php' + '?email=' + this.getCookie('email'))
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
		.get(axios.defaults.baseURL + 'card.php' + '?email=' + this.getCookie('email'))
		.then(function (response) {
			self.$store.commit('setCards', response.data.cards)
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
		.get(axios.defaults.baseURL + 'task.php' + '?email=' + this.getCookie('email'))
		.then(function (response) {
			const tasks = response.data.tasks
			for (let i = 0; i < tasks.length; i++) {
				tasks[i]['color'] = getRandomColor()
			}
			self.$store.commit('setTasks', tasks)
			self.$store.commit('setDisplayingTasks', tasks)
			self.$store.commit('setDisplayingCardID', 0)
		})
		.catch(function (error) {
			console.log(error)
		})
}

Vue.prototype.getCookie = function (cookieName) {
	let decodedCookie = decodeURIComponent(document.cookie)
	let cookieArr = decodedCookie.split(';')
	for (let i = 0; i < cookieArr.length; i++) {
		let cookie = cookieArr[i]
		cookie = cookie.trim()
		if (cookie.indexOf(cookieName) == 0) {
			return cookie.substring(cookieName.length + 1, cookie.length)
		}
	}
	return ''
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
	return axios.request({
	url: axios.defaults.baseURL + 'task.php?email=' + this.getCookie('email'),
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

Vue.prototype.showReminder = function () {
	setTimeout(() => {
		const past_due_tasks = this.$store.state.user.tasks.filter((task) => new Date(task['due_date']) < new Date())
		if (this.$store.state.user.email && this.$store.state.user.email.length > 0) {
			this.$notify.info({
				title: 'Reminder',
				dangerouslyUseHTMLString: true,
				message: 'You have ' + `<h1>${this.$store.state.user.tasks.length}</h1>` + ' tasks',
				duration: 4500,
				offset: 70,
			})
		}
		setTimeout(() => {
			if (past_due_tasks.length > 0) {
				this.$notify.warning({
					title: 'Reminder',
					dangerouslyUseHTMLString: true,
					message: 'You have ' + `<h1>${past_due_tasks.length}</h1>` + ' tasks past due time',
					duration: 5000,
					offset: 70,
				})
			}
		}, 500)
	}, 2000)
}

if (process.env.NODE_ENV !== 'development') {
	axios.defaults.baseURL = apiConfigProd.api
	Vue.prototype.apiConfig = apiConfigProd
} else {
	axios.defaults.baseURL = apiConfigDev.api
	Vue.prototype.apiConfig = apiConfigDev
}

router.beforeEach((to, from, next) => {
	store.commit('getToken')
	// UserHome, SignupPage, LoginPage
	const email = store.state.user.email
	if (typeof email === 'undefined' || email === null || email.length === 0) {
		if (to.name !== 'LoginPage' && to.name !== 'SignupPage' && to.name !== 'UserHome' && to.name !== 'LandingPage') {
			next({ name: 'LoginPage' })
		} else {
			next()
		}
	} else if (email) {
	if (to.name === 'SignupPage' || to.name === 'LoginPage') {
		next({ name: 'UserHome' })
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
