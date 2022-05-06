<template>
	<div id="myChart" :style="{ width: '80vh', height: '80vh' }"></div>
</template>

<script>
	export default {
		data() {
			return {
				msg: 'aa',
				graphData: [
					['2022-04-01', 260],
					['2022-04-04', 200],
					['2022-04-09', 279],
					['2022-04-13', 847],
					['2022-04-18', 241],
					['2022-04-23', 411],
					['2022-05-14', 985],
				],
			}
		},
		mounted() {
			this.links.pop()
			let myChart = this.$echarts.init(document.getElementById('myChart'))
			this.option && myChart.setOption(this.option)
			// this.drawLine()
		},
		computed: {
			tasks(){
				return this.$store.state.user.tasks
			},
			links() {
				const res = this.graphData.map(function (item, idx) {
					return {
						source: idx,
						target: idx + 1,
					}
				})
				return res
			},
            option(){
                const res = {
					tooltip: {},
					calendar: {
						top: 'middle',
						left: 'center',
						orient: 'vertical',
						cellSize: 40,
						yearLabel: {
							margin: 50,
							fontSize: 30,
						},
						dayLabel: {
							firstDay: 1,
							nameMap: 'usa',
						},
						monthLabel: {
							nameMap: 'usa',
							margin: 15,
							fontSize: 20,
							color: '#999',
						},
						range: ['2022-04', '2022-05-31'],
					},
					visualMap: {
						min: 1,
						max: 31,
						type: 'piecewise',
						left: 'center',
						bottom: 20,
						inRange: {
							color: ['#5291FF', '#C7DBFF'],
						},
						seriesIndex: [1],
						orient: 'horizontal',
					},
					series: [
						{
							type: 'graph',
							edgeSymbol: ['none', 'arrow'],
							coordinateSystem: 'calendar',
							links: this.links,
							symbolSize: 15,
							calendarIndex: 0,
							itemStyle: {
								color: 'yellow',
								shadowBlur: 9,
								shadowOffsetX: 1.5,
								shadowOffsetY: 3,
								shadowColor: '#555',
							},
							lineStyle: {
								color: '#D10E00',
								width: 1,
								opacity: 1,
							},
							data: this.graphData,
							z: 20,
						},
						{
							type: 'heatmap',
							coordinateSystem: 'calendar',
							data: this.getVirtulData('2022'),
						},
					],
				}
                return res
            }
		},
		methods: {
			getVirtulData(year) {
				year = year || '2022'
				var date = +this.$echarts.number.parseDate(year + '-01-01')
				var end = +this.$echarts.number.parseDate(+year + 1 + '-01-01')
				var dayTime = 3600 * 24 * 1000
				var data = []
				for (var time = date; time < end; time += dayTime) {
					const timeStr = this.$echarts.format.formatTime('yyyy-MM-dd', time)
					data.push([timeStr, parseInt(timeStr.slice(-2))])
				}
				return data
			},
		},
	}
</script>
