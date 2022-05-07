<template>
	<div id="myChart" :style="{ width: '80vh', height: '80vh' }"></div>
</template>

<script>
	import axios from 'axios'
	export default {
		data() {
			return {
				tasks: [],
			}
		},
		mounted() {
			const self = this
			this.$store.commit('setLoading', true)
			axios
				.get(axios.defaults.baseURL + 'task.php' + '?email=' + this.getCookie('email'))
				.then(function (response) {
					self.$store.commit('setTasks', response.data.tasks)
					self.tasks = response.data.tasks
					self.links.pop()
					let myChart = self.$echarts.init(document.getElementById('myChart'))
					self.option && myChart.setOption(self.option)
				})
				.catch(function (error) {
					console.log(error)
				})
				.finally(() => {
					self.$store.commit('setLoading', false)
				})

			// this.drawLine()
		},
		computed: {
			//   tasks() {
			//     return this.$store.state.user.tasks
			//   },
			graphData() {
        let dateCount = {}
				let retData = []
				let taskData = this.tasks
				console.log('Tasks: ', taskData)
        taskData = this.sortDates(taskData);
        // At this point, taskData is only Date, which we can covert back to YYYY-MM-DD using .toISOString() and .split('T')[0]
				for (let i = 0; i < taskData.length; i++) {
					let retDataEntry = [];
					const taskDateTime = taskData[i];
          let date = taskDateTime.toISOString().split('T')[0];
          if(date in dateCount) {
            // Each retData entry is a list of ['2022-04-01', # of tasks due that day] format
            dateCount[date]++;
          }
          else {
            dateCount[date] = 0;
          }
          // This still pushes duplicate entries.
          retDataEntry.push(date, dateCount[date]);
          // console.log(retDataEntry);
          retData.push(retDataEntry);
				}
        console.log("Return data to graph: " + retData);
				return retData
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
			option() {
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
      sortDates(dateList) {
        let dateObjs = [];
        for(let i = 0; i < dateList.length; i++) {
          // console.log(dateList[i]['due_date']);
          if(dateList[i]['due_date'] != null) {
            dateObjs.push(new Date(dateList[i]['due_date']));
          }
        }
        return dateObjs.sort((d1, d2) => d1 - d2);
      },
			getVirtulData(year) {
				year = year || '2022'
				var date = +this.$echarts.number.parseDate(year + '-01-01')
				var end = +this.$echarts.number.parseDate(+year + 1 + '-01-01')
				var dayTime = 3600 * 24 * 1000
				var data = []
				for (var time = date; time < end; time += dayTime) {
					let calDate = this.$echarts.format.formatTime('yyyy-MM-dd', time)
					let dayOfMonth = parseInt(calDate.slice(-2))
					data.push([calDate, dayOfMonth])
				}
				return data
			},
		},
	}
</script>
