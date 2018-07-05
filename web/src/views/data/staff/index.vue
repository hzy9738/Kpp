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
                        <span>员工管理</span>
                    </p>
                    <Button v-permission="['data-staff-add']" style="top: 10px;position: absolute;right: 20px" class="button" type="primary" shape="circle" @click="addStaff">新增员工</Button>
                    <Row class="margin-top-10">
                        <can-edit-table
                                refs="table1"
                                v-model="dataList"
                                :columns-list="columns1"
                                @afresh_list="afresh_list"
                                @updateStaff="updateStaff"
                                class="margin-bottom-10">
                        </can-edit-table>
                        <Row class="center">
                            <Page :total="total" show-total @on-change="changePage" :page-size="pageSize" :page-size-opts="pageSizeOpts" show-sizer show-elevator @on-page-size-change="changeSize"></Page>
                        </Row>
                    </Row>
                </Card>
            </Col>
        </Row>
        <new-staff :newModel="newModel" @afresh_list="afresh_list"></new-staff>
        <update-staff
                :updateModel="updateModel"
                :data="data"
                @afresh_list="afresh_list">
        </update-staff>
    </div>
</template>

<script>
import canEditTable from './components/canEditTable.vue';
import * as table from './data/search';
import qs from 'qs';
import newStaff from './components/new-staff'
import updateStaff from './components/update-staff'
export default {
    name: 'searchable-table',
    components: {
        canEditTable,
        newStaff,
        updateStaff
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
            newModel:false,
            updateModel:false,
            data:0
        };
    },
    methods: {
        updateStaff (data) {
            this.updateModel = !this.updateModel
            this.data = data
        },
        addStaff () {
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
            this.JAjax.postJson('staff/list', postdata, (res) => {
                this.dataList = res.data.data || [];
                this.total = res.data.total;
            });
        },
        afresh_list () {
            this.getlist()
        }
    },
    mounted () {
        this.getlist();
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
