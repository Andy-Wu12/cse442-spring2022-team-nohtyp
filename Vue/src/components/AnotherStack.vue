<template>
	<carousel-3d
		v-loading="stackLoading"
		element-loading-text="You don't have any tasks in this card"
		element-loading-spinner="el-icon-timer"
		v-if="updated"
		controlsVisible
		:display="this.displayTasksNumber"
		:perspective="this.angle"
		:height="this.height"
		:width="this.width"
		:border="this.border"
		style="margin-top: 20px; margin-bottom: 20px"
	>
		<slide
			v-for="(task, index) in displayingTasks"
			:key="task.taskID"
			:index="index"
			:style="{ 'background-color': task.color }"
		>
			<el-row style="margin: 10px; padding: 10 auto">
				<el-button type="primary" icon="el-icon-edit" circle></el-button>
				<el-button type="success" icon="el-icon-check" circle></el-button>
				<el-button type="danger" icon="el-icon-delete" circle></el-button>
			</el-row>
			<el-descriptions style="padding: 10px" direction="horizontal" :column="1" border size="medium">
				<el-descriptions-item label="Task"> {{ task.name }} </el-descriptions-item>
				<el-descriptions-item label="Extra Notes">{{ task.extra_notes }}</el-descriptions-item>
				<el-descriptions-item label="Due date" :span="2">{{ task.due_date }}</el-descriptions-item>
			</el-descriptions>
		</slide>
	</carousel-3d>
</template>

<script>
	export default {
		props: ['displayTasksNumber', 'angle', 'height', 'width', 'border'],
		mounted() {
			setInterval(() => {
				this.displayingTasks = this.$store.state.user.displayingTasks
			}, 500)
		},
		data() {
			return {
				updated: true,
				displayingTasks: [],
			}
		},
		watch: {
			displayingTasks() {
				this.updated = false
				this.$nextTick(() => {
					this.updated = true
				})
			},
		},
		computed: {
			tasks() {
				const displayingCardID = this.$store.state.user.displayingCardID
				return this.$store.state.user.tasks.filter((task) => task.cardID === displayingCardID)
			},
			stackLoading() {
				if (this.$store.state.user.displayingTasks.length > 0) return false
				const displayingCardID = this.$store.state.user.displayingCardID
				if (displayingCardID === undefined) return true
				const tasks = this.$store.state.user.tasks.filter((task) => task.cardID === displayingCardID)
				return tasks.length === 0
			},
		},
	}
</script>
