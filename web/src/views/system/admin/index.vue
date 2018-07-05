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
                        <span>系统管理员</span>
                    </p>
                    <!--"-->
                    <Button style="top: 10px;position: absolute;right: 10px" class="button" type="primary" shape="circle" @click="addAdmin" v-permission="['system-admin-add']">新增管理员</Button>
                    <Row class="margin-top-10">
                        <can-edit-table
                                refs="table1"
                                v-model="dataList"
                                :columns-list="columns1"
                                @afresh_list="afresh_list"
                                class="margin-bottom-10"
                                @update-admin="updateAdmin">
                        </can-edit-table>
                        <Row class="center">
                            <Page :total="total" show-total @on-change="changePage" :page-size="pageSize" :page-size-opts="pageSizeOpts" show-sizer show-elevator @on-page-size-change="changeSize"></Page>
                        </Row>
                    </Row>
                </Card>
            </Col>
        </Row>
        <add-admin
                :addModel="addModel"
                @afresh_list="afresh_list" >
        </add-admin>
        <update-admin
                :updateModal="updateModal"
                :data='data'
                @afresh_list="afresh_list" >
        </update-admin>
    </div>
</template>

<script>
import canEditTable from './components/canEditTable.vue';
import * as table from './data/search';
import addAdmin from './components/add-admin'
import updateAdmin from  './components/update-admin'
export default {
    name: 'searchable-table',
    components: {
        canEditTable,
        addAdmin,
        updateAdmin
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
            addModel: false,
            updateModal: false,
            data:{}
        };
    },
    methods: {
        addAdmin () {
            this.addModel = !this.addModel
        },
        updateAdmin (data) {
            this.updateModal = !this.updateModal
            this.data = data
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
            this.JAjax.postJson('admin/list', postdata, (res) => {
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
