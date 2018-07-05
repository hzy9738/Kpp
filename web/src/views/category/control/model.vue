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
                    <span>标准分类</span>
                </p>
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
                dataList:[]

            };
        },
        methods: {
            getlist () {
                let postdata = [];
                this.JAjax.postJson('categories/models', postdata, (res) => {
                    this.dataList = res.data || [];
                    this._formdata(this.dataList)
                });
            },
            afresh_list () {
                this.getlist();
            },

            _formdata (data) {
                data.forEach(t=>{
                    t.children = t.model_child || []
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
