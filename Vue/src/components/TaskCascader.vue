<template>
	<el-cascader-panel :options="stackOption" :show-all-levels="true"></el-cascader-panel>
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
				for (let i = 0; i < currStacks.length; i++) {
					const newStackOption = {}
					newStackOption['value'] = currStacks[i].name
					newStackOption['label'] = currStacks[i].name
					//Adding cards
					newStackOption['children'] = []
					const cards = this.getCardsByStackID(currStacks[i].stackID)
                    if(cards.length === 0){
                        const newCardOption = {}
                        newCardOption['value'] = 'No cards under this stack'
                        newCardOption['label'] = 'No cards under this stack'
                        newCardOption['disabled'] = true
                        newStackOption['children'].push(newCardOption)
                    }
                    else{
                        for (let i = 0; i < cards.length; i++) {
                            const newCardOption = {}
                            newCardOption['value'] = cards[i].name
                            newCardOption['label'] = cards[i].name
                            newStackOption['children'].push(newCardOption)
                        }
                    }
                    options.push(newStackOption)
				}
                console.log('options', options)
				return options
			},
			option2() {
				return {
					label: 'City name',
					options: [
						{
							value: 'Chengdu',
							label: 'Chengdu',
						},
						{
							value: 'Shenzhen',
							label: 'Shenzhen',
						},
						{
							value: 'Guangzhou',
							label: 'Guangzhou',
						},
						{
							value: 'Dalian',
							label: 'Dalian',
						},
					],
				}
			},
		},
		data() {
			return {
				// options: [
				// 	{
				// 		value: 'Stack',
				// 		label: 'Stack',
				// 		children: [
				// 			{
				// 				value: 'disciplines',
				// 				label: 'Disciplines',
				// 			},
				// 			{
				// 				value: 'navigation',
				// 				label: 'Navigation',
				// 			},
				// 		],
				// 	},
				// ],
			}
		},
	}
</script>
