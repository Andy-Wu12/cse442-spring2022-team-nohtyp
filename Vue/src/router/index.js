import VueRouter from "vue-router";
import UserHome from '../page/UserHome'
import SignupPage from '../page/SignupPage'
import LoginPage from '../page/LoginPage'
import SettingPage from '../page/SettingPage'
import StackEditPage from '../page/StackEditPage'
import CardEditPage from '../page/CardEditPage'
import TaskEditPage from '../page/TaskEditPage'
import ChartsPage from '../page/ChartsPage'

export default new VueRouter({
	routes: [
		{
			name: 'UserHome',
			path: '/',
			component: UserHome,
			meta: { transition: 'slide-left' },
		},
		{
			name: 'SignupPage',
			path: '/signup',
			component: SignupPage,
			meta: { transition: 'slide-right' },
		},
		{
			name: 'LoginPage',
			path: '/login',
			component: LoginPage,
			meta: { transition: 'slide-left' },
		},
		{
			name: 'SettingPage',
			path: '/settings',
			component: SettingPage,
			meta: { transition: 'slide-right' },
		},
		{
			name: 'StackEditPage',
			path: '/edit-stack',
			component: StackEditPage,
			meta: { transition: 'slide-right' },
		},
		{
			name: 'CardEditPage',
			path: '/edit-card',
			component: CardEditPage,
			meta: { transition: 'slide-right' },
		},
		{
			name: 'TaskEditPage',
			path: '/edit-task',
			component: TaskEditPage,
			meta: { transition: 'slide-right' },
		},
		{
			name: 'ChartsPage',
			path: '/charts',
			component: ChartsPage,
			meta: { transition: 'slide-right' },
		},
	],
})