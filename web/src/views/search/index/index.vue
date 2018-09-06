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
                        <span>Kkp查询</span>
                    </p>

                    <Row class="margin-top-8">
                        <Cascader :data="models" v-model="search.data" change-on-select v-if='type==="category"'
                                  style="width: 300px;float: left" placeholder="请选择标准分类"></Cascader>
                        <Cascader :data="systems" v-model="search.data" change-on-select v-if='type==="system"'
                                  style="width: 300px;float: left" placeholder="请选择系统分类"></Cascader>
                        <Input v-model="search.keyword" placeholder="请输入Tag关键词" style="width: 300px;float: left"
                               v-if='type==="keyword"' @on-enter="onSearch"></Input>
                        <Input v-model="search.content" placeholder="全文检索" v-if='type==="content"'
                               style="width: 300px;float: left" @on-enter="onSearch"></Input>
                        <Button type="success" style="float: left;margin: 0 20px" @click="onSearch">搜索</Button>


                        <Button type="ghost" size="small" shape="circle" @click="changeType"
                                style="float: left;margin: 5px 20px">切换搜索方式
                            <Icon type="shuffle"></Icon>
                            <span style="color: #00a050">{{ types[type] }}</span>
                        </Button>


                        <!--<Dropdown style="float: right;width: 200px" @on-click="saveResult">-->
                            <!--<Button type="primary">-->
                                <!--全部保存到临时结果集-->
                                <!--<Icon type="arrow-down-b"></Icon>-->
                            <!--</Button>-->
                            <!--<DropdownMenu slot="list">-->
                                <!--<DropdownItem name="A">结果集 A</DropdownItem>-->
                                <!--<DropdownItem name="B">结果集 B</DropdownItem>-->
                                <!--<DropdownItem name="C">结果集 C</DropdownItem>-->
                                <!--<DropdownItem name="D">结果集 D</DropdownItem>-->
                                <!--<DropdownItem name="E">结果集 E</DropdownItem>-->
                            <!--</DropdownMenu>-->
                        <!--</Dropdown>-->
                        <Dropdown style="float: right;width: 200px" @on-click="saveResult">
                            <Button type="primary">
                                当页保存到临时结果集
                                <Icon type="arrow-down-b"></Icon>
                            </Button>
                            <DropdownMenu slot="list">
                                <DropdownItem name="A">结果集 A</DropdownItem>
                                <DropdownItem name="B">结果集 B</DropdownItem>
                                <DropdownItem name="C">结果集 C</DropdownItem>
                                <DropdownItem name="D">结果集 D</DropdownItem>
                                <DropdownItem name="E">结果集 E</DropdownItem>
                            </DropdownMenu>
                        </Dropdown>
                        <!--<Input v-model="search.content" placeholder="全文检索"-->
                        <!--style="width: 300px;float: left;margin-left: 50px" @on-enter="onContent"></Input>-->
                    </Row>
                </Card>

                <Card>
                    <Row class="margin-top-8">
                        <can-edit-table
                                refs="table1"
                                v-model="dataList"
                                :columns-list="columns1"
                                :category="category"
                                :keyword="search.keyword"
                                @spliceExport="spliceExport"
                                @afresh_list="afresh_list"
                                class="margin-bottom-10">
                        </can-edit-table>
                        <Row class="center">
                            <!--<Button type="primary" size="large" @click="exportExcel" style="float: left">-->
                            <!--<Icon type="ios-download-outline"></Icon>-->
                            <!--导出当页数据-->
                            <!--</Button>-->
                            <Page :total="total" show-total @on-change="changePage" :page-size="pageSize"
                                  :page-size-opts="pageSizeOpts" show-sizer show-elevator style="margin-left: -200px"
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


    export default {
        name: 'searchable-table',
        components: {
            canEditTable,
        },
        data() {
            return {
                types: {
                    category: '标准查询',
                    system: '系统查询',
                    keyword: '关键字查询',
                    content: '全文检索',
                },
                type: "category",
                columns1: table.columns1, // 表头
                dataList: [],// 查询结果
                pageSize: 10, // 每页多少条
                total: 0, // 总共多少条数据
                status: null, // 课程状态
                page: 1, // 当前页码
                pageSizeOpts: [10, 20, 50, 80, 100],
                search: {
                    data: [],
                    keyword: ''
                },
                models: [],
                systems: [],
                splices: [],
                category: []
            }
        },
        methods: {
            saveResult(name) {
                let postData = {}

                this.dataList.forEach((item, index) => {
                    this.$set(postData, index, {})

                    let pages = item.page_id.split(',')
                    pages = pages.map(t => this.category[t])
                    let models = item.model_id.split(',')
                    models = models.map(e => this.category[e])


                    this.$set(postData[index], 'user', item.user)
                    this.$set(postData[index], 'type', item.type)
                    this.$set(postData[index], 'standard', item.standard)
                    this.$set(postData[index], 'content', item.content)
                    this.$set(postData[index], 'sentence', item.sentence)
                    this.$set(postData[index], 'sentence_id', item.id)
                    this.$set(postData[index], 'page', pages.join(' / '))
                    this.$set(postData[index], 'model', models.join(' / '))

                    if(this.type == 'keyword' ||  this.type == 'content'){
                        this.$set(postData[index], 'tag', this.search.keyword)
                    }else {
                        let tags = item.tags.map(t => t.tag)
                        this.$set(postData[index], 'tag', tags.join(','))
                    }

                    this.$set(postData[index], 'name', name)
                    this.$set(postData[index], 'type_id', 23)
                    let time = Math.round(new Date().getTime() / 1000).toString()
                    this.$set(postData[index], 'createtime', time)


                })
                this.JAjax.postJson('result/save/page', postData, (res) => {
                    this.$Message.success('保存成功');
                });
            },
            spliceExport(data) {
                this.splices.push(data)
                console.log(this.splices)
            },
            exportExcel() {

                if (this.search.data.length !== 0 || this.search.keyword !== '' || this.search.content !== '') {
                    let param = ""
                    if (this.type === 'category') {
                        param = this.search.data;
                    } else if (this.type === 'keyword') {
                        param = this.search.keyword;
                    } else {
                        param = this.search.content;
                    }
                    window.open('/api/excel/export?keyword=' + param + '&pageSize=' + this.pageSize + '&type=' + this.type + '&splices=' + this.splices)
                }
            },
            onContent() {
                this.type = 'content'
                this.onSearch()
            },
            onSearch() {
                if (this.search.data.length !== 0 || this.search.keyword !== '' || this.search.content !== '') {
                    let postdata = {};
                    postdata.page = this.page;
                    postdata.pageSize = this.pageSize;
                    let index = 0
                    if (this.type === 'category') {
                        postdata.keyword = this.search.data
                        this.JAjax.postJson('search/category', postdata, (res) => {
                            // console.log(res.data.data)
                            this.dataList = res.data.data || [];
                            this.total = res.data.total;
                            this.pageSize = res.data.per_page;
                            this.dataList.forEach((t) => {
                                t.index = index++
                            })
                        });
                    }  else if (this.type === 'system') {
                        postdata.keyword = this.search.data
                        this.JAjax.postJson('search/system', postdata, (res) => {
                            // console.log(res.data.data)
                            this.dataList = res.data.data || [];
                            this.total = res.data.total;
                            this.pageSize = res.data.per_page;
                            this.dataList.forEach((t) => {
                                t.index = index++
                            })
                        });
                    } else if (this.type === 'keyword') {
                        postdata.keyword = this.search.keyword
                        this.JAjax.postJson('search/keyword', postdata, (res) => {
                            // console.log(res.data.data)
                            this.dataList = res.data.data || [];
                            this.total = res.data.total;
                            this.pageSize = res.data.per_page;
                            this.dataList.forEach((t) => {
                                t.index = index++
                            })
                        });
                    } else {
                        postdata.keyword = this.search.content
                        this.JAjax.postJson('search/content', postdata, (res) => {
                            // console.log(res.data.data)
                            this.dataList = res.data.data || [];
                            this.total = res.data.total;
                            this.pageSize = res.data.per_page;
                            this.dataList.forEach((t) => {
                                t.index = index++
                            })
                        });
                    }


                }
            },

            getModel() {
                this.JAjax.postJson('categories/models', {}, (res) => {
                    this.models = res.data || [];
                    this._modelForm(this.models)
                });
            },
            getSystem() {
                this.JAjax.postJson('categories/systems', {}, (res) => {
                    this.systems = res.data || [];
                    this._systemForm(this.systems)
                });
            },
            _modelForm(data) {
                data.forEach(t => {
                    t.children = t.model_child || []
                    t.value = t.id || ''
                    t.label = t.title || ''
                    this._modelForm(t.children)
                })
            },
            _systemForm(data) {
                data.forEach(t => {
                    t.children = t.system_child || []
                    t.value = t.id || ''
                    t.label = t.title || ''
                    this._systemForm(t.children)
                })
            },
            changePage(page) {
                this.page = page;
                this.onSearch()
            },
            changeSize(size) {
                this.pageSize = size;
                this.onSearch()
            },
            afresh_list() {
                this.getModel()
            },
            changeType() {
                if (this.type === 'category') {
                    this.type = 'system'
                } else if (this.type === 'system') {
                    this.type = 'keyword'
                } else if (this.type === 'keyword') {
                    this.type = 'content'
                } else {
                    this.type = 'category'
                }
                this.$router.push({
                    name: 'search-index',
                    params: {
                        type: this.type
                    }
                });

            },
            getType() {
                this.type = this.$route.params.type
            },
            getCategorygetCategory() {
                this.JAjax.postJson('categories', {}, (res) => {
                    this.category = res.data || []
                });
            }
        },
        mounted() {
            this.getModel()
            this.getSystem()
            this.getCategorygetCategory()
            this.type = this.$route.params.type ? this.$route.params.type : this.type
            this.$router.push({
                name: 'search-index',
                params: {
                    type: this.type
                }
            });
            // this.getType()
        },
        updated() {
            this.getType()
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
