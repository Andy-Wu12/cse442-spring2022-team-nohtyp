<template>
	<div>
		<HelloWorld></HelloWorld>
		<!-- <CardsStack v-show="this.$store.state.user.tasks.length > 0"></CardsStack> -->
		<LandingPage v-if="!this.$store.state.user.isLoggedIn"></LandingPage>
		<el-result
			icon="success"
			style="padding-top: 200px"
			title="You have finished all your tasks!"
			v-if="showTasksFinishedResult"
		>
		</el-result>
		<AnotherStack
			v-show="this.$store.state.user.isLoggedIn && this.$store.state.user.tasks.length > 0"
		></AnotherStack>
		<el-row v-show="this.$store.state.user.isLoggedIn && this.$store.state.user.tasks.length > 0">
			<div style="float: left; margin-bottom: 10px">
				<el-radio-group v-model="filter" @change="show">
					<el-radio-button label="Past Due"></el-radio-button>
					<el-radio-button label="Due Soon"></el-radio-button>
				</el-radio-group>
				<el-divider direction="vertical"></el-divider>
				<el-button type="info" @click="clearSelection">Clear</el-button>
			</div>
		</el-row>
		<TaskCascader
			@childOneClick="handleChildOneClick"
			v-if="this.$store.state.user.isLoggedIn && this.$store.state.user.tasks.length > 0"
		></TaskCascader>
	</div>
</template>

<script>
	import HelloWorld from '../components/HelloWorld'
	// import CardsStack from "../components/CardsStack"
	import LandingPage from '../page/LandingPage'
	// import TaskSelector from "@/components/TaskSelector"
	import TaskCascader from '@/components/TaskCascader'
	import AnotherStack from '@/components/AnotherStack'
	// import StackRadio from "@/components/StackRadio"

	export default {
		mounted() {
			this.updateAllData()
			setTimeout(() => {
				this.showTasksFinishedResult = this.$store.state.user.isLoggedIn && this.$store.state.user.tasks.length === 0
			}, 500)
		},
		data() {
			return {
				filter: '',
				selectionCleared: true,
				showTasksFinishedResult: false,
			}
		},
		methods: {
			handleChildOneClick() {
				this.filter = ''
			},
			show() {
				if (this.filter === 'Past Due') {
					const displayingCardID = this.$store.state.user.displayingCardID
					const displayingTasks =
						displayingCardID === 0
							? this.$store.state.user.tasks
							: this.$store.state.user.tasks.filter((task) => task['cardID'] === displayingCardID)
					this.$store.commit(
						'setDisplayingTasks',
						displayingTasks.filter((task) => new Date(task['due_date']) < new Date())
					)
				}
				if (this.filter === 'Due Soon') {
					const displayingCardID = this.$store.state.user.displayingCardID
					const displayingTasks =
						displayingCardID === 0
							? this.$store.state.user.tasks
							: this.$store.state.user.tasks.filter((task) => task['cardID'] === displayingCardID)
					this.$store.commit(
						'setDisplayingTasks',
						displayingTasks.filter((task) => new Date(task['due_date']) > new Date())
					)
				}
			},
			clearSelection() {
				this.filter = ''
				const displayingCardID = this.$store.state.user.displayingCardID
				const displayingTasks =
					displayingCardID === 0
						? this.$store.state.user.tasks
						: this.$store.state.user.tasks.filter((task) => task['cardID'] === displayingCardID)
				this.$store.commit('setDisplayingTasks', displayingTasks)
			},
		},
		components: {
			HelloWorld,
			// CardsStack,
			LandingPage,
			// TaskSelector,
			TaskCascader,
			AnotherStack,
			// StackRadio
		},
		computed: {
			hasTasks() {
				return this.$store.state.user.tasks.length > 0
			},
			tasksDisplaying() {
				return this.$store.state.displayingCardID !== undefined
			},
			showRadio() {
				return (
					(this.$store.state.user.isLoggedIn && this.$store.state.user.displayingCardID === undefined) ||
					this.$store.state.user.displayingTasks.length > 0
				)
			},
		},
	}
</script>

<style></style>
