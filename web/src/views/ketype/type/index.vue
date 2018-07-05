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
                    <span>类型管理</span>
                </p>


                <Row class="margin-top-10">
                    <can-edit-table
                            refs="table1"
                            v-model="dataList"
                            :columns-list="columns1"
                            @afresh_list="afresh_list"
                            class="margin-bottom-10">
                    </can-edit-table>
                    <Row class="center">
                        <Page :total="total"  show-total @on-change="changePage" :page-size="pageSize"
                              :page-size-opts="pageSizeOpts" show-elevator
                              @on-page-size-change="changeSize"></Page>
                    </Row>
                </Row>
            </Card>
            </Col>
        </Row>
    </div>
</template>

<script>
    import canEditTable from './components/canEditTable.vue';
    import * as table from './data/search';
    import qs from 'qs';

    export default {
        name: 'searchable-table',
        components: {
            canEditTable,
        },
        data () {
            const valideDate = (rule, value, callback) => {
                if (Date.parse(value) < Date.parse(this.date.startTime)) {
                    callback(new Error('结束时间应该大于开始时间'));
                } else {
                    callback();
                }
            };
            return {
                columns1: table.columns1, // 表头
                dataList: [], // 查询结果
                pageSize: 20, // 每页多少条
                total: 0, // 总共多少条数据
                status: null, // 课程状态
                page: 1, // 当前页码
                pageSizeOpts: [20, 25, 30, 40, 50],


            };
        },
        methods: {

            changePage (page) {
                this.page = page;
                this.getlist();
            },
            changeSize (size) {
                this.pageSize = size;
                this.getlist();
            },
            getlist () {
                let postdata = {};
                postdata.page = this.page;
                postdata.pageSize = this.pageSize;
                this.JAjax.postJson('kptypes/lists', postdata, (res) => {
                    this.dataList = res.data.data || [];
                    this.total = res.data.total;
                    this.pageSize = res.data.per_page;
                });
            },
            afresh_list () {
                this.getlist();
            }
        },
        mounted () {
            this.getlist();
        }
    };
</script>
<style>
    .center {
        text-align: center;
    }

    .ivu-page {
        display: inline-block;
    }
</style>
