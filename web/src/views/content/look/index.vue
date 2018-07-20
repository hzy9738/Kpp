<style lang="less">
    @import '../../../styles/common.less';
    @import './components/table.less';

</style>

<template>
    <div>
        <Row :gutter="10">
            <Col span="8">
                <Card>
                    <p slot="title">
                        <Icon type="cube"></Icon>
                        <span>章节目录</span>
                    </p>
                    <!--<Select v-model="source"-->
                    <!--filterable-->
                    <!--remote-->
                    <!--:remote-method="remoteMethod"-->
                    <!--:loading="loading1"-->
                    <!--@on-change="selectSource"-->
                    <!--style="top: 10px;position: absolute;left: 200px;width: 300px">-->
                    <!--<Option v-for="(option, index) in sources" :value="option.value" :key="index">{{option.label}}-->
                    <!--</Option>-->
                    <!--</Select>-->

                    <Button style="top: 10px;position: absolute;left: 400px;" shape="circle" icon="reply"
                            @click="goBackList" v-if="!sourceOrListShow"></Button>
                    <Row class="margin-top-8">
                        <Button type="info" style="margin-left: 10px" @click="createTitle"
                                v-if="!sourceOrListShow && dataList.length === 0">
                            创建章节
                        </Button>

                        <div v-if="sourceOrListShow">
                            <source-table
                                    refs="table1"
                                    v-model="sourceList"
                                    :columns-list="columns1"
                                    @editShow="editShow"
                                    @updateShow="updateShow"
                                    @afresh_list="afresh_list"
                                    class="margin-bottom-10">
                                >
                            </source-table>
                            <Row class="center">
                                <Page :total="total" show-total @on-change="changePage" :page-size="pageSize"
                                      :page-size-opts="pageSizeOpts" show-elevator
                                      @on-page-size-change="changeSize"></Page>
                            </Row>
                        </div>


                        <can-edit-table
                                v-if="!sourceOrListShow && dataList.length !== 0"
                                refs="table1"
                                :dataList="dataList"
                                @detail="detail"
                                @dataListNode="dataListNode"
                                class="margin-bottom-10">
                        </can-edit-table>
                    </Row>
                </Card>
            </Col>

            <Col span="16">
                <Card>
                    <p slot="title">
                        <Icon type="document-text"></Icon>
                        <span>内容详情</span>
                    </p>

                    <Row >
                        <Col span="24" style="border: 1px solid #aaa;padding: 4px 10px;border-radius: 5px;min-height: 280px">
                           <div  v-if="content!==''">
                               <p v-html="content"></p>
                           </div>
                     </Col>

                    </Row>

                    <Row class="margin-top-8">
                        <Col span="18">

                            <!--<Button type="info" style="margin-left: 20px" @click="getTag">分词</Button>-->
                        </Col>
                    </Row>

                    <Row class="margin-top-8">
                        <Col span="24">
                            <Icon type="bookmark"></Icon>
                            <span>简述</span>
                        </Col>
                    </Row>
                    <Row class="margin-top-8">
                    </Row>
                    <Row class="margin-top-8" v-for="(sentenceData ,index) in sentenceDatas" v-if="sentenceDatas.length>0">
                        <Col span="24">
                            <span  style="float: left;margin:0 10px;font-size: 12px">简述 {{ index + 1}}：</span>
                            <span  style="float: left;margin:0 10px;font-size: 12px;width: 400px">{{ sentenceData.sentence}}</span>

                            <span  style="float: left;margin:0 10px;font-size: 12px">Tag：</span>
                            <div :class="'tag'+index">
                                <Tag v-for="(item,key) in sentenceData.tags" size="small" type="border"  color="yellow" style="margin-top:-5px">{{ item }}</Tag>
                            </div>
                        </Col>
                        <Col span="24" class="margin-top-8" style="margin-bottom: 12px">
                            <span  style="float: left;margin:0 10px;font-size: 12px">知识点分类:</span>
                            <span  style="float: left;margin:0 10px;font-size: 12px;width: 20%">{{ sentenceData.knowledge}}</span>

                            <span  style="float: left;margin:0 10px;font-size: 12px">标准分类：</span>
                            <span  style="float: left;margin:0 10px;font-size: 12px;width: 20%">{{ sentenceData.model}}</span>

                            <span  style="float: left;margin:0 10px;font-size: 12px">类型：</span>
                            <span  style="float: left;margin:0 10px;font-size: 12px;width: 10%">{{ sentenceData.type}}</span>

                            <span  style="float: left;margin:0 10px;font-size: 12px">KP：</span>
                            <span  style="float: left;margin:0 10px;font-size: 12px;width: 10%">{{sentenceData.import?'是':'否'}}</span>
                        </Col>
                        <Col span="24" class="margin-top-8" style="margin-left: 12px;margin-bottom: 12px">

                        </Col>
                        <Col span="24">
                            <hr>

                        </Col>
                    </Row>


                </Card>
            </Col>
            <Modal
                    v-model="createModel"
                    title="创建章节目录"
                    @on-ok="createNode('formData')"
                    :loading="loading">
                <Form :model="formData" :label-width="100" :rules="formInline" ref="formData">
                    <FormItem label="目录名称：" prop="title">
                        <Input v-model="formData.title" type="text" placeholder="请输入目录名称" style="width: 80%"></Input>
                    </FormItem>
                </Form>
            </Modal>
            <Modal
                    v-model="standardShow"
                    title="添加知识点来源"
                    @on-ok="addStandard('standardData')"
                    :loading="loading">
                <Form :model="standardData" :label-width="100" :rules="standardline" ref="standardData">
                    <FormItem label="知识点来源：" prop="name">
                        <Input v-model="standardData.name" type="text" placeholder="请输入子分类" style="width: 80%"></Input>
                    </FormItem>
                    <FormItem label="收集人：" prop="user">
                        <Input v-model="standardData.user" type="text" placeholder="收集人" style="width: 80%"></Input>
                    </FormItem>
                </Form>
            </Modal>
        </Row>
    </div>
</template>

<script>
    import canEditTable from './components/canEditTable.vue';
    import sourceTable from './components/source-table.vue';
    import * as table from './data/search';
    import $  from 'jquery';
    import tinymce from 'tinymce';

    function checkTagJqery(vm,className) {
        let tags = $(className).find('.ivu-tag-checked>span').html()

        console.log(tags)
    }

    export default {
        name: 'searchable-table',
        components: {
            canEditTable,
            sourceTable
        },
        data() {
            return {
                articleTitle: '',
                articleError: '',
                showLink: false,
                fixedLink: '',
                articlePath: '',
                articlePathHasEdited: false,
                editLink: false,
                editPathButtonType: 'ghost',
                editPathButtonText: '编辑',


                standardShow:false,
                standardData:{
                    name: '',
                    user: '',
                },
                standardline: {
                    name: [
                        {required: true, message: '请输入知识点来源', trigger: 'blur'},
                    ],
                    user: [
                        {required: true, message: '请输入收集人', trigger: 'blur'},
                    ],
                },
                columns1: table.columns1, // 表头
                sourceList: [],// 查询结果
                pageSize: 20, // 每页多少条
                total: 0, // 总共多少条数据
                status: null, // 课程状态
                page: 1, // 当前页码
                pageSizeOpts: [20, 25, 30, 40, 50],
                formData: {
                    title: '',
                },
                formInline: {
                    title: [
                        {required: true, message: '请输入目录名称', trigger: 'blur'},
                    ],
                },
                standardPost:true,
                knowledges: [],
                models: [],
                dataList: [],
                content: '',
                tags: [],
                title_id: '',
                category_id: '',
                sources: [],
                source: '',
                loading1: false,
                loading: false,
                createModel: false,
                sentenceDatas: [

                ],
                sourceOrListShow: true,
                category:[],
                types: {},

            }
        },
        methods: {
            editArticlePath () {
                this.editLink = !this.editLink;
                this.editPathButtonType = this.editPathButtonType === 'ghost' ? 'success' : 'ghost';
                this.editPathButtonText = this.editPathButtonText === '编辑' ? '完成' : '编辑';
            },
            change (status) {

            },
            updateShow(data){
                this.standardPost = false
                this.standardData.id = data.id
                this.standardData.name = data.name
                this.standardData.user = data.user
                this.standardShow = true
            },
            addStandard(name){
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        if(this.standardPost){
                            this.JAjax.postJson('standard/add', this.standardData, (res) => {
                                if (res.code) {
                                    this.$Message.success('添加成功');
                                    this.afresh_list();
                                    this.standardData = {}
                                }
                            });
                        }else {
                            this.JAjax.postJson('standard/update', this.standardData, (res) => {
                                if (res.code) {
                                    this.$Message.success('修改成功');
                                    this.afresh_list();
                                    this.standardData = {}
                                }
                            });
                        }
                        setTimeout(() => {
                            this.standardShow = false
                        }, 500);
                    } else {
                        this.loading = false;
                        setTimeout(() => {
                            this.standardShow = true
                            this.loading = true;
                        }, 100);
                        this.$Message.error('请检查您输入的信息');
                    }
                })

            },
            standardAdd(){
                this.standardPost = true
                this.standardShow = true
            },
            getWordBySentence(index) {
                let content = this.sentenceDatas[index].sentence
                if (content !== '') {
                    this.JAjax.postJson('word/tags', {content: content}, (res) => {
                        this.$set(this.sentenceDatas[index], 'tags', res.data)
                    });
                } else {
                    this.$set(this.sentenceDatas[index], 'tags', [])
                }
            },
            handleClose2(index, name) {
                const key = this.sentenceDatas[index].tags.indexOf(name);
                this.sentenceDatas[index].tags.splice(key, 1);
            },
            removeSentence(index) {
                if (this.sentenceDatas.length >= 2) {
                    this.sentenceDatas.splice(index, 1)
                }
            },
            appendSentence() {
                let array = {
                    sentence: '',
                    knowledge: [],
                    model: [],
                    tags: []
                }
                this.sentenceDatas.push(array)
            },
            createNode() {
                let formData = {
                    title: this.formData.title,
                    level: 0,
                    standard: this.source,
                }

                this.$refs['formData'].validate((valid) => {
                    if (valid) {
                        this.JAjax.postJson("title/create", formData, res => {
                            this.$Message.success('创建成功');
                            this.formData.title = ""
                            this.JAjax.postJson('title/lists', {id: this.source}, (res) => {
                                this.dataList = res.data || [];
                            });
                        })
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
            createTitle() {
                this.createModel = true

            },
            remoteMethod(query) {
                if (query !== '') {
                    this.loading1 = true;
                    setTimeout(() => {
                        this.loading1 = false;
                        const list = this.list.map(item => {
                            // console.log(item.name.toLowerCase())
                            return {
                                value: Number(item.id),
                                label: item.name,
                            };
                        });
                        this.sources = list.filter(item => item.label.toLowerCase().indexOf(query.toLowerCase()) > -1);
                    }, 200);
                } else {
                    this.sources = [];
                }
            },
            getSource() {
                this.JAjax.postJson('standard', {}, (res) => {
                    this.list = res.data
                });
            },
            selectSource(data) {
                this.JAjax.postJson('title/lists', {id: data}, (res) => {
                    this.dataList = res.data || [];
                });
            },
            contentKeyup() {
                let a = true
                if (a && this.title_id === '') {
                    a = false
                    this.$Message.error('请选择章节目录')
                    this.content = ""
                }
            },
            saveContent() {



                let a = false
                this.sentenceDatas.forEach(t => {
                    if (t.sentence === '' || t.knowledge.length === 0 || t.model.length === 0 || t.type === "") {
                        a = true
                    }
                })
                if (a) {
                    return this.$Message.error("简述未填写完整")
                }

                this.content = tinymce.activeEditor.getContent();
                let formData = {
                    content: this.content,
                    title: this.title_id,
                    sentences: this.sentenceDatas
                }
                if (this.title_id === '') {
                    // this.$Message.error('请选择章节目录')
                    return
                }

                this.JAjax.postJson('content/save', formData, (res) => {
                    this.$Message.success("保存成功")
                });
            },

            detail(id) {
                this.JAjax.postJson('title/content', {id: id}, (res) => {
                    this.content = res.data.detail ? res.data.detail.content : '';
                    this.title_id = res.data.id
                });
                this.JAjax.postJson('title/sentences', {id: id}, (res) => {
                    let data = res.data || [];
                    this.sentenceDatas = [
                        {}
                    ]
                    data.sentences.forEach((t, index) => {

                        this.$set(this.sentenceDatas, index, {})
                        // console.log(t.page_id.join(","))
                        t.import = t.import ? true : false

                        let pages = t.page_id.split(',')
                        pages = pages.map(v=>this.category[v])
                        t.page = pages.join(' / ')

                        let models = t.model_id.split(',')
                        models = models.map(i=>this.category[i])
                        t.model = models.join(' / ')



                        this.$set(this.sentenceDatas[index], 'sentence', t.sentence)
                        this.$set(this.sentenceDatas[index], 'type', this.types[t.type])
                        this.$set(this.sentenceDatas[index], 'model', t.model)
                        this.$set(this.sentenceDatas[index], 'knowledge', t.page)
                        this.$set(this.sentenceDatas[index], 'tags', t.tags.map(t => t.tag))
                        this.$set(this.sentenceDatas[index], 'import', t.import)

                    })
                });

            },
            getlist() {
                let postdata = {};
                this.JAjax.postJson('title/lists', postdata, (res) => {
                    this.dataList = res.data || [];
                });
            },
            getCategories() {
                this.JAjax.postJson('categories', {}, (res) => {
                    this.category = res.data || [];

                });
            },


            getSourceList() {
                let postdata = {};
                postdata.page = this.page;
                postdata.pageSize = this.pageSize;
                this.JAjax.postJson('standard/lists', postdata, (res) => {
                    this.sourceList = res.data.data || [];
                    this.total = res.data.total;
                    this.pageSize = res.data.per_page;
                });
            },
            changePage(page) {
                this.page = page;
                this.getSourceList();
            },
            changeSize(size) {
                this.pageSize = size;
                this.getSourceList();
            },
            editShow(data) {
                this.JAjax.postJson('title/lists', {id: data.id}, (res) => {
                    this.dataList = res.data || [];
                    this.source = data.id
                    this.sourceOrListShow = false
                    this.formData.title = data.name
                    this.dataList.forEach(t=>{
                        t.expand = true
                    })
                });
            },
            getType() {
                this.JAjax.postJson('kptypes/index/list', {}, (res) => {
                    this.types = res.data
                });
            },
            goBackList() {
                this.sourceOrListShow = true
            },
            afresh_list() {
                this.getlist();
                this.getSourceList();
            },
            dataListNode() {
                this.dataList = []
            }
        },
        mounted() {
            // this.getlist();
            this.getType();
            this.getSource();
            this.getSourceList();
            this.getCategories();



        },

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
