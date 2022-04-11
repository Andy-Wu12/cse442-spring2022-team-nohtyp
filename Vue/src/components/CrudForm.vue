<template>
    <el-form ref="form" label-width="100px" :model="form" :inline="inline">
        <el-form-item v-for="item in formLabel" :key="item.label" :label="item.label">
            <el-input
                v-if="item.type === 'input' && item.model === 'TaskName'"
                :placeholder="'Input'"
                v-model="newTaskName"
            ></el-input>
            <el-input
                v-if="item.type === 'input' && item.model === 'TaskDescription'"
                :placeholder="'Input'"
                v-model="newTaskName"
            ></el-input>
            <el-switch 
                v-if="item.type === 'switch'" ></el-switch>
            <el-date-picker
                v-if="item.type === 'date'"
                type="date"
            >
            <el-select
                v-if="item.type === 'select'"
            ></el-select>
            <el-option
                v-for="item in item.opts"
                :key="item.value"
                :label="item.label"
                :value="item.value"
            ></el-option>
            </el-date-picker>
        </el-form-item>
        <el-form-item><slot></slot></el-form-item>
    </el-form>
</template>

<script>

export default{
    name: 'CrudForm',
    props:{
        formLabel: Array,
        form: Object,
        inline: Boolean
    },
    data() {
        return{
            newTaskName:''
        }
    },
    methods:{
        change(){
            this.$forceUpdate()
        }
    }
}
</script>
