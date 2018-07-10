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
                        <Input v-model="search.data" style="width: 300px;float: left">
                            <Button slot="append" icon="ios-search" ></Button>
                        </Input>
                        <Button type="ghost" size="small" shape="circle" icon="shuffle" style="float: left;margin: 0 20px">切换搜索方式</Button>

                    </Row>
                </Card>
            </Col>



        </Row>
    </div>
</template>

<script>
    import canEditTable from './components/canEditTable.vue';
    import sourceTable from './components/source-table.vue';
    import * as table from './data/search';


    export default {
        name: 'searchable-table',
        components: {
            canEditTable,
            sourceTable
        },
        data() {
            return {
                search:{
                    data:''
                }
            }
        },
        methods: {

        },
        mounted() {

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
