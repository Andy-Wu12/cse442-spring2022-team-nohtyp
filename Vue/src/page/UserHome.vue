<template>
	<div>
		<el-result
			icon="success"
			style="padding-top: 200px"
			title="You have finished all your tasks!"
			v-if="showTasksFinishedResult"
		>
		</el-result>

		<div id="v-step-0"></div>
		<div>
			<AnotherStack
				:displayTasksNumber="displayTasksNumber"
				:angle="angle"
				:height="height"
				:width="width"
				:border="border"
				v-show="this.$store.state.user.isLoggedIn && this.$store.state.user.tasks.length > 0"
			></AnotherStack>
		</div>
		<el-row v-show="this.$store.state.user.isLoggedIn && this.$store.state.user.tasks.length > 0">
			<div style="float: left; margin-bottom: 10px">
				<el-radio-group v-model="filter" @change="show">
					<el-radio-button label="Past Due"></el-radio-button>
					<el-radio-button label="Due Soon"></el-radio-button>
				</el-radio-group>
				<el-divider direction="vertical"></el-divider>
				<el-button type="info" @click="clearSelection">Clear</el-button>
				<el-popover placement="top-end" width="400" trigger="hover">
					<div class="block">
						<span class="demonstration">Number</span>
						<el-slider v-model="displayTasksNumber" :step="1" :max="8" show-stops> </el-slider>
						<span class="demonstration">Angle</span>
						<el-slider v-model="angle" :step="5" :max="80" show-stops> </el-slider>
						<span class="demonstration">Height</span>
						<el-slider v-model="height" :step="10" :min="250" :max="500"> </el-slider>
						<span class="demonstration">Width</span>
						<el-slider v-model="width" :step="10" :min="270" :max="500"> </el-slider>
						<span class="demonstration">Border</span>
						<el-slider v-model="border" :step="2" :min="0" :max="30"> </el-slider>
					</div>
					<el-button slot="reference">Customize</el-button>
				</el-popover>
			</div>
		</el-row>
		<TaskCascader
			@childOneClick="handleChildOneClick"
			v-if="this.$store.state.user.isLoggedIn && this.$store.state.user.tasks.length > 0"
		></TaskCascader>
		<DockContainer v-if="this.$store.state.user.isLoggedIn"></DockContainer>
		<v-tour name="myTour" :steps="steps" :callbacks="tourCallback"></v-tour>
	</div>
</template>

<script>
	import Cookies from 'js-cookie'

	import DockContainer from '@/components/Dock/DockContainer'
	import TaskCascader from '@/components/TaskCascader'
	import AnotherStack from '@/components/AnotherStack'

	export default {
		components: {
			DockContainer,
			TaskCascader,
			AnotherStack,
		},
		mounted() {
			if(this.steps.length > 0)
				this.$tours['myTour'].start()
			this.updateAllData()
			setInterval(() => {
				this.showTasksFinishedResult = this.$store.state.user.isLoggedIn && this.$store.state.user.tasks.length === 0
			}, 100)
		},
		data() {
			return {
				tourCallback: {
					onSkip: this.endTour,
					onFinish: this.endTour,
				},
				filter: '',
				selectionCleared: true,
				showTasksFinishedResult: false,
				displayTasksNumber: 5,
				angle: 35,
				height: 270,
				width: 360,
				border: 2,
			}
		},
		methods: {
			endTour(){
				Cookies.remove('tour')
			},
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
			steps() {
				if (Cookies.get('tour') !== undefined && Cookies.get('tour') === 'true') {
					return [
						{
							target: '#v-step-0',
							content: `You will see your tasks here`,
						},
						{
							target: '#v-step-1',
							content: 'Check the chart of you tasks here',
						},
						{
							target: '#v-step-2',
							content: 'Manage your data here',
						},
						{
							target: '#v-step-3',
							content: 'You can access settings page here',
						},
						{
							target: '#v-step-4',
							content: 'You can also modify your settings here and log out',
						},
					]
				} else return []
			},
		},
	}
</script>

<style></style>
