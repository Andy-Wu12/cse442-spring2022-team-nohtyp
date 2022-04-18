<template>
	<el-cascader-panel :options="stackOption" :show-all-levels="false" @change="handleChange"> </el-cascader-panel>
</template>
<script>
	export default {
		mounted() {
			this.getStacks()
		},
		computed: {
			stackOption() {
				let options = []
				const currStacks = this.$store.state.user.stacks
				if (currStacks.length !== 0) {
					const newStackOption = {}
					newStackOption['value'] = 'All Tasks'
					newStackOption['label'] = 'All Tasks'
					options.push(newStackOption)
				}
				for (let i = 0; i < currStacks.length; i++) {
					const newStackOption = {}
					newStackOption['value'] = currStacks[i].name
					newStackOption['label'] = currStacks[i].name
					//Adding cards
					newStackOption['children'] = []
					const cards = this.getCardsByStackID(currStacks[i].stackID)
					if (cards.length === 0) {
						const newCardOption = {}
						newCardOption['value'] = 'No cards under this stack'
						newCardOption['label'] = 'No cards under this stack'
						newCardOption['disabled'] = true
						newStackOption['children'].push(newCardOption)
					} else {
						for (let i = 0; i < cards.length; i++) {
							const newCardOption = {}
							newCardOption['value'] = cards[i].name
							newCardOption['label'] = cards[i].name
							newStackOption['children'].push(newCardOption)
						}
					}
					options.push(newStackOption)
				}
				return options
			},
		},
		data() {
			return {}
		},
		methods: {
			handleChange(val) {
				if (val[0] === 'All Tasks') {
					setTimeout(() => {
						this.$store.commit('setLoading', false)
						this.$store.commit('setDisplayingCardID', 0)
						this.$store.commit(
							'setDisplayingTasks',
							this.$store.state.user.tasks
						)
					}, 400)
					return
				}
				const clickedCardName = val[1]
				const displayingCardID = this.getCardIdByCardName(clickedCardName)
				this.$emit('childOneClick')
				this.$store.commit('setLoading', true)
				setTimeout(() => {
					this.$store.commit('setLoading', false)
					this.$store.commit('setDisplayingCardID', displayingCardID)
					this.$store.commit(
						'setDisplayingTasks',
						this.$store.state.user.tasks.filter((task) => task.cardID === displayingCardID)
					)
				}, 400)
			},
		},
	}
</script>
