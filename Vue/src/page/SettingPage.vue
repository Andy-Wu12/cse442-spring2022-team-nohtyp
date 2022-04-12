<template>
    <div>
      <!-- <login-form></login-form> -->
      <el-row>
        <el-button type="primary" @click="exportTasks">Export my tasks</el-button>
      </el-row>
    </div>
</template>

<script>
  export default({
    components:{
    },
    data(){
      return{
        icsFile: null
      }
    },
    computed:{
      email(){
        return this.$store.state.user.email
      }
    },
    methods: {
      convertDate(date) {
        let event = new Date(date).toISOString();
        event = event.split("T")[0];
        event = event.split("-");
        event = event.join("");
        return event;
      },
      getNextTaskCounter() {
        // parseInt necessary b/c local storage only stores strings as values
        let nextCounterVal = parseInt(localStorage.userTaskCounter) + 1;
        console.log(nextCounterVal);
        localStorage.userTaskCounter = nextCounterVal;

        return nextCounterVal;
      },
      addEventDataToICSFile(taskJson) {
        let data_blob = "BEGIN:VEVENT\n";

        // Use session email as LHS of uid + incremented task counter to guarantee uniqueness
        let uid = `${this.email}${taskJson.taskID}@cse442NohTypDotPlan`;
        let due_date = null;
        let start_date = this.convertDate(Date.now());
        if (taskJson["due_date"] != null) {
            console.log("Task with due date!")
            due_date = this.convertDate(taskJson["due_date"]);
        }
        let summary = taskJson["name"];
        let desc = taskJson["description"];

        data_blob +=
            `UID:${uid}\n` +
            `DTSTART:${start_date}\n` +
            `SUMMARY:${summary}\n` +
            `DESCRIPTION:${desc}\n`;

        if (due_date != null) {
            data_blob += `DTEND:${due_date}\n`;
        }
        data_blob += "END:VEVENT\n";
        return data_blob;
      },
      exportTasks(){
        const tasksJsonArray = this.$store.state.user.tasks
        if(tasksJsonArray.length === 0){
          alert("You have no tasks to export!");
          return;
        }
        let blob =
          "BEGIN:VCALENDAR\n" +
          "VERSION:2.0\n" +
          "PRODID:-//Dot-Plan-Cal//EN\n" +
          "CALSCALE:GREGORIAN\n" +
          "METHOD:PUBLISH\n";
          for (let i = 0; i < tasksJsonArray.length; i++) {
              blob += this.addEventDataToICSFile(tasksJsonArray[i]);
          }
        blob += "END:VCALENDAR\n";
        console.log(blob)
        let data = new File([blob], "DotPlanEvents.ics", { type: "text/calendar"});
        if (this.icsFile !== null) {
          window.URL.revokeObjectURL(this.icsFile);
        }   
        this.icsFile = window.URL.createObjectURL(data);
        console.log(this.icsFile);
        window.location.href = this.icsFile
        return this.icsFile;
      },
    },  
  })
</script>

<style scoped>
</style>>