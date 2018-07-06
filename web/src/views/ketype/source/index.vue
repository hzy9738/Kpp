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
                        <span>知识点来源管理</span>
                    </p>
                    <Button v-permission='["note-month-add"]'
                            style="top: 10px;position: absolute;right: 20px"
                            class="button" type="primary" shape="circle"
                            @click="addKown"
                    >
                        添加
                    </Button>

                    <Row class="margin-top-10">
                        <can-edit-table
                                refs="table1"
                                v-model="dataList"
                                :columns-list="columns1"
                                @afresh_list="afresh_list"
                                @updateShow="updateShow"
                                class="margin-bottom-10">
                        </can-edit-table>
                        <Row class="center">
                            <Page :total="total" show-total @on-change="changePage" :page-size="pageSize"
                                  :page-size-opts="pageSizeOpts" show-elevator
                                  @on-page-size-change="changeSize"></Page>
                        </Row>
                    </Row>
                </Card>
            </Col>
        </Row>

        <Modal
                v-model="show"
                title="添加知识点来源"
                @on-ok="addNode('formData')"
                :loading="loading">
            <Form :model="formData" :label-width="100" :rules="formInline" ref="formData">
                <FormItem label="知识点来源：" prop="name">
                    <Input v-model="formData.name" type="text" placeholder="请输入子分类" style="width: 80%"></Input>
                </FormItem>
                <FormItem label="类型：" prop="type">
                    <Select v-model="formData.type" style="width:80%">
                        <Option v-for="item in types" :value="item.id" :key="item.id" placeholder="请选择类型">{{ item.name
                            }}
                        </Option>
                    </Select>
                </FormItem>
            </Form>
        </Modal>
        <Modal
                v-model="updateModal"
                title="添加知识点来源"
                @on-ok="updateNode('formData')"
                :loading="loading">
            <Form :model="formData" :label-width="100" :rules="formInline" ref="formData">
                <FormItem label="知识点来源：" prop="name">
                    <Input v-model="formData.name" type="text" placeholder="请输入子分类" style="width: 80%"></Input>
                </FormItem>
                <FormItem label="类型：" prop="type">
                    <Select v-model="formData.type" style="width:80%">
                        <Option v-for="item in types" :value="item.id" :key="item.id" placeholder="请选择类型">{{ item.name
                            }}
                        </Option>
                    </Select>
                </FormItem>
            </Form>
        </Modal>
    </div>
</template>

<script>
    import canEditTable from './components/canEditTable.vue';
    import * as table from './data/search';

    export default {
        name: 'searchable-table',
        components: {
            canEditTable,
        },
        data() {
            return {
                columns1: table.columns1, // 表头
                dataList: [], // 查询结果
                pageSize: 20, // 每页多少条
                total: 0, // 总共多少条数据
                status: null, // 课程状态
                page: 1, // 当前页码
                pageSizeOpts: [20, 25, 30, 40, 50],
                show: false,
                updateModal: false,
                loading: true,
                formData: {
                    name: '',
                    type: ''
                },
                formInline: {
                    name: [
                        {required: true, message: '请输入知识点来源', trigger: 'blur'},
                    ],
                    type: [
                        {required: true, message: '请选择类型'},
                    ],
                },
                type: "",
                types: []
            };
        },
        methods: {
            addNode(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.JAjax.postJson('standard/add', this.formData, (res) => {
                            if (res.code) {
                                this.$Message.success('添加成功');
                                this.afresh_list();
                                this.formData = []
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
            updateShow(data) {
                this.formData = {
                    name : data.name,
                    id : data.id,
                    type : data.types.id
                }
                this.updateModal = true
            },
            updateNode(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.JAjax.postJson('standard/update',this.formData, (res) => {
                            if (res.code) {
                                this.$Message.success('修改成功');
                                this.afresh_list();
                                this.formData = {}
                            }
                        });
                        setTimeout(() => {
                            this.updateModal = false;
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


            addKown() {
                this.formData = {}
                this.show = true
            },
            changePage(page) {
                this.page = page;
                this.getlist();
            },
            changeSize(size) {
                this.pageSize = size;
                this.getlist();
            },
            getlist() {
                let postdata = {};
                postdata.page = this.page;
                postdata.pageSize = this.pageSize;
                this.JAjax.postJson('standard/lists', postdata, (res) => {
                    this.dataList = res.data.data || [];
                    this.total = res.data.total;
                    this.pageSize = res.data.per_page;
                });
            },
            getType() {
                this.JAjax.postJson('kptypes', {}, (res) => {
                    this.types = res.data
                });
            },
            afresh_list() {
                this.getlist();
            }
        },
        mounted() {
            this.getlist();
            this.getType();
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
