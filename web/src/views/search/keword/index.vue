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
                        <Cascader :data="models" v-model="search.data" change-on-select
                                  style="width: 300px;float: left" placeholder="请选择标准分类"></Cascader>
                        <Button type="success" style="float: left;margin: 0 20px" @click="onSearch">搜索</Button>
                        <Button type="ghost" size="small" shape="circle" icon="shuffle"
                                style="float: left;margin: 5px 20px">切换搜索方式
                        </Button>
                    </Row>
                </Card>

                <Card>
                    <Row class="margin-top-8">
                        <can-edit-table
                                refs="table1"
                                v-model="dataList"
                                :columns-list="columns1"
                                @afresh_list="afresh_list"
                                class="margin-bottom-10">
                        </can-edit-table>
                        <Row class="center">
                            <Button type="primary" size="large" @click="exportExcel" style="float: left"><Icon type="ios-download-outline"></Icon> 导出当页数据 </Button>
                            <Page :total="total" show-total @on-change="changePage" :page-size="pageSize"
                                  :page-size-opts="pageSizeOpts" show-sizer show-elevator   style="margin-left: -200px"
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
                columns1: table.columns1, // 表头
                dataList: [],// 查询结果
                pageSize: 10, // 每页多少条
                total: 0, // 总共多少条数据
                status: null, // 课程状态
                page: 1, // 当前页码
                pageSizeOpts: [10, 20, 50, 80, 100],
                search: {
                    data: []
                },
                models: []
            }
        },
        methods: {
            exportExcel() {
                if (this.search.data !== '') {
                    window.open('/api/excel/export?keyword=' + this.search.data+'&pageSize='+this.pageSize)
                }
            },
            onSearch() {
                let postdata = {};
                postdata.page = this.page;
                postdata.pageSize = this.pageSize;
                postdata.keyword = this.search.data
                this.JAjax.postJson('search/category', postdata, (res) => {
                    // console.log(res.data.data)
                    this.dataList = res.data.data || [];
                    this.total = res.data.total;
                    this.pageSize = res.data.per_page;
                });
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
        },
        mounted() {
            this.getModel()
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
