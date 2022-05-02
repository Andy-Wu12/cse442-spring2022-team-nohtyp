<template>
     <div>
        <el-descriptions direction="horizontal" :column="1" border size="medium">
        <el-descriptions-item label="Name">{{name}}</el-descriptions-item>
        <el-descriptions-item label="Extra Notes">{{extra_notes}}</el-descriptions-item>
        <el-descriptions-item label="Due date" :span="2">{{due_date}}</el-descriptions-item>
        <el-descriptions-item ></el-descriptions-item>
        </el-descriptions>
    </div>
</template>

<script>
    import axios from 'axios'

    export default({
        name:'Card',
        props: ['name', 'extra_notes', 'due_date'],
    });


</script>

<style scoped>

</style>