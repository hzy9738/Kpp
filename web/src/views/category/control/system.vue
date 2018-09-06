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
                    <span>系统分类</span>
                </p>
                <Button style="top: 10px;position: absolute;right: 20px"
                        class="button" type="info" shape="circle"
                        @click="createPage"
                >
                    添加
                </Button>

                <Button style="top: 10px;position: absolute;right: 20px"
                        class="button" type="info" shape="circle"
                        @click="createToPage"
                >
                    数据传输
                </Button>
                <Row class="margin-top-10">
                    <can-edit-table
                            refs="table1"
                            :dataList="dataList"
                            class="margin-bottom-10">
                    </can-edit-table>
                </Row>
            </Card>
            </Col>
        </Row>
        <Modal
                v-model="createShow"
                title="添加系统分类"
                @on-ok="createNode('formData')"
                :loading="loading">
            <Form :model="formData" :label-width="100" :rules="formInline" ref="formData">
                <FormItem label="分类：" prop="name">
                    <Input v-model="formData.name" type="text" placeholder="请输入标准分类" style="width: 80%"></Input>
                </FormItem>
            </Form>
        </Modal>

        <Modal
                v-model="toModel"
                title="数据传输"
                width="600"
                @on-ok="createTo('toData')"
                :loading="loading">
            <Form :model="toData" :label-width="100" :rules="toInline" ref="toData">
                <FormItem label="传输源：" prop="from" style="float: left">
                    <Cascader :data="fromDataList" v-model="toData.from" change-on-select  placeholder="请选择传输源" style="width: 100%;"></Cascader>
                </FormItem>
                <FormItem label="目标目录：" prop="to" style="float: left">
                    <Cascader :data="toDataList" v-model="toData.to" change-on-select  placeholder="请选择目标目录" style="width: 100%;"></Cascader>
                </FormItem>
                <div  style="clear: both"></div>
            </Form>
        </Modal>
    </div>
</template>

<script>
    import canEditTable from './components/canEditTable.vue';


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
                        {required: true, message: '请输入系统分类', trigger: 'blur'},
                    ],
                },
                dataList: [],
                createShow: false,
                loading: false,

                toModel:false,
                toData: {
                    from: [],
                    to: [],
                },
                toInline: {
                    from: [
                        {required: true, message: '请选择传输源'},
                    ],
                    to: [
                        {required: true, message: '请选择目标目录'},
                    ],
                },
            };
        },
        methods: {
            createToPage(){
                this.toModel = true
            },
            createTo(name){
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        console.log(this.toData)
                        let toData = {
                            form : this.toData.from,
                            to : this.toData.to,
                            type: 'model'
                        }
                        this.$Modal.confirm({
                            title: '提示',
                            content: '<p>确认要转移数据吗？转移后传输源数据将被删除</p>',
                            onOk: () => {
                                let url = 'categories/from/to'
                                this.JAjax.postJson(url, toData, (res) => {
                                    if(res.code){
                                        this.$Message.success('转移成功');
                                        this.afresh_list()
                                        this.toData = {}
                                    }
                                });
                            },
                            onCancel: () => {
                                this.loading = false;
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

            createPage(){
                this.createShow = true
            },
            createNode(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        let formData = {
                            id: 0,
                            name: this.formData.name,
                            type: 'systems'
                        }
                        let url = 'categories/add/systems'
                        this.JAjax.postJson(url, formData, (res) => {
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
            getlist () {
                let postdata = [];
                this.JAjax.postJson('categories/systems', postdata, (res) => {
                    this.dataList = res.data || [];
                    this._formdata(this.dataList)
                    this.fromDataList = this.dataList
                    this.toDataList = this.dataList
                });
            },
            afresh_list () {
                this.getlist();
            },

            _formdata (data) {
                data.forEach(t=>{
                    t.children = t.system_child || []
                    t.value = t.id || []
                    t.label = t.title || ''
                    this._formdata(t.children)
                })
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
