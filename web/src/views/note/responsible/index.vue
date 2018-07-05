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
                    <span>项目负责人绩效登记</span>
                </p>
                <Form :model="date" :label-width="100" :rules="formInline" ref="formData">
                    <FormItem prop="startTime" style="position: absolute;top: 10px;left:70px;width: 150px">
                        <DatePicker type="month"
                                    placeholder="起始时间"
                                    v-model="date.startTime"
                                    style="width: 150px"
                        >
                        </DatePicker>
                    </FormItem>
                    <FormItem prop="endTime" style="position: absolute;top: 10px;left:240px;width: 150px">
                        <DatePicker type="month"
                                    placeholder="结束时间"
                                    v-model="date.endTime"
                                    style="width: 150px"
                                    >
                        </DatePicker>
                    </FormItem>
                    <Button type="ghost" shape="circle" icon="ios-search"
                            style="top: 10px;position: absolute;left: 510px"
                            @click="searchByDate('formData')"
                    ></Button>
                </Form>
                <Button v-permission='["note-month-add"]'
                        style="top: 10px;position: absolute;right: 20px"
                        class="button" type="primary" shape="circle"
                        @click="noteProject"
                >
                    按项目录入
                </Button>
                <!--<Button v-permission='["note-month-add"]'-->
                        <!--style="top: 10px;position: absolute;right: 10px"-->
                        <!--class="button" type="primary" shape="circle"-->
                        <!--@click="noteStaff"-->
                <!--&gt;-->
                    <!--按员工录入-->
                <!--</Button>-->
                <Row class="margin-top-10">
                    <can-edit-table
                            refs="table1"
                            v-model="dataList"
                            :columns-list="columns1"
                            @afresh_list="afresh_list"
                            class="margin-bottom-10">
                    </can-edit-table>
                    <Row class="center">
                        <Page :total="total" show-total @on-change="changePage" :page-size="pageSize"
                              :page-size-opts="pageSizeOpts" show-sizer show-elevator
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
                date: {
                    startTime: '',
                    endTime: '',
                },
                formInline: {
                    startTime: [
                        {required: true, message: '请输入起始时间'},
                    ],
                    endTime: [
                        {required: true, message: '请输入结束时间'},
                        { validator: valideDate }
                    ]
                }
            };
        },
        methods: {
            noteProject () {
                this.$router.push({
                    name: 'note_task',
                });
            },
            noteStaff () {
                this.$router.push({
                    name: 'note_staff',
                });
            },
            searchByDate (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        console.log(this.toMonth(this.date.startTime) + ' --- ' + this.toMonth(this.date.endTime));
                        let postdata = {};
                        postdata.page = this.page;
                        postdata.pageSize = this.pageSize;
                        postdata.start_date = this.toMonth(this.date.startTime);
                        postdata.end_date = this.toMonth(this.date.endTime);
                        this.JAjax.postJson('note/month/list', postdata, (res) => {
                            this.dataList = res.data.data || [];
                            this.total = res.data.total;
                        });
                        setTimeout(() => {
                            this.show = false;
                        }, 500);
                    }
                });
            },
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
                this.JAjax.postJson('note/month/list', postdata, (res) => {
                    this.dataList = res.data.data || [];
                    this.total = res.data.total;
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
