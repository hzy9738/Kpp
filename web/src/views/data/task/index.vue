<style lang="less">
    @import '../../../styles/common.less';
    @import './components/table.less';

</style>

<template>
    <div>
        <Row :gutter="10">
            <Col span="24">
                <Card>
                    <p slot="title">
                        <Icon type="cube"></Icon>
                        <span>项目管理</span>

                    </p>
                    <Button v-permission="['data-task-add']" style="top: 10px;position: absolute;right: 110px" class="button" type="primary" shape="circle" @click="addTask">新增项目</Button>
                    <Button style="top: 10px;position: absolute;right: 10px" class="button" type="default" shape="circle" @click="watchStaff">查看比重</Button>
                    <Row class="margin-top-10">
                        <can-edit-table
                                refs="table1"
                                v-model="dataList"
                                :columns-list="columns1"
                                @updateTask="updateTask"
                                @afresh_list="afresh_list"
                                class="margin-bottom-10">
                        </can-edit-table>
                        <Row class="center">
                            <Page :total="total" show-total @on-change="changePage" :page-size="pageSize" :page-size-opts="pageSizeOpts" show-sizer show-elevator @on-page-size-change="changeSize"></Page>
                        </Row>
                    </Row>
                </Card>
            </Col>
        </Row>
        <new-task
                :newModel="newModel"
                :managers="managers"
                :staffs="staffs"
                :responsibles="responsibles"
                :centerStaffs="centerStaffs"
                @afresh_list="afresh_list">
        </new-task>
        <update-task
                :updateModel="updateModel"
                :managers="managers"
                :staffs="staffs"
                :data="data"
                :responsibles="responsibles"
                :centerStaffs="centerStaffs"
                @afresh_list="afresh_list">
        </update-task>
        <task-staff
                :staffModel='staffModel' >
        </task-staff>
    </div>
</template>

<script>
import canEditTable from './components/canEditTable.vue';
import * as table from './data/search';
import newTask from './components/new-task'
import updateTask from './components/update-task'
import taskStaff from './components/task-staff'
export default {
    name: 'searchable-table',
    components: {
        canEditTable,
        newTask,
        updateTask,
        taskStaff
    },
    data () {
        return {
            columns1: table.columns1, // 表头
            dataList: [], // 查询结果
            pageSize: 10, // 每页多少条
            total: 0, // 总共多少条数据
            status: null, // 课程状态
            page: 1, // 当前页码
            pageSizeOpts:[5,10,15,20,25,30],
            newModel: false,
            updateModel: false,
            staffModel: false,
            managers:[],
            responsibles:[],
            staffs: [],
            data:{},
            centerStaffs:[]
        };
    },
    methods: {
        watchStaff() {
            this.staffModel = !this.staffModel
        },
        updateTask (data) {
            this.data = data
            this.updateModel = !this.updateModel
        },
        addTask() {
            this.newModel = !this.newModel
        },
        changePage (page) {
            this.page = page;
            this.getlist();
        },
        changeSize(size){
            this.pageSize = size;
            this.getlist();
        },
        getlist () {
            let postdata = {};
            postdata.page = this.page;
            postdata.pageSize = this.pageSize;
            this.JAjax.postJson('task/list', postdata, (res) => {
                this.dataList = res.data.data || [];
                this.total = res.data.total;
            });
        },
        getUser (){
            this.JAjax.postJson('admin/all/list', this.formData, res=>{
                let users= res.data || {};
                users.forEach(item=>{
                    if(item.is_manager){
                        this.managers.push(item)
                    }
                    if(item.is_responsible){
                        this.responsibles.push(item)
                    }
                })
            })
        },
        getStaff (){
            this.JAjax.postJson('depart/staffs', this.formData, res=>{
                this.staffs = res.data || {};
            })
        },
        getCenterStaff (){
            this.JAjax.postJson('task/center/staffs', this.formData, res=>{
                this.centerStaffs = res.data || {};
            })
        },
        afresh_list() {
            this.getlist()
            this.getStaff()
            this.getCenterStaff()
        },
        init(){
            this.getlist()
            this.getUser()
            this.getStaff()
            this.getCenterStaff()
        }

    },
    mounted () {
        this.init();
    }
};
</script>
<style>
    .center{
        text-align: center;
    }
    .ivu-page{
        display: inline-block;
    }
</style>
