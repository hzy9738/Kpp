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
                        <span>结果集导出</span>
                        <Dropdown  style="top: 10px;position: absolute;left: 200px" @on-click="searchName">
                            <Button type="primary" >
                                选择结果集
                                <Icon type="arrow-down-b"></Icon>
                            </Button>
                            <DropdownMenu slot="list"  >
                                <DropdownItem name="A">结果集 A</DropdownItem>
                                <DropdownItem name="B">结果集 B</DropdownItem>
                                <DropdownItem name="C">结果集 C</DropdownItem>
                                <DropdownItem name="D">结果集 D</DropdownItem>
                                <DropdownItem name="E">结果集 E</DropdownItem>
                            </DropdownMenu>
                        </Dropdown>
                    </p>

                </Card>

                <Card>
                    <Row class="margin-top-8">
                        <can-edit-table
                                refs="table1"
                                v-model="dataList"
                                :columns-list="columns1"
                                @spliceExport="spliceExport"
                                @afresh_list="afresh_list"
                                class="margin-bottom-10">
                        </can-edit-table>
                        <Row class="center">
                            <Button type="primary" size="large" @click="exportExcel" style="float: left">
                                <Icon type="ios-download-outline"></Icon>
                                导出所有数据
                            </Button>
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
                splices: [],
                category: [],
                name:'A'
            }
        },
        methods: {
            searchName(name){
                this.name = name
                this.JAjax.postJson('search/result', {name:name}, (res) => {
                    // console.log(res.data.data)
                    this.dataList = res.data.data || [];
                    this.total = res.data.total;
                    this.pageSize = res.data.per_page;
                    this.dataList.forEach((t)=>{
                        t.index = index++
                    })
                });
            },

            spliceExport(data) {
                this.splices.push(data)
                console.log(this.splices)
            },
            exportExcel() {

                if (this.dataList.length !== 0) {
                    window.open('/api/excel/export?keyword=' + this.name + '&pageSize=' + this.pageSize+ '&type=result'  + '&splices='+ this.splices)
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
                            this.dataList.forEach((t)=>{
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
                            this.dataList.forEach((t)=>{
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
                            this.dataList.forEach((t)=>{
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
            _modelForm(data) {
                data.forEach(t => {
                    t.children = t.model_child || []
                    t.value = t.id || ''
                    t.label = t.title || ''
                    this._modelForm(t.children)
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
            getCategory() {
                // this.JAjax.postJson('categories', {}, (res) => {
                //     this.category = res.data || []
                // });
            },
            changeType() {
                if (this.type === 'category') {
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

        },
        mounted() {
            this.getModel()
            this.getCategory()
            this.type = this.$route.params.type ? this.$route.params.type : this.type

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
