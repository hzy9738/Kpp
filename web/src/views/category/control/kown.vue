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
                        <span>知识点分类</span>
                    </p>
                    <Button style="top: 10px;position: absolute;right: 20px"
                            class="button" type="info" shape="circle"
                            @click="createPage"
                    >
                        添加
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
                title="添加知识点分类"
                @on-ok="createNode('formData')"
                :loading="loading">
            <Form :model="formData" :label-width="100" :rules="formInline" ref="formData">
                <FormItem label="分类：" prop="name">
                    <Input v-model="formData.name" type="text" placeholder="请输入知识点分类" style="width: 80%"></Input>
                </FormItem>
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
        data() {
            return {
                formData: {
                    name: '',
                },
                formInline: {
                    name: [
                        {required: true, message: '请输入知识点分类', trigger: 'blur'},
                    ],
                },
                dataList: [],
                createShow: false,
                loading: false
            };
        },
        methods: {
            createPage(){
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
                        let url = 'categories/add/page'
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
            getlist() {
                let postdata = [];
                this.JAjax.postJson('categories/pages', postdata, (res) => {
                    this.dataList = res.data || [];
                    this._formdata(this.dataList)
                });
            },
            afresh_list() {
                this.getlist();
            },

            _formdata(data) {
                data.forEach(t => {
                    t.children = t.page_child || []
                    this._formdata(t.children)
                })
            }
        },
        mounted() {
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
