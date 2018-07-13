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

                <!--<Button style="top: 10px;position: absolute;right: 20px"-->
                        <!--class="button" type="info" shape="circle"-->
                        <!--@click="createType"-->
                <!--&gt;-->
                    <!--添加-->
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
                        <Page :total="total"  show-total @on-change="changePage" :page-size="pageSize"
                              :page-size-opts="pageSizeOpts" show-elevator
                              @on-page-size-change="changeSize"></Page>
                    </Row>
                </Row>
            </Card>
            </Col>
        </Row>
        <Modal
                v-model="createShow"
                title="添加类型"
                @on-ok="createNode('formData')"
                :loading="loading">
            <Form :model="formData" :label-width="100" :rules="formInline" ref="formData">
                <FormItem label="分类：" prop="name">
                    <Input v-model="formData.name" type="text" placeholder="请输入类型名称" style="width: 80%"></Input>
                </FormItem>
            </Form>
        </Modal>
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

            return {
                formData: {
                    name: '',
                },
                formInline: {
                    name: [
                        {required: true, message: '请输入知识点分类', trigger: 'blur'},
                    ],
                },
                columns1: table.columns1, // 表头
                dataList: [], // 查询结果
                pageSize: 20, // 每页多少条
                total: 0, // 总共多少条数据
                status: null, // 课程状态
                page: 1, // 当前页码
                pageSizeOpts: [20, 25, 30, 40, 50],
                createShow: false,
                loading: false

            };
        },
        methods: {
            createType(){
                this.createShow = true
            },
            createNode(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        let formData = {
                            id: 0,
                            name: this.formData.name,
                            type: 'page'
                        }

                        this.JAjax.postJson('type/add', formData, (res) => {
                            if(res.code){
                                this.$Message.success('添加成功');
                                this.afresh_list()
                                this.formData.name = ''
                            }
                        });
                        setTimeout(() => {
                            this.show = false;
                        }, 500);
                    } else {
                        this.loading = false;
                        setTimeout(() => {
                            this.loading = true;
                        }, 100);
                        this.$Message.error('请检查您输入的信息');
                    }
                })
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
