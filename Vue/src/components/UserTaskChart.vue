<template>
	<div id="myChart" :style="{ width: '80vh', height: '80vh' }"></div>
</template>

<script>
	export default {
		mounted() {
			this.links.pop()
			let myChart = this.$echarts.init(document.getElementById('myChart'))

			this.option && myChart.setOption(this.option)

			// this.drawLine()
		},
		computed: {
      tasks() {
        return this.$store.state.user.tasks
      },
      graphData() {
        let retData = [];
        const taskData = this.tasks;
        console.log("Tasks: " + taskData);
        for(let i = 0; i < taskData.length; i++) {
          const task = taskData[i];
          console.log(task);
        }
        return retData;
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
          // This part controls the color "LEGEND" under the chart, which is unnecessary for our uses
					// visualMap: {
					// 	min: 0,
					// 	max: 10,
					// 	type: 'piecewise',
					// 	left: 'center',
					// 	bottom: 20,
					// 	inRange: {
					// 		color: ['#5291FF', '#C7DBFF'],
					// 	},
					// 	seriesIndex: [1],
					// 	orient: 'horizontal',
					// },
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
          let calDate = this.$echarts.format.formatTime('yyyy-MM-dd', time);
          let dayOfMonth = parseInt(calDate.slice(-2));
					data.push([calDate, dayOfMonth])
				}
				return data
			},
		},
	}
</script>
